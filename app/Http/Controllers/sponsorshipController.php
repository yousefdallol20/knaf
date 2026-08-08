<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
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
        // 1. جلب اليتيم
        $orphan = orphans::find($id);

        if (!$orphan) {
            return redirect()->route('orphans')->with('error', 'اليتيم غير موجود.');
        }

        // 2. التحقق مما إذا كان اليتيم مكفولاً بالفعل
        if ($orphan->status === 'مكفول') {
            return redirect()->route('sponsorships')->with('warning', 'عذراً، هذا اليتيم مكفول بالفعل ولا يمكن كفالته مجدداً.');
        }

        // 3. التحقق الإضافي: هل هذا اليتيم يملكه هذا الكافل في جدول الكفالات؟
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

    // الخطوة 2: عرض نموذج تعبئة بيانات الكافل
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

    // الخطوة 2: استقبال وحفظ بيانات الكافل مؤقتاً في السيشين
    public function step2(Request $request)
    {
        $validated = $request->validate([
            'orphan_id' => 'required|exists:orphans,id',
            'name'      => 'required|string|max:255',
            'country'   => 'required|string|max:255',
            'city'      => 'required|string|max:255',
        ]);

        session(['sponsorship_step2' => $validated]);

        return redirect()->route('create_step3');
    }

    // الخطوة 3: عرض صفحة الدفع
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

    // الخطوة 3: معالجة عملية الدفع وإنشاء الكفالة رسمياً
    public function step3(Request $request)
    {
        $step2Data = session('sponsorship_step2');
        if (!$step2Data) {
            return redirect()->route('create_step2');
        }

        $request->validate([
            'payment_method'        => 'required|in:card,bank_transfer',
            'amount_paid'           => 'required|numeric|min:1',
            'orphan_id'             => 'required|exists:orphans,id',
            'bank_reference_number' => 'required_if:payment_method,bank_transfer',
            'bank_receipt_file'     => 'required_if:payment_method,bank_transfer|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'transaction_id'        => 'required_if:payment_method,card',
        ]);

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

        // تحديث حالة اليتيم مباشرة إلى مكفول
        $orphan->update(['status' => 'مكفول']);

        session()->forget('sponsorship_step2');

        AuditLog::create([
            'user_id' => Auth::id(), // معرف الكفيل الذي قام بالتحديث
            'action'  => 'كفالة جديدة',
            'details' => 'تم كفالة الطفل ',
        ]);

        return redirect()->route('sponsorships')->with('success', 'تمت عملية الكفالة بنجاح!');
    }
}
