<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessSponsorshipStep2Request;
use App\Http\Requests\ProcessSponsorshipStep3Request;
use App\Models\AuditLog;
use App\Models\orphans;
use App\Models\Sponsor;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorshipController extends Controller
{
    /**
     * الخطوة 1: اختيار اليتيم وتأكيد خطة الكفالة
     */
    public function step1(string $id)
    {
        // 1. جلب بيانات اليتيم
        $orphan = orphans::find($id);

        if (!$orphan) {
            return redirect()->route('orphans')->with('error', 'اليتيم غير موجود.');
        }

        // 2. التحقق مما إذا كان اليتيم مكفولاً بالفعل
        if ($orphan->status === 'مكفول') {
            return redirect()->route('sponsorships')->with('warning', 'عذراً، هذا اليتيم مكفول بالفعل ولا يمكن كفالته مجدداً.');
        }

        // 3. التحقق الإضافي: هل هذا اليتيم مدرج ضمن كفالات المستخدم الحالي؟
        $user = Auth::user();
        if ($user) {
            $sponsor = Sponsor::where('user_id', $user->id)->first();
            if ($sponsor) {
                $hasActiveSponsorship = Sponsorship::where('sponsor_id', $sponsor->id)
                    ->where('orphan_id', $id)
                    ->exists();

                if ($hasActiveSponsorship) {
                    return redirect()->route('sponsorships')->with('warning', 'هذا اليتيم مدرج ضمن كفالاتك بالفعل!');
                }
            }
        }

        return view('sponsorship.step1', compact('orphan'));
    }

    /**
     * الخطوة 2: عرض نموذج تعبئة بيانات الكافل
     */
    public function create_step2(Request $request)
    {
        $orphanId = $request->query('orphan_id');

        // فحص سريع لحالة اليتيم قبل إكمال البيانات
        $orphan = orphans::find($orphanId);
        if (!$orphan || $orphan->status === 'مكفول') {
            return redirect()->route('sponsorships')->with('warning', 'عذراً، هذا اليتيم مكفول بالفعل.');
        }

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $sponsor = Sponsor::where('user_id', $user->id)->first();

        return view('sponsorship.step2', compact('orphanId', 'user', 'sponsor'));
    }

    /**
     * الخطوة 2: استقبال وحفظ بيانات الكافل مؤقتاً في السيشين
     */
    public function step2(ProcessSponsorshipStep2Request $request)
    {
        // يتم استخدام البيانات المتحقق منها تلقائياً
        session(['sponsorship_step2' => $request->validated()]);

        return redirect()->route('create_step3');
    }

    /**
     * الخطوة 3: عرض صفحة الدفع
     */
    public function create_step3()
    {
        if (!session()->has('sponsorship_step2')) {
            return redirect()->route('create_step2');
        }

        $orphanId = session('sponsorship_step2.orphan_id');
        $orphan = orphans::findOrFail($orphanId);

        if ($orphan->status === 'مكفول') {
            session()->forget('sponsorship_step2');
            return redirect()->route('sponsorships')->with('warning', 'عذراً، تمت كفالة هذا اليتيم مؤخراً.');
        }

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $sponsor = Sponsor::where('user_id', $user->id)->first();
        $amountToPay = 50;

        return view('sponsorship.step3', compact('orphan', 'amountToPay', 'sponsor'));
    }

    /**
     * الخطوة 3: معالجة عملية الدفع وإنشاء الكفالة رسمياً
     */
    public function step3(ProcessSponsorshipStep3Request $request)
    {
        $step2Data = session('sponsorship_step2');
        if (!$step2Data) {
            return redirect()->route('create_step2');
        }

        // فحص الحماية النهائي لحالة اليتيم لمنع Double Submission
        $orphan = orphans::findOrFail($request->orphan_id);
        if ($orphan->status === 'مكفول') {
            session()->forget('sponsorship_step2');
            return redirect()->route('sponsorships')->with('warning', 'هذا اليتيم مكفول بالفعل.');
        }

        $user = Auth::user();
        $sponsor = Sponsor::where('user_id', $user->id)->first();

        $phoneToSave = ($sponsor && $sponsor->phone)
            ? $sponsor->phone
            : ($user->phone ?? $request->phone ?? $step2Data['phone'] ?? null);

        // إنشاء أو تحديث حساب الكافل
        $sponsor = Sponsor::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name'    => $step2Data['name'],
                'email'   => $user->email,
                'phone'   => $phoneToSave,
                'country' => $step2Data['country'],
                'city'    => $step2Data['city'],
                'status'  => 'active'
            ]
        );

        $receiptPath = null;
        if ($request->hasFile('bank_receipt_file')) {
            $receiptPath = $request->file('bank_receipt_file')->store('receipts', 'public');
        }

        // إنشاء سجل الكفالة
        Sponsorship::create([
            'orphan_id'             => $request->orphan_id,
            'sponsor_id'            => $sponsor->id,
            'amount_paid'           => $request->amount_paid,
            'start_date'            => now(),
            'last_batch'            => now(),
            'payment_method'        => $request->payment_method,
            'payment_status'        => $request->payment_method == 'card' ? 'paid' : 'pending',
            'transaction_id'        => $request->transaction_id,
            'bank_reference_number' => $request->bank_reference_number,
            'bank_receipt_file'     => $receiptPath,
        ]);

        // تحديث حالة اليتيم إلى "مكفول"
        $orphan->update(['status' => 'مكفول']);

        // تفريغ الجلسة
        session()->forget('sponsorship_step2');

        // تسجيل العملية في السجل
        AuditLog::create([
            'user_id' => Auth::id(),
            'action'  => 'كفالة جديدة',
            'details' => 'تم كفالة الطفل ' . ($orphan->name ?? ('رقم ' . $orphan->id)),
        ]);

        return redirect()->route('sponsorships')->with('success', 'تمت عملية الكفالة بنجاح!');
    }
}
