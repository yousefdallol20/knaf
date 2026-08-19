<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessSponsorshipStep2Request;
use App\Http\Requests\ProcessSponsorshipStep3Request;
use App\Models\AuditLog;
use App\Models\guardian;
use App\Models\orphans;
use App\Models\Sponsor;
use App\Models\Sponsorship;
use App\Models\User;
use App\Notifications\BroadcastAnnouncement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $request->validate([
            'orphan_id'      => 'required|exists:orphans,id',
            'sponsor_id'     => 'required|exists:sponsors,id',
            'payment_method' => 'required|in:card,manual',
        ]);

        $orphan  = orphans::findOrFail($request->orphan_id);
        $sponsor = Sponsor::findOrFail($request->sponsor_id);

        // تحديد المبلغ المطلوب ديناميكياً من بيانات اليتيم (وفي حال عدم وجوده يتم اعتماد قيمة افتراضية)
        $amountPaid = $request->amount_paid ?? $orphan->required_amount ?? 50.00;

        DB::beginTransaction();
        try {
            // 1. إنشاء سجل الكفالة الجديد
            $sponsorship = Sponsorship::create([
                'orphan_id'      => $orphan->id,
                'sponsor_id'     => $sponsor->id,
                'amount_paid' => $orphan->required_amount ?? $request->amount_paid,
                'start_date'     => now(),
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method == 'card' ? 'paid' : 'pending',
            ]);

            // 2. تحديث حالة اليتيم إلى مكفول
            $orphan->update([
                'status' => 'مكفول',
            ]);

            // 3. إرسال إشعار للوصي الخاص بالطفل
            $guardianModel = guardian::where('id', $orphan->guardian_id)
                ->orWhere('user_id', $orphan->guardian_id)
                ->first();

            if ($guardianModel) {
                $guardianUser = User::find($guardianModel->user_id);

                if ($guardianUser) {
                    $orphanName  = $orphan->name ?? 'طفلكم';
                    $sponsorName = $sponsor->name ?? 'أحد فاعلي الخير';

                    $guardianUser->notify(new BroadcastAnnouncement(
                        'تم كفالة الطفل',
                        'تحديث',
                        "تمت كفالة الطفل ({$orphanName}) بنجاح من قبل الكافل ({$sponsorName})، جزاه الله خيراً."
                    ));
                }
            }

            DB::commit();

            return redirect()->route('sponsorships.index')
                ->with('success', 'تم إتمام عملية الكفالة بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'حدث خطأ أثناء معالجة الكفالة: ' . $e->getMessage());
        }
    }
}
