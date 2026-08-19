<?php

namespace App\Http\Controllers;

use App\Models\documents;
use App\Models\families;
use App\Models\guardian;
use App\Models\orphans;
use App\Models\Sponsor;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Models\User;
use App\Notifications\BroadcastAnnouncement;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

// استدعاء ملفات الفالديشن الجديدة
use App\Http\Requests\ApproveOrphanRequest;
use App\Http\Requests\RejectOrphanRequest;
use App\Http\Requests\UpdateSponsorRequest;
use App\Http\Requests\RejectDocumentRequest;
use App\Http\Requests\SendBroadcastRequest;
use App\Http\Requests\UploadLogoRequest;

class AdminController extends Controller
{
    // عرض لوحة التحكم العامة للآدمن
    public function dashboard_admin()
    {
        // 1️⃣ الكروت الإحصائية
        $totalOrphansCount = orphans::count();
        $activeSponsorshipsCount = Sponsorship::whereIn('status', ['نشط', 'ساري', 'مكفول'])->count();

        // حوالات الشهر الحالي
        $currentMonthPaymentsSum = Sponsorship::where('payment_status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount_paid');

        $waitingOrphansCount = orphans::whereIn('status', ['بانتظار الكفالة', 'بانتظار كفيل', 'جديد'])->count();

        // 2️⃣ بيانات الرسم البياني للواردات الشهرية (آخر 6 أشهر)[cite: 18]
        $monthsLabels = [];
        $monthlyPaymentsData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            // استخدام اسم الشهر باللغة العربية[cite: 18]
            $monthsLabels[] = $date->locale('ar')->translatedFormat('F');

            $sum = Sponsorship::where('payment_status', 'paid')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('amount_paid');

            $monthlyPaymentsData[] = (float) $sum;
        }

        // 3️⃣ حساب الأيتام/الكفالات (الموقوفة أو المرفوضة)
        $pausedOrphansCount = orphans::whereIn('status', ['موقوف', 'موقوفة', 'مرفوض', 'مرفوضة'])->count();
        $pausedSponsorshipsCount = Sponsorship::whereIn('status', ['موقوف', 'موقوفة', 'مرفوض', 'مرفوضة'])->count();

        // إجمالي غير النشطين/المرفوضين/الموقوفين
        $inactiveTotal = max($pausedOrphansCount, $pausedSponsorshipsCount);

        // الترتيب: [كفالات نشطة, بانتظار كفيل, موقوفة / مرفوضة]
        $distributionData = [
            $activeSponsorshipsCount,
            $waitingOrphansCount,
            $inactiveTotal
        ];

        // 4️⃣ آخر العمليات والسجلات
        $recentAuditLogs = AuditLog::with('user')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrphansCount',
            'activeSponsorshipsCount',
            'currentMonthPaymentsSum',
            'waitingOrphansCount',
            'monthsLabels',
            'monthlyPaymentsData',
            'distributionData',
            'recentAuditLogs'
        ));
    }

    // عرض قائمة الأيتام بالكامل
    public function orphans_admin()
    {
        $data = orphans::paginate(10);
        return view('admin.orphans', compact('data'));
    }

    // تفاصيل اليتيم
    public function Orphan_Details(string $id)
    {
        $orphan = orphans::with(['guardian', 'parents', 'housing', 'financial_data', 'documents'])->findOrFail($id);
        return view('admin.orphan_details', compact('orphan'));
    }

    // 1️⃣ قبول الطفل وتحديد مبلغ الكفالة وإشعار الوصي
    public function approveOrphan(ApproveOrphanRequest $request, string $id)
    {
        $orphan = orphans::findOrFail($id);
        $orphan->status = 'بانتظار الكفالة';
        $orphan->required_amount = $request->required_amount;
        $orphan->save();

        $guardian = guardian::find($orphan->guardian_id) ?? guardian::where('orphan_id', $orphan->id)->latest()->first();

        if ($guardian && $guardian->user_id) {
            $user = User::find($guardian->user_id);
            if ($user) {
                $user->notify(new BroadcastAnnouncement(
                    'تم قبول طلب إضافة الطفل',
                    'توثيق',
                    "تمت الموافقة على طلب تسجيل الطفل ({$orphan->name}). مبلغ الكفالة المحدد هو: {$request->required_amount} $"
                ));
            }
        }

        return redirect()->back()->with('success', 'تم قبول الطلب وإرسال الإشعار للوصي.');
    }

    // 2️⃣ رفض الطفل وإشعار الوصي
    public function rejectOrphan(RejectOrphanRequest $request, string $id)
    {
        $orphan = orphans::findOrFail($id);
        $orphan->status = 'مرفوض';
        $orphan->save();

        $guardian = guardian::find($orphan->guardian_id) ?? guardian::where('orphan_id', $orphan->id)->latest()->first();

        if ($guardian && $guardian->user_id) {
            $user = User::find($guardian->user_id);
            if ($user) {
                $user->notify(new BroadcastAnnouncement(
                    'رفض طلب تسجيل طفل',
                    'تنبيه',
                    "تم رفض طلب إضافة الطفل ({$orphan->name}). السبب: " . ($request->reject_reason ?? 'عدم استيفاء الشروط المحددة.')
                ));
            }
        }

        return redirect()->back()->with('success', 'تم رفض الطلب وإرسال الإشعار للوصي.');
    }

    public function families()
    {
        $families = guardian::withCount('orphans')
            ->with(['user', 'housing'])
            ->paginate(10);

        return view('admin.families', compact('families'));
    }

    // 3️⃣ المصادقة على العائلة وإشعار الوصي
    public function approveFamily(string $id)
    {
        $guardian = guardian::findOrFail($id);
        $guardian->status = 'مصدق';
        $guardian->save();

        if ($guardian->user_id) {
            $user = User::find($guardian->user_id);
            if ($user) {
                $user->notify(new BroadcastAnnouncement(
                    'توثيق حساب العائلة',
                    'توثيق',
                    "تمت المصادقة على ملف العائلة الخاص بكم بنجاح (FAM-" . (100 + $guardian->id) . ")، ويمكنكم الآن استخدام كافة صلاحيات المنصة وإضافة الأيتام."
                ));
            }
        }

        return redirect()->back()->with('success', 'تمت المصادقة على العائلة وإرسال إشعار للوصي بنجاح.');
    }

    // 4️⃣ رفض العائلة وإشعار الوصي
    public function rejectFamily(string $id)
    {
        $guardian = guardian::findOrFail($id);
        $guardian->status = 'مرفوض';
        $guardian->save();

        if ($guardian->user_id) {
            $user = User::find($guardian->user_id);
            if ($user) {
                $user->notify(new BroadcastAnnouncement(
                    'رفض طلب توثيق العائلة',
                    'توثيق',
                    "للأسف، تعذر قبول ملف العائلة الخاص بكم (FAM-" . (100 + $guardian->id) . "). يرجى مراجعة البيانات المرفقة أو التواصل مع الإدارة."
                ));
            }
        }

        return redirect()->back()->with('success', 'تم شطب/رفض الطلب وإشعار الوصي بالنتيجة.');
    }

    public function showSponsors()
    {
        $sponsors = Sponsor::withCount('sponsorships')->paginate(10);
        return view('admin.sponsors', compact('sponsors'));
    }

    public function updateSponsor(UpdateSponsorRequest $request, string $id)
    {
        $sponsor = Sponsor::findOrFail($id);

        $sponsor->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'country' => $request->country ?? $sponsor->country,
            'city'    => $request->city ?? $sponsor->city,
        ]);

        return redirect()->back()->with('success', 'تم تحديث بيانات الكافل بنجاح.');
    }

    // 5️⃣ تجميد/تفعيل حساب الكافل وإرسال إشعار له وللوصي
    public function toggleSponsorStatus(Request $request, string $id)
    {
        // جلب الكفيل بناءً على الـ ID الممرر
        $sponsor = Sponsor::findOrFail($id);

        if (($sponsor->status ?? 'active') === 'active') {
            $sponsor->status = 'inactive';
            $message = 'تم تجميد/تعليق حساب الكافل بنجاح.';

            if ($sponsor->user_id) {
                $user = User::find($sponsor->user_id);
                if ($user) {
                    $user->notify(new BroadcastAnnouncement(
                        'تعليق الحساب',
                        'تنبيه',
                        "مرحباً {$sponsor->name}، تم تعليق حسابك ككافل مؤقتاً. يرجى التواصل مع إدارة المنصة للمزيد من التفاصيل."
                    ));
                }
            }
        } else {
            $sponsor->status = 'active';
            $message = 'تم إعادة تفعيل حساب الكافل بنجاح.';

            // إرسال إشعار للكافل
            if ($sponsor->user_id) {
                $user = User::find($sponsor->user_id);
                if ($user) {
                    $user->notify(new BroadcastAnnouncement(
                        'تنشيط الحساب',
                        'تحديث',
                        "مرحباً {$sponsor->name}، تم إعادة تنشيط حسابك بنجاح. يمكنك الآن متابعة كفالاتك والخدمات المتاحة."
                    ));
                }
            }
        }

        $sponsor->save();

        return redirect()->back()->with('success', $message);
    }

    public function sponsorships_admin()
    {
        $latestIds = Sponsorship::select(DB::raw('MAX(id) as id'))
            ->groupBy('orphan_id')
            ->pluck('id');

        $sponsorships = Sponsorship::with(['orphan', 'sponsor.user'])
            ->whereIn('id', $latestIds)
            ->latest()
            ->paginate(10);

        return view('admin.sponsorships', compact('sponsorships'));
    }

    public function payments_admin()
    {
        $payments = Sponsorship::with(['orphan', 'sponsor'])->paginate(10);
        $total_amount = Sponsorship::where('payment_status', 'paid')->sum('amount_paid');
        $payments_count = Sponsorship::count();

        return view('admin.payments', compact('payments', 'total_amount', 'payments_count'));
    }

    // 6️⃣ اعتماد وتفويض الدفعة المالية وإرسال إشعار للكافل وللوصي
    public function approve_payment(Request $request, string $id)
    {
        $payment = Sponsorship::with(['orphan.guardian', 'sponsor.user'])->findOrFail($id);

        $payment->update([
            'payment_status' => 'paid',
            'last_batch' => now()
        ]);

        $orphanName = $payment->orphan->name ?? 'الطفل';

        if ($payment->sponsor && $payment->sponsor->user_id) {
            $sponsorUser = User::find($payment->sponsor->user_id);
            if ($sponsorUser) {
                $sponsorUser->notify(new BroadcastAnnouncement(
                    'تأكيد الدفعة المالية',
                    'مالية',
                    "تم تأكيد واعتماد دفعتكم المالية بنجاح لصالح كفالة الطفل ({$orphanName})."
                ));
            }
        }

        if ($payment->orphan) {
            $guardian = guardian::find($payment->orphan->guardian_id) ?? guardian::where('orphan_id', $payment->orphan->id)->latest()->first();

            if ($guardian && $guardian->user_id) {
                $guardianUser = User::find($guardian->user_id);
                if ($guardianUser) {
                    $guardianUser->notify(new BroadcastAnnouncement(
                        'استلام مستحقات كفالة',
                        'مالية',
                        "تم اعتماد وإيداع الدفعة المالية الخاصة بكفالة الطفل ({$orphanName})."
                    ));
                }
            }
        }

        return redirect()->back()->with('success', 'تم تفعيل وتفويض الدفعة المالية وإشعار الأطراف بنجاح.');
    }

    public function delete_payment(string $id)
    {
        $payment = Sponsorship::with(['orphan.guardian', 'sponsor.user'])->findOrFail($id);

        $orphanName = $payment->orphan->name ?? 'الطفل المكفول';

        if ($payment->sponsor && $payment->sponsor->user_id) {
            $sponsorUser = User::find($payment->sponsor->user_id);
            if ($sponsorUser) {
                $sponsorUser->notify(new BroadcastAnnouncement(
                    'رفض المعاملة المالية',
                    'مالية',
                    "تم رفض وشطب المعاملة المالية الخاصة بكفالة الطفل ({$orphanName}). يرجى التأكد من تفاصيل الدفع وإعادة العملية إذا لزم الأمر."
                ));
            }
        }

        if ($payment->orphan) {
            $guardian = guardian::find($payment->orphan->guardian_id)
                ?? guardian::where('orphan_id', $payment->orphan->id)->latest()->first();

            if ($guardian && $guardian->user_id) {
                $guardianUser = User::find($guardian->user_id);
                if ($guardianUser) {
                    $guardianUser->notify(new BroadcastAnnouncement(
                        'تأخير في دفعة المستحقات',
                        'مالية',
                        "نعتذر لكم، قد تتأخر دفعة الشهر الحالي الخاصة بالطفل ({$orphanName}) نظرًا لعدم اكتمال المعاملة المالية الأخيرة، ونعمل على معالجتها في أقرب وقت."
                    ));
                }
            }
        }

        $payment->delete();

        return redirect()->back()->with('success', 'تم شطب المعاملة المالية من السجل بنجاح وإشعار الكافل والوصي.');
    }

    public function documents_admin()
    {
        $documents = documents::with('orphan')->get();
        return view('admin.documentation', compact('documents'));
    }

    // 7️⃣ اعتماد وتفويض المستند وإرسال إشعار للوصي مباشرة
    public function approve_document(string $id)
    {
        $document = documents::with('orphan')->findOrFail($id);
        $document->update(['status' => 'مقبول']);

        $orphanName = $document->orphan->name ?? 'الطفل';
        $docTitle = $document->title ?? 'مستند جديد';

        if ($document->orphan) {
            $guardian = guardian::find($document->orphan->guardian_id) ?? guardian::where('orphan_id', $document->orphan->id)->latest()->first();

            if ($guardian && $guardian->user_id) {
                $user = User::find($guardian->user_id);
                if ($user) {
                    $user->notify(new BroadcastAnnouncement(
                        'تم قبول واستيعاب الوثيقة',
                        'توثيق',
                        "تمت الموافقة والاعتماد النهائي على مستند ({$docTitle}) المرفق للطفل ({$orphanName})."
                    ));
                }
            }

            $sponsorship = Sponsorship::with('sponsor')
                ->where('orphan_id', $document->orphan->id)
                ->first();

            if ($sponsorship && $sponsorship->sponsor && $sponsorship->sponsor->user_id) {
                $sponsorUser = User::find($sponsorship->sponsor->user_id);
                if ($sponsorUser) {
                    $sponsorUser->notify(new BroadcastAnnouncement(
                        'إضافة مستند جديد للمكفول',
                        'تحديث',
                        "تمت إضافة واعتمد ملف جديد من نوع ({$docTitle}) للطفل المكفول ({$orphanName})."
                    ));
                }
            }
        }

        return redirect()->back()->with('success', 'تم اعتماد المستند وإشعار الوصي والكافل بنجاح.');
    }

    // 8️⃣ رفض المستند المرفوع وإرسال الإشعار للوصي مباشرة
    public function reject_document(RejectDocumentRequest $request, string $id)
    {
        $document = documents::with('orphan')->findOrFail($id);
        $reason = $request->input('rejection_reason') ?? 'عدم وضوح المستند أو وجود خطأ في البيانات المرفقة';
        $document->update(['status' => 'مرفوض']);

        $orphanName = $document->orphan->name ?? 'الطفل';

        if ($document->orphan) {
            $guardian = guardian::find($document->orphan->guardian_id) ?? guardian::where('orphan_id', $document->orphan->id)->latest()->first();

            if ($guardian && $guardian->user_id) {
                $user = User::find($guardian->user_id);
                if ($user) {
                    $user->notify(new BroadcastAnnouncement(
                        'تم رفض المستند المرفوع',
                        'تنبيه توثيق',
                        "تعذر قبول مستند ({$document->title}) للطفل ({$orphanName}). سبب الرفض: ({$reason}). يرجى إعادة رفعه."
                    ));
                }
            }
        }

        return redirect()->back()->with('danger', 'تم رفض المستند وإرسال الإشعار للوصي بالتفاصيل.');
    }

    public function reports_admin()
    {
        return view('admin.reports');
    }

    public function generate_report(Request $request)
    {
        $type = $request->input('report_type');
        $period = $request->input('report_period');
        $fileName = 'kanaf_report_' . time() . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($type, $period) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['مركز كنف لإصدار التقارير الحيوية والمالية']);
            fputcsv($file, ['نوع التقرير المطلق:', $type]);
            fputcsv($file, ['النطاق الزمني للمعالجة:', $period]);
            fputcsv($file, ['تاريخ التوليد الفوري:', now()->toDateTimeString()]);
            fputcsv($file, []);

            fputcsv($file, ['--- ملخص وإحصائيات المنظومة الشاملة ---']);
            fputcsv($file, ['إجمالي عدد الأيتام المسجلين بالمنظومة', orphans::count() . ' طفل']);
            fputcsv($file, ['إجمالي المستندات والتقارير المرفوعة', documents::count() . ' مستند']);
            fputcsv($file, ['إجمالي الحوالات والمدفوعات المالية المرصودة', Sponsorship::count() . ' حوالة']);
            fputcsv($file, ['إجمالي المبالغ والتحصيلات الخيرية المقبوضة', Sponsorship::where('payment_status', 'paid')->sum('amount_paid') . ' دولار']);
            fputcsv($file, []);

            if ($type == 'كشف الواردات والصافي المالي المركزي') {
                fputcsv($file, ['سجل الدفعات والتحصيلات المركزية المدققة']);
                fputcsv($file, ['معرف المعاملة', 'المبلغ المودع', 'الحالة', 'التاريخ']);

                $payments = Sponsorship::latest()->take(50)->get();
                foreach ($payments as $payment) {
                    fputcsv($file, [
                        $payment->transaction_id ?? 'TRX-' . $payment->id,
                        $payment->amount_paid . ' $',
                        $payment->payment_status == 'paid' ? 'مؤكدة' : 'قيد المراجعة',
                        $payment->start_date
                    ]);
                }
            } else {
                fputcsv($file, ['قائمة الأيتام المدرجين حديثاً للرقابة والمتابعة']);
                fputcsv($file, ['رقم الطفل', 'اسم اليتيم', 'تاريخ التسجيل']);

                $children = orphans::latest()->take(50)->get();
                foreach ($children as $child) {
                    fputcsv($file, [
                        $child->id,
                        $child->name ?? $child->first_name,
                        $child->created_at ? $child->created_at->format('Y-m-d') : now()->format('Y-m-d')
                    ]);
                }
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function download_ready_report(string $file)
    {
        $title = $file == 'annual_report_2025.pdf' ? 'التقرير السنوي الشامل لجمعية كنف لعام 2025' : 'التحليل المالي السريع لملخص التحصيلات Q1';

        $content = "==================================================\n";
        $content .= "         منصة كَنَفْ لرعاية وكفالة الأيتام         \n";
        $content .= "         " . $title . "         \n";
        $content .= "==================================================\n\n";
        $content .= "تاريخ استخراج التقرير الأمني المعتمد: " . now()->format('Y-m-d H:i:s') . "\n";
        $content .= "حالة البيانات الحالية: محدثة وتعمل بانتظام دقيق.\n\n";
        $content .= "--------------------------------------------------\n";
        $content .= "1. إحصائيات الدعم الاجتماعي:\n";
        $content .= "   - عدد الحالات النشطة: " . orphans::count() . " يتيم مكفول.\n";
        $content .= "   - التقارير الصحية والتعليمية المدققة: " . documents::where('status', 'مقبول')->count() . " تقرير معتمد.\n\n";
        $content .= "2. كفاءة الأداء المالي والتحصيلي:\n";
        $content .= "   - صافي المبالغ والتحصيلات الخيرية: " . Sponsorship::where('payment_status', 'paid')->sum('amount_paid') . " USD.\n";
        $content .= "   - نسبة الاستقطاع والتشغيل لليتيم: 100% تبرع كامل لخدمة مستفيدي كنف.\n";
        $content .= "--------------------------------------------------\n";
        $content .= "تم إصدار هذا الملخص بشكل مؤمن وتلقائي من خوادم النظام لتأكيد التماسك الإداري للجمعية.\n";

        $downloadName = $file == 'annual_report_2025.pdf' ? 'Kanaf-Annual-Report-2025.txt' : 'Kanaf-Financial-Analysis-Q1.txt';

        return response($content)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $downloadName . '"');
    }

    public function adminIndex()
    {
        $broadcasts = DB::table('notifications')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return [
                    'data' => json_decode($item->data, true),
                    'created_at' => $item->created_at,
                    'notifiable_type' => $item->notifiable_type
                ];
            })
            ->unique(function ($item) {
                return ($item['data']['title'] ?? '') . ($item['data']['body'] ?? '');
            })
            ->take(10);

        return view('admin.notifications', compact('broadcasts'));
    }

    public function sendBroadcast(SendBroadcastRequest $request)
    {
        $users = User::where('role', $request->user_type)->get();
        if ($request->user_type === 'all') {
            $users = User::all();
        }

        Notification::send($users, new BroadcastAnnouncement($request->title, $request->type, $request->body));

        return redirect()->back()->with('success', 'تم إطلاق التنبيه بنجاح!');
    }

    public function users_index()
    {
        $users = User::orderBy('created_at', 'asc')->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function toggleStatus(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        if (($user->status ?? 'active') === 'active') {
            $user->status = 'inactive';
            $message = 'تم تجميد حساب المستخدم بنجاح.';

            $user->notify(new BroadcastAnnouncement(
                'تجميد الحساب',
                'تنبيه',
                'تم تجميد حسابك على المنصة. يرجى مراجعة إدارة المنصة لمعرفة التفاصيل والتفعيل.'
            ));
        } else {
            $user->status = 'active';
            $message = 'تم تنشيط حساب المستخدم بنجاح.';

            $user->notify(new BroadcastAnnouncement(
                'تنشيط الحساب',
                'تحديث',
                'تم إعادة تنشيط حسابك بنجاح. يمكنك الآن استخدام كافة الخدمات على المنصة.'
            ));
        }

        $user->save();

        return redirect()->back()->with('success', $message);
    }

    public function audit_logs_admin()
    {
        $logs = AuditLog::with('user')
            ->orderBy('id', 'asc')
            ->paginate(15);

        return view('admin.audit-log', compact('logs'));
    }

    // أرشفة وتطهير السجلات (تفريغ سجلات التدقيق)
    public function clearAuditLogs()
    {
        // حذف كافة السجلات الموجودة في جدول AuditLog
        AuditLog::truncate();

        return redirect()->back()->with('success', 'تمت أرشفة وتطهير جميع سجلات التدقيق بنجاح.');
    }

    public function permissions()
    {
        return view('admin.permissions');
    }

    public function settings_index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        $users = User::latest()->take(10)->get();
        return view('admin.settings', compact('settings', 'users'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return redirect()->back()->with('success', 'تم حفظ جميع التغييرات بنجاح.');
    }

    public function uploadLogo(UploadLogoRequest $request)
    {
        if ($request->hasFile('org_logo')) {
            $oldLogo = Setting::get('org_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }
            $path = $request->file('org_logo')->store('assets/images', 'public');
            Setting::updateOrCreate(['key' => 'org_logo'], ['value' => $path]);
        }

        return redirect()->back()->with('success', 'تم تحديث شعار المنظمة الرسمي بنجاح.');
    }
}
