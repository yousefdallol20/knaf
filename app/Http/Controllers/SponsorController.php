<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use App\Models\Sponsor;
use App\Models\Sponsorship;
use App\Models\Orphan;
use App\Models\Document;
use App\Models\documents;
use App\Models\Housing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // تأكد من وجود هذا السطر في أعلى ملف الكنترولر

class SponsorController extends Controller
{
    // عرض لوحة التحكم الخاصة بالكفيل
    public function dashboard_sponsor()
    {
        $user = Auth::user();

        // جلب بيانات الكفيل المرتبطة بالمستخدم الحالي
        $sponsor = Sponsor::where('user_id', $user->id)->first();
        if (!$sponsor) {
            return redirect()->route('login');
        }

        // جلب كفالات هذا الكفيل مع بيانات الأيتام
        $sponsorships = Sponsorship::with('orphan')
            ->where('sponsor_id', $sponsor->id)
            ->get();

        return view('sponsor.dashboard', compact('user', 'sponsor', 'sponsorships'));
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
            ->get();

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

        // التأكد من أن الكفالة تخص الكفيل الحالي لحماية البيانات
        $sponsorship = Sponsorship::with(['orphan', 'orphan.documents'])
            ->where('sponsor_id', $sponsor->id)
            ->where('orphan_id', $id)
            ->firstOrFail();

        return view('sponsor.sponsorship-detail', compact('user', 'sponsorship'));
    }

    // عرض سجل المدفوعات والاشتراكات
    public function payments()
    {
        $user = Auth::user();

        $sponsor = Sponsor::where('user_id', Auth::id())->first();
        if (!$sponsor) {
            return redirect()->route('login');
        }

        $payments = Sponsorship::where('sponsor_id', $sponsor->id)
            ->select('id', 'orphan_id', 'amount_paid', 'last_batch', 'payment_method', 'payment_status')
            ->get();

        return view('sponsor.payments', compact('user', 'payments'));
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

        return view('sponsor.profile', compact('user'));
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
                'user_id' => auth()->id(), // معرف الكفيل الذي قام بالتحديث
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
