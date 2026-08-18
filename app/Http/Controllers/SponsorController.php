<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManualPaymentRequest;
use App\Http\Requests\UpdateSponsorProfileRequest;
use App\Http\Requests\UpdateSponsorPasswordRequest;
use App\Models\AuditLog;
use App\Models\documents;
use App\Models\guardian;
use App\Models\orphans;
use App\Models\Sponsor;
use App\Models\Sponsorship;
use App\Models\User;
use App\Notifications\BroadcastAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SponsorController extends Controller
{
    /**
     * لوحة تحكم الكافل - عرض الإحصائيات العامة
     */
    public function dashboard_sponsor()
    {
        $user = Auth::user();

        $sponsor = $user->sponsor ?? Sponsor::where('email', $user->email)->first();

        if ($sponsor && !$sponsor->user_id) {
            $sponsor->update(['user_id' => $user->id]);
        }

        if (!$sponsor) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'login_error' => 'حسابك مسجل كـ Sponsor ولكن لا يوجد لك سجل بيانات كافل مرتبط.'
            ]);
        }

        // 1. جلب الكفالات النشطة الفريدة منعاً لتكرار عرض اليتيم
        $sponsorships = Sponsorship::where('sponsor_id', $sponsor->id)
            ->with('orphan')
            ->get()
            ->unique('orphan_id');

        // 2. مبلغ الدعم الشهري المتوقع (مجموع المبالغ المطلوبة للأيتام المكفولين)
        $monthlySupportAmount = $sponsorships->sum(function ($sponsorship) {
            return $sponsorship->orphan->required_amount
                ?? $sponsorship->amount_paid
                ?? $sponsorship->amount
                ?? 0.00;
        });

        // 3. إجمالي المدفوعات الخيرية الفعلية
        $totalPaid = Sponsorship::where('sponsor_id', $sponsor->id)
            ->whereIn('payment_status', ['paid', 'مؤكدة', 'مقبول', 'تم الموافقة'])
            ->sum('amount_paid');

        // 4. رسم البيانات للمساهمات
        $chartLabels = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو'];
        $chartData = [0, 0, 0, 0, 0, (float)$totalPaid];

        return view('sponsor.dashboard', compact(
            'user',
            'sponsor',
            'sponsorships',
            'totalPaid',
            'monthlySupportAmount',
            'chartLabels',
            'chartData'
        ));
    }

    /**
     * عرض قائمة الكفالات بالكامل
     */
    public function sponsorships()
    {
        $user = Auth::user();

        $sponsor = Sponsor::where('user_id', Auth::id())->first();
        if (!$sponsor) {
            return redirect()->route('login');
        }

        // 1️⃣ جلب أحدث ID لكل عملية كفالة/دفعة خاصة بكل يتيم فريد للكافل الحالي
        $latestIds = Sponsorship::where('sponsor_id', $sponsor->id)
            ->select(DB::raw('MAX(id) as id'))
            ->groupBy('orphan_id')
            ->pluck('id');

        // 2️⃣ جلب البيانات واستخدام paginate للحفاظ على كائن التصفح
        $sponsorships = Sponsorship::with('orphan')
            ->whereIn('id', $latestIds)
            ->latest()
            ->paginate(10);

        return view('sponsor.sponsorships', compact('user', 'sponsorships'));
    }

    /**
     * عرض تفاصيل كفالة يتيم محدد
     */
    public function sponsorship_detail(string $id)
    {
        $user = Auth::user();

        $sponsor = Sponsor::where('user_id', Auth::id())->first();
        if (!$sponsor) {
            return redirect()->route('login');
        }

        // 1️⃣ جلب بيانات اليتيم والعقد الأول
        $sponsorship = Sponsorship::with(['orphan'])
            ->where('sponsor_id', $sponsor->id)
            ->where('orphan_id', $id)
            ->firstOrFail();

        // 2️⃣ جلب جميع عمليات الدفع المنجزة لهذا الطفل من قبل هذا الكافل
        $allPayments = Sponsorship::where('sponsor_id', $sponsor->id)
            ->where('orphan_id', $id)
            ->latest()
            ->get();

        // 3️⃣ جلب الوثائق المقبولة من الأدمن
        $documents = documents::where('orphan_id', $id)
            ->whereIn('status', ['مقبول', 'موافق عليه', 'approved'])
            ->latest()
            ->get();

        return view('sponsor.sponsorship-detail', compact('user', 'sponsorship', 'allPayments', 'documents'));
    }

    /**
     * عرض سجل المدفوعات والاشتراكات
     */
    public function payments()
    {
        $user = Auth::user();

        $sponsor = Sponsor::where('user_id', Auth::id())->first();
        if (!$sponsor) {
            return redirect()->route('login');
        }

        $payments = Sponsorship::where('sponsor_id', $sponsor->id)
            ->with('orphan')
            ->oldest()
            ->get();

        $totalAmountPaid = $payments->whereIn('payment_status', ['paid', 'مؤكدة', 'مقبول', 'تم الموافقة'])
            ->sum('amount_paid');

        $completedPaymentsCount = $payments->whereIn('payment_status', ['paid', 'مؤكدة', 'مقبول', 'تم الموافقة'])
            ->count();

        $orphans = Sponsorship::where('sponsor_id', $sponsor->id)
            ->with('orphan')
            ->get();

        return view('sponsor.payments', compact(
            'user',
            'payments',
            'totalAmountPaid',
            'completedPaymentsCount',
            'orphans'
        ));
    }

    /**
     * تصدير كشف الحساب بصيغة CSV
     */
    public function exportPaymentsCsv()
    {
        $sponsor = Sponsor::where('user_id', Auth::id())->firstOrFail();

        $payments = Sponsorship::where('sponsor_id', $sponsor->id)
            ->with('orphan')
            ->oldest()
            ->get();

        $fileName = 'kanaf_payments_statement_' . time() . '.csv';

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($payments) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['كشف حساب المدفوعات والاشتراكات - منصة كنف']);
            fputcsv($file, ['تاريخ التصدير:', now()->toDateTimeString()]);
            fputcsv($file, []);

            fputcsv($file, ['رقم الفاتورة المرجعي', 'اسم اليتيم المكفول', 'القيمة المودعة', 'تاريخ العملية', 'وسيلة الدفع', 'حالة التحصيل']);

            foreach ($payments as $p) {
                $status = in_array($p->payment_status, ['paid', 'مؤكدة', 'مقبول', 'تم الموافقة']) ? 'مؤكدة' : 'قيد المراجعة';
                $orphanName = $p->orphan ? $p->orphan->name : ('يتيم رقم: ' . $p->orphan_id);

                fputcsv($file, [
                    'KNF-2026-' . $p->id,
                    $orphanName,
                    $p->amount_paid . ' $',
                    $p->last_batch ?? $p->created_at->format('Y-m-d'),
                    $p->payment_method ?? 'بطاقة ائتمان',
                    $status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * تحميل إيصال الدفع
     */
    public function downloadReceipt(string $id)
    {
        $sponsor = Sponsor::where('user_id', Auth::id())->firstOrFail();
        $payment = Sponsorship::where('sponsor_id', $sponsor->id)->where('id', $id)->firstOrFail();

        $content = "==================================================\n";
        $content .= "           إيصال سداد إلكتروني - منصة كَنَفْ          \n";
        $content .= "==================================================\n\n";
        $content .= "رقم الفاتورة المرجعي: KNF-2026-" . $payment->id . "\n";
        $content .= "اسم الكافل: " . $sponsor->name . "\n";
        $content .= "رقم اليتيم المكفول: " . $payment->orphan_id . "\n";
        $content .= "القيمة المودعة: " . $payment->amount_paid . " USD\n";
        $content .= "وسيلة الدفع: " . ($payment->payment_method ?? 'Visa/MasterCard') . "\n";
        $content .= "تاريخ العملية: " . ($payment->last_batch ?? now()->format('Y-m-d')) . "\n";
        $content .= "حالة التحصيل: " . (in_array($payment->payment_status, ['paid', 'مؤكدة', 'مقبول', 'تم الموافقة']) ? 'تمت الموافقة / مؤكدة' : 'قيد المراجعة') . "\n";
        $content .= "--------------------------------------------------\n";
        $content .= "شكراً لمساهمتك الكريمة ودعمك لرعاية الأيتام.\n";

        return response($content)
            ->header('Content-Type', 'text/plain; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="Receipt-KNF-2026-' . $payment->id . '.txt"');
    }

    /**
     * تسجيل دفعة فورية جديدة باستخدام Form Request
     */
    public function storeManualPayment(StoreManualPaymentRequest $request)
    {
        $sponsor = Sponsor::where('user_id', Auth::id())->firstOrFail();
        // جلب بيانات اليتيم لمعرفة المبلغ المطلوب
        $orphan = orphans::findOrFail($request->orphan_id);

        $sponsorship = Sponsorship::create([
            'sponsor_id'     => $sponsor->id,
            'orphan_id'      => $request->orphan_id,
            'amount_paid'    => $request->amount_paid ?? $orphan->required_amount ?? 0.00,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'last_batch'     => now()->format('Y-m-d'),
            'start_date'     => now()->format('Y-m-d'),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'دفع مستحقات',
            'details' => 'تم دفع المستحقات الخاصة بالطفل ' . ($sponsorship->orphan->name ?? $request->orphan_id) . ' المتعلقة بالشهر الحالي',
        ]);

        // إرسال إشعار للوصي (أهل الطفل)
        $guardianModel = guardian::where('orphan_id', $request->orphan_id)->first();
        if ($guardianModel) {
            $guardianUser = User::find($guardianModel->user_id);
            if (!$guardianUser && !empty($guardianModel->email)) {
                $guardianUser = User::where('email', $guardianModel->email)->first();
            }

            if ($guardianUser) {
                $orphanName = $sponsorship->orphan->name ?? 'طفلكم';
                $sponsorName = $sponsor->name ?? 'أحد فاعلي الخير';

                $guardianUser->notify(new BroadcastAnnouncement(
                    'تم كفالة الطفل',
                    'تحديث',
                    "تم تقديم كفالة/دفعة مالية جديدة لطفلكم ({$orphanName}) من قبل الكافل ({$sponsorName}) جزاه الله خيراً."
                ));
            }
        }

        return redirect()->back()->with('success', 'تم تسجيل طلب الدفعة بنجاح وهي قيد مراجعة الأدمن الآن.');
    }

    /**
     * عرض وثائق الأيتام المكفولين
     */
    public function documentation()
    {
        $user = Auth::user();

        $sponsor = Sponsor::where('user_id', Auth::id())->first();
        if (!$sponsor) {
            return redirect()->route('login');
        }

        $orphanIds = Sponsorship::where('sponsor_id', $sponsor->id)->pluck('orphan_id');

        $documents = documents::with('orphan')
            ->whereIn('orphan_id', $orphanIds)
            ->get();

        return view('sponsor.documentation', compact('user', 'documents'));
    }

    /**
     * الإشعارات
     */
    public function sponsorIndex()
    {
        /** @var User $user */
        $user = Auth::user();

        $notifications = $user->notifications()->paginate(10);

        return view('sponsor.notifications', compact('user', 'notifications'));
    }

    public function markAllRead()
    {
        /** @var User $user */
        $user = Auth::user();

        $user->unreadNotifications->markAsRead();

        return response()->json(['status' => 'success']);
    }

    /**
     * عرض الصفحة الشخصية للكافل
     */
    public function profile_sponser()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $sponsor = $user->sponsor ?? Sponsor::where('email', $user->email)->first();

        if ($sponsor && !$sponsor->user_id) {
            $sponsor->update(['user_id' => $user->id]);
        }

        return view('sponsor.profile', compact('user', 'sponsor'));
    }

    /**
     * تحديث الملف الشخصي عبر Form Request مخصص
     */
    public function update_Profile_Fields(UpdateSponsorProfileRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 1. تحديث جدول الـ users
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();

        // 2. تحديث بيانات جدول الـ sponsors
        if ($user->sponsor) {
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = 'sponsors_avatar_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('Uploads/sponsors'), $filename);

                $user->sponsor->image = $filename;
            }

            $user->sponsor->name    = $request->name;
            $user->sponsor->email   = $request->email;
            $user->sponsor->phone   = $request->phone;
            $user->sponsor->country = $request->country;

            $user->sponsor->save();

            AuditLog::create([
                'user_id' => Auth::id(),
                'action'  => 'تعديل بيانات كفيل',
                'details' => 'قام الكفيل بتحديث بياناته الشخصية',
            ]);
        }

        return redirect()->back()->with('success', 'تم تحديث البيانات الشخصية بنجاح!');
    }

    /**
     * تغيير كلمة المرور عبر Form Request مخصص
     */
    public function update_Password(UpdateSponsorPasswordRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'كلمة المرور الحالية التي أدخلتها غير صحيحة.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'تم تغيير كلمة المرور بنجاح!');
    }
}
