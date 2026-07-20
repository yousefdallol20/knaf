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
use Illuminate\Support\Facades\DB; // تم تعديل مسار الـ DB هنا بشكل صحيح
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    // عرض لوحة التحكم العامة للآدمن
    public function dashboard_admin()
    {
        return view('admin.dashboard');
    }

    // عرض قائمة الأيتام بالكامل في لوحة التحكم
    public function orphans_admin()
    {
        $data = orphans::all();
        return view('admin.orphans', compact('data'));
    }

    // عرض التفاصيل الكاملة ليتيم محدد مع كافة بيانات عائلته وسكنه والوثائق
    public function Orphan_Details(string $id)
    {
        // جلب اليتيم مع العلاقات المحددة في الموديل
        $orphan = orphans::with(['guardian', 'parents', 'housing', 'financial', 'documents'])->findOrFail($id);

        return view('admin.orphan_details', compact('orphan'));
    }

    // إجراء قبول واعتماد طلب اليتيم وتحديد مبلغ الكفالة
    public function approveOrphan(Request $request, string $id)
    {
        // جلب اليتيم أو إظهار 404 إذا لم يكن موجوداً
        $orphan = orphans::findOrFail($id);

        // تغيير الحالة إلى "غير مكفول / بانتظار كفيل" ليظهر في الجدول
        $orphan->status = 'approved_unsponsored';

        // إذا كنت تريد حفظ مبلغ الكفالة الذي تم تحديده في الفورم
        if ($request->has('sponsorship_amount')) {
            $orphan->sponsorship_amount = $request->input('sponsorship_amount');
        }

        $orphan->save();

        return redirect()->route('orphans_admin')->with('success', 'تم اعتماد طلب اليتيم بنجاح وهو الآن بانتظار كفيل.');
    }

    // إجراء رفض الطلب (سواء رفض مؤقت للتعديل أو رفض نهائي للأرشفة)
    public function rejectOrphan(Request $request, string $id)
    {
        $orphan = orphans::findOrFail($id);

        // تغيير الحالة إلى "rejected" لكي يختفي تلقائياً من الجدول بناءً على الشرط الذي وضعناه
        $orphan->status = 'rejected';

        // إذا كنت تريد حفظ سبب الرفض في قاعدة البيانات
        if ($request->has('rejection_reason')) {
            $orphan->rejection_reason = $request->input('rejection_reason');
        }

        $orphan->save();

        return redirect()->route('orphans_admin')->with('error', 'تم رفض الطلب بنجاح وإلغاؤه من القائمة.');
    }

    public function families()
    {
        // جلب الأوصياء مع حساب عدد الأيتام التابعين لكل وصي عبر علاقة orphans
        $families = guardian::withCount('orphans')->get();

        return view('admin.families', compact('families'));
    }

    public function showSponsors()
    {
        // جلب جميع الكفلاء مع حساب عدد الكفالات النشطة المرتبطة بهم
        // تفترض وجود علاقة باسم orphans أو sponsorships في موديل Sponsor لحساب عدد الكفالات
        $sponsors = Sponsor::withCount('sponsorships')->get();
        return view('admin.sponsors', compact('sponsors'));
    }

    public function sponsorships_admin()
    {
        // جلب الكفالات مع بيانات اليتيم وبيانات الكفيل المرتبطة بكل عقد
        $sponsorships = Sponsorship::with(['orphan', 'sponsor'])->get();

        return view('admin.sponsorships', compact('sponsorships'));
    }

    // 1. دالة عرض صفحة الحسابات والمدفوعات
    public function payments_admin()
    {
        // جلب جميع السجلات مع علاقة اليتيم والكفيل
        $payments = Sponsorship::with(['orphan', 'sponsor'])->get();

        // حساب إجمالي التحصيلات المقبوضة (فقط المدفوعة paid)
        $total_amount = Sponsorship::where('payment_status', 'paid')->sum('amount_paid');

        // حساب عدد الحوالات أو الدفعات الإجمالية المرصودة بالمنظومة
        $payments_count = Sponsorship::count();

        return view('admin.payments', compact('payments', 'total_amount', 'payments_count'));
    }

    // 2. دالة الموافقة وتفويض الدفعة (تغيير الحالة من pending إلى paid)
    public function approve_payment(string $id)
    {
        $payment = Sponsorship::findOrFail($id);
        $payment->update([
            'payment_status' => 'paid',
            'last_batch' => now() // تحديث تاريخ آخر دفعة تم التحقق منها
        ]);

        return redirect()->back()->with('success', 'تم تفعيل وتفويض الدفعة المالية بنجاح.');
    }

    // 3. دالة شطب/حذف المعاملة المالية
    public function delete_payment(string $id)
    {
        $payment = Sponsorship::findOrFail($id);
        $payment->delete();

        return redirect()->back()->with('success', 'تم شطب المعاملة المالية من السجل بنجاح.');
    }

    public function documents_admin()
    {
        // جلب الوثائق مع بيانات الطفل المكفول المرتبط بها
        $documents = documents::with('orphan')->get();

        return view('admin.documentation', compact('documents'));
    }

    // 2. اعتماد وتفويض المستند المرفوع
    public function approve_document(string $id)
    {
        $document = documents::findOrFail($id);
        $document->update([
            'status' => 'مقبول' // تحويل الحالة إلى مقبول بناءً على خيارات الـ Enum في الـ Migration
        ]);

        return redirect()->back()->with('success', 'تم اعتماد وصياغة المستند بنجاح.');
    }

    // 3. رفض المستند المرفوع
    public function reject_document(string $id)
    {
        $document = documents::findOrFail($id);
        $document->update([
            'status' => 'مرفوض' // تحويل الحالة إلى مرفوض بناءً على خيارات الـ Enum في الـ Migration
        ]);

        return redirect()->back()->with('danger', 'تم رفض المستند وإشعار الوصي لتعديله.');
    }

    public function reports_admin()
    {
        return view('admin.reports');
    }

    // 1. زر "معالجة وتوليد التقرير الحيوي" (توليد ملف CSV/Excel ديناميكي تلقائي)
    public function generate_report(Request $request)
    {
        $type = $request->input('report_type');
        $period = $request->input('report_period');

        // اسم الملف الذي سيتم تحميله للمستخدم
        $fileName = 'kanaf_report_' . time() . '.csv';

        // تجهيز الترويسة والعناوين الخاصة بملف الاكسل
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // بناء دالة التوليد وكتابة البيانات والتلخيصات بداخل الملف
        $callback = function () use ($type, $period) {
            $file = fopen('php://output', 'w');

            // لإجبار إكسل على قراءة اللغة العربية بشكل صحيح (BOM)
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // سطر العنوان الرئيسي في الاكسل
            fputcsv($file, ['مركز كنف لإصدار التقارير الحيوية والمالية']);
            fputcsv($file, ['نوع التقرير المطلق:', $type]);
            fputcsv($file, ['النطاق الزمني للمعالجة:', $period]);
            fputcsv($file, ['تاريخ التوليد الفوري:', now()->toDateTimeString()]);
            fputcsv($file, []); // سطر فارغ للترتيب

            // بناء التلخيصات وإحصائيات النظام ديناميكياً
            fputcsv($file, ['--- ملخص وإحصائيات المنظومة الشاملة ---']);
            fputcsv($file, ['إجمالي عدد الأيتام المسجلين بالمنظومة', orphans::count() . ' طفل']);
            fputcsv($file, ['إجمالي المستندات والتقارير المرفوعة', documents::count() . ' مستند']);
            fputcsv($file, ['إجمالي الحوالات والمدفوعات المالية المرصودة', Sponsorship::count() . ' حوالة']);
            fputcsv($file, ['إجمالي المبالغ والتحصيلات الخيرية المقبوضة', Sponsorship::where('payment_status', 'paid')->sum('amount_paid') . ' دولار']);
            fputcsv($file, []); // سطر فارغ

            // إذا طلب المستخدم كشف الواردات المالي، ندرج له جدول تفصيلي بالعمليات المالية
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
                // تقرير الأيتام أو كفاءة الدفعات (جدول افتراضي للأيتام الجدد)
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

        // إرجاع الملف فوراً للمتصفح ليبدأ التحميل التلقائي للاكسل
        return Response::stream($callback, 200, $headers);
    }

    // 2. أزرار "التحميل السريع الجاهز" (التقرير السنوي الشامل والتحليل المالي)
    public function download_ready_report($file)
    {
        // توليد تلخيص فوري سريع للتقارير السنوية الجاهزة للتنزيل بصيغة ملف نصي/PDF ذكي
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

        // اسم الملف الراجع للمستخدم عند الضغط
        $downloadName = $file == 'annual_report_2025.pdf' ? 'Kanaf-Annual-Report-2025.txt' : 'Kanaf-Financial-Analysis-Q1.txt';

        return response($content)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="' . $downloadName . '"');
    }





    // عرض صفحة الإدارة وسجل الإشعارات المرسلة (بدون تكرار)
    public function adminIndex()
    {
        // جلب الإشعارات وتجميعها لمنع التكرار البصري في لوحة الإدارة
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
            // التصفية بناءً على العنوان ونص الرسالة الفريدين
            ->unique(function ($item) {
                return ($item['data']['title'] ?? '') . ($item['data']['body'] ?? '');
            })
            // أخذ آخر 10 إعلانات فريدة فقط لعرضها
            ->take(10);

        return view('admin.notifications', compact('broadcasts'));
    }

    // إرسال الإشعار الجماعي من الأدمن
    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'user_type' => 'required|string',
            'type' => 'required|string',
            'body' => 'required|string',
        ]);

        // تحديد الفئة المستهدفة بناءً على الخيار
        $users = User::where('role', $request->user_type)->get();

        // إرسال الإشعار لجميع المستخدمين المستهدفين دفعة واحدة
        Notification::send($users, new BroadcastAnnouncement($request->title, $request->type, $request->body));

        return redirect()->back()->with('success', 'تم إطلاق التنبيه بنجاح في البوابة كافة!');
    }

    // عرض صفحة المستخدمين
    public function users_index()
    {
        $users = User::orderBy('created_at', 'asc')->paginate(10);

        return view('admin.users', compact('users'));
    }

    // تجميد أو تنشيط حساب العضو
    public function toggleStatus(string $id)
    {
        $user = User::findOrFail($id);

        // التبديل بين الحالتين active و suspended
        if ($user->status === 'active') {
            $user->status = 'suspended';
        } else {
            $user->status = 'active';
        }

        $user->save();

        return redirect()->back()->with('success', 'تم تحديث حالة الحساب بنجاح.');
    }

    // عرض صفحة الإدارة وسجل العمليات الأمني الفعلي تنازلياً
    public function audit_logs_admin()
    {
        // جلب السجلات مع علاقة المستخدم وترتيبها تنازلياً من الأحدث للأقدم
        $logs = \App\Models\AuditLog::with('user')
            ->orderBy('id', 'asc')
            ->paginate(15);

        // تمرير المتغير $logs إلى كود صفحة الـ Blade
        return view('admin.audit-log', compact('logs'));
    }

    public function permissions()
    {
        return view('admin.permissions');
    }


    public function settings_index()
    {
        // جلب الإعدادات وتحويلها لمصفوفة مفاتيح وقيم ليسهل استدعاؤها في الـ Blade
        $settings = Setting::pluck('value', 'key')->toArray();

        // جلب المستخدمين الحقيقيين لعرضهم في جدول الصلاحيات
        $users = User::latest()->take(10)->get();

        return view('admin.settings', compact('settings', 'users'));
    }

    // تحديث كافة إعدادات أزواج المفاتيح والقيم ديناميكياً
    public function update(Request $request)
    {
        // استثناء الـ token الخاص بالحماية من الحفظ
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            // تحديث الإعداد إذا كان موجوداً أو إنشاؤه إذا كان جديداً
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('success', 'تم حفظ جميع التغييرات بنجاح.');
    }

    // معالجة ورفع الشعار الرسمي للمنظمة
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'org_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('org_logo')) {
            // حذف الشعار القديم إن وجد
            $oldLogo = Setting::get('org_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            // تخزين الملف الجديد
            $path = $request->file('org_logo')->store('assets/images', 'public');

            // حفظ المسار في جدول الإعدادات
            Setting::updateOrCreate(['key' => 'org_logo'], ['value' => $path]);
        }

        return redirect()->back()->with('success', 'تم تحديث شعار المنظمة الرسمي بنجاح.');
    }
}
