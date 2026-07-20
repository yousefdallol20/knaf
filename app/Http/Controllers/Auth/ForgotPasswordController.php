<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm() {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request) {
        $request->validate(['email' => 'required|email']);

        $user = Sponsor::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'لم نجد حساباً مرتبطاً بهذا البريد الإلكتروني.'])->withInput();
        }

        // إرجاع حالة نجاح للـ session ليعرض كود الـ Blade خطوة النجاح
        return back()->with('status', 'تم إرسال رابط التعيين بنجاح!');
    }
}
