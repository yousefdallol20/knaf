<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Models\Sponsor;
use App\Models\Sponsorship;
use App\Models\Orphan;
use App\Models\Document;
use App\Models\documents;
use App\Models\Financials;
use App\Models\guardian;
use App\Models\Housing;
use App\Models\User;
use App\Notifications\BroadcastAnnouncement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // تأكد من وجود هذا السطر في أعلى ملف الكنترولر

class SponsorController extends Controller
{
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

        // 2. مبلغ الدعم الشهري المتوقع
        $monthlySupportAmount = $sponsorships->sum(function ($sponsorship) {
            return $sponsorship->monthly_amount ?? $sponsorship->amount ?? $sponsorship->amount_paid ?? 50.00;
        });

        // 3. إجمالي المدفوعات الخيرية الفعلية (جلبها من جدول sponsorships لحساب المبالغ المقبولة فقط)
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

    // عرض قائمة الكفالات بالكامل
    public function sponsorships()
    {
        $user = Auth::user();

        $sponsor = Sponsor::where('user_id', Auth::id())->first();
        if (!$sponsor) {
            return redirect()->route('login');
        }

        $sponsorships = Sponsorship::with('orphan')
            ->where('sponsor_id', $sponsor->id)
            ->paginate(10);

        return view('sponsor.sponsorships', compact('user', 'sponsorships'));
    }

    // عرض تفاصيل كفالة يتيم محدد
    public function sponsorship_detail(string $id)
    {
        $user = Auth::user();

        $sponsor = Sponsor::where('user_id', Auth::id())->first();
        if (!$sponsor) {
            return redirect()->route('login');
        }

        // جلب الكفالة مع جلب كلاً من الأيتام والوثائق والمدفوعات
        $sponsorship = Sponsorship::with(['orphan', 'orphan.documents'])
            ->where('sponsor_id', $sponsor->id)
            ->where('orphan_id', $id)
            ->firstOrFail();

        return view('sponsor.sponsorship-detail', compact('user', 'sponsorship'));
    }

    // عرض سجل المدفوعات والاشتراكات
    // عرض سجل المدفوعات والاشتراكات للكافل
    // عرض سجل المدفوعات مع الحسابات الديناميكية
    public function payments()
    {
        $user = Auth::user();

        $sponsor = Sponsor::where('user_id', Auth::id())->first();
        if (!$sponsor) {
            return redirect()->route('login');
        }

        // ترتيب الدفعات تصاعدياً (من الأقدم للأحدث / من 1 إلى الأعلى)
        $payments = Sponsorship::where('sponsor_id', $sponsor->id)
            ->with('orphan')
            ->oldest()
            ->get();

        // حساب إجمالي المبالغ المقبولة/المؤكدة فقط
        $totalAmountPaid = $payments->whereIn('payment_status', ['paid', 'مؤكدة', 'مقبول', 'تم الموافقة'])
            ->sum('amount_paid');

        // حساب عدد الدفعات المكتملة
        $completedPaymentsCount = $payments->whereIn('payment_status', ['paid', 'مؤكدة', 'مقبول', 'تم الموافقة'])
            ->count();

        // قائمة الأيتام التابعين للكافل
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
    // تصدير كشف الحساب بصيغة CSV
    public function exportPaymentsCsv()
    {
        $sponsor = Sponsor::where('user_id', Auth::id())->firstOrFail();

        // ترتيب تصاعدي لملف الـ CSV
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

    // تحميل إيصال الدفع
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

    // تسجيل دفعة فورية جديدة من الكافل
    public function storeManualPayment(Request $request)
    {
        $request->validate([
            'orphan_id'      => 'required',
            'amount_paid'    => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ]);

        $sponsor = Sponsor::where('user_id', Auth::id())->firstOrFail();

        Sponsorship::create([
            'sponsor_id'     => $sponsor->id,
            'orphan_id'      => $request->orphan_id,
            'amount_paid'    => $request->amount_paid,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending', // تم تغييرها إلى pending لتفادي تعارض الـ ENUM أو طول السلسلة
            'last_batch'     => now()->format('Y-m-d'),
            'start_date'     => now()->format('Y-m-d'),
        ]);

        AuditLog::create([
            'user_id' => Auth::id(), // معرف الكفيل الذي قام بالتحديث
            'action'  => 'دفع مستحقات',
            'details' => 'تم دفع المستحقالت الخاصة بالطفل '. $request->name.'المتعلقة بالشهر الحال',
        ]);

        // 🔔 إرسال إشعار للوصي (أهل الطفل) بوجود كفالة/دفعة من الكافل
        $guardian = guardian::where('orphan_id', $request->orphan_id)->first();
        if ($guardian) {
            $guardianUser = User::find($guardian->user_id);
            if (!$guardianUser && !empty($guardian->email)) {
                $guardianUser = User::where('email', $guardian->email)->first();
            }

            if ($guardianUser) {
                $orphanName = $sponsorship->orphan->name ?? 'طفلكم';
                $sponsorName = $sponsor->name ?? 'أحد فاعلي الخير';

                $guardianUser->notify(new BroadcastAnnouncement(
                    'تم كفالة الطفل',
                    'تحديث',
                    "تم تقديم كفالة/دفعة مالية جديدة لطفلكم ({$orphanName}) من قبل الكافل ({$sponsorName}) جزاه الله خيرا ."
                ));
            }
        }

        return redirect()->back()->with('success', 'تم تسجيل طلب الدفعة بنجاح وهي قيد مراجعة الأدمن الآن.');
    }

    // عرض الوثائق والتقارير الدراسية/الصحية الخاصة بالأيتام المكفولين
    public function documentation()
    {
        $user = Auth::user();

        $sponsor = Sponsor::where('user_id', Auth::id())->first();
        if (!$sponsor) {
            return redirect()->route('login');
        }

        // جلب معرفات الأيتام المكفولين من قبل هذا الكفيل
        $orphanIds = Sponsorship::where('sponsor_id', $sponsor->id)->pluck('orphan_id');

        // جلب المستندات الخاصة بهؤلاء الأيتام فقط
        $documents = documents::with('orphan')
            ->whereIn('orphan_id', $orphanIds)
            ->get();

        return view('sponsor.documentation', compact('user', 'documents'));
    }

    // عرض صفحة الإشعارات للكافل
    public function sponsorIndex()
    {
        /** @var User $user */
        $user = Auth::user();

        // جلب إشعارات الكافل
        $notifications = $user->notifications()->paginate(10);

        return view('sponsor.notifications', compact('user', 'notifications'));
    }
    // تحديد كل الإشعارات كمقروءة للكافل
    public function markAllRead()
    {
        /** @var User $user */
        $user = Auth::user();

        $user->unreadNotifications->markAsRead();

        return response()->json(['status' => 'success']);
    }

    // عرض وتعديل الملف الشخصي للكفيل
    public function profile_sponser()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // 1. البحث عن الكافل عبر العلاقة أولاً، أو بالإيميل إن لم يكن متصلاً بـ user_id
        $sponsor = $user->sponsor
            ?? Sponsor::where('email', $user->email)->first();

        // 2. إذا وجده بالإيميل ولم يربط بالـ user_id، نقوم بربطه تلقائياً
        if ($sponsor && !$sponsor->user_id) {
            $sponsor->update(['user_id' => $user->id]);
        }

        // 3. تمرير الـ user والـ sponsor للـ View
        return view('sponsor.profile', compact('user', 'sponsor'));
    }

    public function update_Profile_Fields(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // جلب معرف الكفيل المرتبط بالمستخدم الحالي بشكل آمن
        $sponsorId = $user->sponsor ? $user->sponsor->id : null;

        // 1. شروط التحقق المحدثة والمضمونة للاستثناء
        $rules = [
            'name'          => 'required|string|max:255',

            'email'         => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
                Rule::unique('sponsors', 'email')->ignore($user->sponsor->id ?? null),
            ],

            'phone'         => [
                'required',
                'string',
                Rule::unique('users', 'phone')->ignore($user->id),
                Rule::unique('sponsors', 'phone')->ignore($user->sponsor->id ?? null),
            ],

            'country'       => 'required|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];

        // 2. رسائل الخطأ المخصصة باللغة العربية
        $messages = [
            'name.required'          => 'يرجى إدخال اسم الكافل بالكامل.',
            'name.string'            => 'يجب أن يكون الاسم عبارة عن نص صحيح.',
            'name.max'               => 'يجب ألا يتجاوز الاسم 255 حرفاً.',

            'email.required'         => 'البريد الإلكتروني مطلوب ولا يمكن تركه فارغاً.',
            'email.email'            => 'يرجى إدخال بريد إلكتروني صيغته صحيحة (مثال: example@mail.com).',
            'email.unique'           => 'البريد الإلكتروني مُستخدم بالفعل من قِبل حساب آخر في النظام.',

            'phone.required'         => 'رقم الهاتف مطلوب ولا يمكن تركه فارغاً.',
            'phone.unique'           => 'رقم الجوال هذا مسجل مسبقاً لكافل أو مستخدم آخر في قاعدة البيانات.',

            'country.required'       => 'يرجى إدخال دولة أو مدينة الإقامة الفعلية.',

            'profile_photo.image'    => 'الملف المرفوع يجب أن يكون صورة فقط.',
            'profile_photo.mimes'    => 'صيغ الصور المدعومة هي فقط: jpeg, png, jpg, gif.',
            'profile_photo.max'      => 'حجم الصورة الشخصية يجب ألا يتجاوز 2 ميجابايت.',
        ];

        // تنفيذ عملية التحقق وتمرير الرسائل العربية
        $request->validate($rules, $messages);

        // 3. تحديث جدول الـ users
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->save();

        // 4. تحديث بيانات جدول الـ sponsors المرتبط بالمستخدم الحالي
        if ($user->sponsor) {

            // معالجة ورفع الصورة الشخصية الجديدة في حال تم اختيارها
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = 'sponsors_avatar_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

                // نقل الصورة للمجلد الموحد public/Uploads/sponsors
                $file->move(public_path('Uploads/sponsors'), $filename);

                // حفظ اسم الصورة الجديد
                $user->sponsor->image = $filename;
            }

            $user->sponsor->name    = $request->name;
            $user->sponsor->email   = $request->email;
            $user->sponsor->phone   = $request->phone;
            $user->sponsor->country = $request->country;

            $user->sponsor->save();

            AuditLog::create([
                'user_id' => Auth::id(), // معرف الكفيل الذي قام بالتحديث
                'action'  => 'تعديل بيانات كفيل',
                'details' => 'قام الكفيل بتحديث بيانته الشخصية ',
            ]);
        }

        return redirect()->back()->with('success', 'تم تحديث البيانات الشخصية بنجاح!');
    }

    /**
     * دالة تغيير كلمة المرور (الفورم الثاني)
     */
    public function update_Password(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // 1. شروط التحقق من الحقول
        $rules = [
            'current_password' => 'required',
            'password'         => 'required|string|min:6|confirmed', // confirmed تتطابق تلقائياً مع password_confirmation
        ];

        // 2. رسائل التحقق المخصصة باللغة العربية
        $messages = [
            'current_password.required' => 'حقل كلمة المرور الحالية مطلوب ولا يمكن تركه فارغاً.',
            'password.required'         => 'يرجى إدخال كلمة المرور الجديدة.',
            'password.min'              => 'يجب ألا تقل كلمة المرور الجديدة عن 6 رموز.',
            'password.confirmed'        => 'تأكيد كلمة المرور الجديدة غير متطابق مع الحقل السابق.',
        ];

        // تنفيذ التحقق
        $request->validate($rules, $messages);

        // 3. التحقق من أن كلمة المرور الحالية صحيحة
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'كلمة المرور الحالية التي أدخلتها غير صحيحة.']);
        }

        // 4. تشفير وحفظ كلمة المرور الجديدة
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'تم تغيير كلمة المرور بنجاح!');
    }
}
