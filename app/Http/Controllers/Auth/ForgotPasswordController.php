<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm() {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request) {
        $request->validate([
            'email' => 'required|email'
        ], [
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
            'email.email'    => 'صيغة البريد الإلكتروني غير صحيحة.'
        ]);

        // 1️⃣ البحث عن المستخدم في جدول users (لكي يشمل كافة الأدوار)
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'لم نجد حساباً مرتبطاً بهذا البريد الإلكتروني.'])->withInput();
        }

        // 2️⃣ إنشاء رمز أمان (Token) وتخزينه في جدول password_reset_tokens
        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email'      => $request->email,
                'token'      => $token,
                'created_at' => now()
            ]
        );

        // 3️⃣ إرسال إشعار البريد الإلكتروني للرمز
        $user->notify(new ResetPasswordNotification($token));

        return back()->with('status', 'تم إرسال رابط التعيين بنجاح!');
    }
}
