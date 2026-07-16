<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\orphans;
use App\Models\Sponsor;
use App\Models\Sponsorship;
use Illuminate\Support\Facades\Auth;

class sponsorshipController extends Controller
{
    // الخطوة 1: اختيار اليتيم وتأكيد خطة الكفالة
    public function step1(string $id)
    {
        // جلب بيانات اليتيم للتأكد من وجوده وأنه متاح للكفالة
        $orphan = orphans::where('status', 'بانتظار الكفالة')->findOrFail($id);

        return view('sponsorship.step1', compact('orphan'));
    }

    // الخطوة 2: عرض نموذج تعبئة بيانات الكافل
    public function create_step2(Request $request)
    {
        // 1. جلب معرف اليتيم القادم من الرابط (URL)
        $orphanId = $request->query('orphan_id');

        // 2. جلب بيانات الكافل والمستخدم الحالي لمنع ظهور أخطاء أخرى في الصفحة
        $user = auth()->user();
        $sponsor = Sponsor::where('user_id', $user->id)->first();

        // 3. تمرير كافة المتغيرات التي تتوقعها صفحة الـ Blade
        return view('sponsorship.step2', compact('orphanId', 'user', 'sponsor'));
    }

    // الخطوة 2: استقبال وحفظ بيانات الكافل مؤقتاً في السيشين
    // الخطوة 2: استقبال وحفظ بيانات الكافل مؤقتاً في السيشين
    public function step2(Request $request)
    {
        $validated = $request->validate([
            'orphan_id' => 'required|exists:orphans,id', // مضاف للتأكد من وجود اليتيم
            'name'      => 'required|string|max:255',
            'country'   => 'required|string|max:255',
            'city'      => 'required|string|max:255',
        ]);

        // تخزين البيانات مؤقتاً في الجلسة للانتقال للخطوة الأخيرة
        session(['sponsorship_step2' => $validated]);

        return redirect()->route('create_step3');
    }

    // الخطوة 3: عرض صفحة الدفع (فيزا/مدى أو تحويل بنكي)
    public function create_step3()
    {
        if (!session()->has('sponsorship_step2')) {
            return redirect()->route('create_step2');
        }

        // جلب الـ orphan_id المخزن بأمان من جلسة الخطوة السابقة
        $orphanId = session('sponsorship_step2.orphan_id');

        // جلب بيانات اليتيم والكفيل الحالي لـ View
        $orphan = orphans::findOrFail($orphanId);
        $user = auth()->user();
        $sponsor = Sponsor::where('user_id', $user->id)->first();

        // تحديد قيمة الكفالة الافتراضية
        $amountToPay = 50;

        return view('sponsorship.step3', compact('orphan', 'amountToPay', 'sponsor'));
    }
    // الخطوة 3: معالجة عملية الدفع وإنشاء الكفالة رسمياً في القاعدة
    public function step3(Request $request)
    {
        $step2Data = session('sponsorship_step2');
        if (!$step2Data) {
            return redirect()->route('create_step2');
        }

        // التحقق من بيانات الدفع حسب الطريقة المختارة
        $request->validate([
            'payment_method' => 'required|in:card,bank_transfer',
            'amount_paid'    => 'required|numeric|min:1',
            'orphan_id'      => 'required|exists:orphans,id',
            // حقول إضافية للتحويل البنكي أو الـ Transaction ID
            'bank_reference_number' => 'required_if:payment_method,bank_transfer',
            'bank_receipt_file'     => 'required_if:payment_method,bank_transfer|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'transaction_id'        => 'required_if:payment_method,card',
        ]);

        $user = Auth::user();

        // 1. ابحث عن الكفيل الحالي أولاً بناءً على الـ user_id
        $sponsor = Sponsor::where('user_id', $user->id)->first();

        // 2. حدد رقم الهاتف الذكي: إذا كان موجوداً مسبقاً في قاعدة البيانات لا تلمسه، وإذا لم يكن موجوداً خذ الجديد
        $phoneToSave = ($sponsor && $sponsor->phone)
            ? $sponsor->phone
            : ($user->phone ?? $request->phone ?? $step2Data['phone'] ?? null);

        // 3. الآن نفذ التحديث أو الإنشاء ببيانات آمنة
        $sponsor = Sponsor::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name'    => $step2Data['name'],
                'email'   => $user->email,
                'phone'   => $phoneToSave, // الهاتف الآمن هنا
                'country' => $step2Data['country'],
                'city'    => $step2Data['city'],
                'status'  => 'active'
            ]
        );

        // 2. معالجة رفع ملف الإيصال في حال التحويل البنكي
        $receiptPath = null;
        if ($request->hasFile('bank_receipt_file')) {
            $receiptPath = $request->file('bank_receipt_file')->store('receipts', 'public');
        }

        // 3. إنشاء سجل الكفالة الجديد
        Sponsorship::create([
            'orphan_id'             => $request->orphan_id,
            'sponsor_id'            => $sponsor->id,
            'amount_paid'           => $request->amount_paid,
            'start_date'            => now(),
            'last_batch'            => now(),
            'payment_method'        => $request->payment_method,
            'payment_status'        => $request->payment_method == 'card' ? 'paid' : 'pending', // الكارد فوري، التحويل بانتظار المراجعة
            'transaction_id'        => $request->transaction_id,
            'bank_reference_number' => $request->bank_reference_number,
            'bank_receipt_file'     => $receiptPath,
        ]);

        // 4. تحديث حالة اليتيم ليصبح مكفولاً
        orphans::where('id', $request->orphan_id)->update(['status' => 'مكفول']);

        // تنظيف السيشين بعد النجاح
        session()->forget('sponsorship_step2');

        return redirect()->route('sponsorships')->with('success', 'تمت عملية الكفالة بنجاح!');
    }
}
