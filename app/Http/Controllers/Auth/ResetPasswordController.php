<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password')->with([
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required'  => 'يرجى إدخال كلمة المرور الجديدة.',
            'password.min'       => 'يجب ألا تقل كلمة المرور عن 8 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        // جلب السجلات الخاصة بالبريد الإلكتروني
        $resetRecords = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->get();

        $validRecord = null;

        foreach ($resetRecords as $record) {
            // التحقق مما إذا كان التوكن مطابقاً للنص العادي أو تشفير SHA-256
            if ($record->token === $request->token || hash_equals($record->token, hash('sha256', $request->token))) {
                $validRecord = $record;
                break;
            }
        }

        if (!$validRecord) {
            return back()->withErrors(['email' => 'رابط إعادة التعيين غير صالح أو منتهي الصلاحية.']);
        }

        // تحديث كلمة المرور للمستخدم
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // حذف السجل المستعمل
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'تم تغيير كلمة المرور بنجاح! يمكنك الآن تسجيل الدخول.');
    }
}
