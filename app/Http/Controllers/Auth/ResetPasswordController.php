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
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required'  => 'يرجى إدخال كلمة المرور الجديدة.',
            'password.min'       => 'يجب ألا تقل كلمة المرور عن 6 أحرف.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
        ]);

        // التحقق من صحة الـ Token في قاعدة البيانات
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRecord) {
            return back()->withErrors(['email' => 'رابط إعادة التعيين غير صالحة أو منتهي الصلاحية.']);
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
