<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // تأكد من اسم المجلد لديك
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $user = Auth::user();

            $request->session()->regenerate();

            // تنظيف وتوحيد قيمة الـ Role المخزن في الـ DB لتفادي أي مشاكل في حالة الأحرف أو المسافات
            $userRole = strtolower(trim($user->role));

            // التوجيه التلقائي المباشر بناءً على دور الحساب الفعلي
            if ($userRole === 'admin') {
                return redirect()->route('dashboard_admin');
            } elseif ($userRole === 'sponsor') {
                return redirect()->route('dashboard_sponsor');
            } elseif ($userRole === 'guardian') {
                return redirect()->route('dashboard');
            }
        }

        return back()->withErrors(['login_error' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.'])->withInput();
    }

    public function logout(Request $request)
    {
        // تسجيل خروج المستخدم الحالي
        Auth::logout();

        // إبطال مفعول الـ Session الحالية وتوليد توكن جديد للحماية
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // التوجيه لصفحة تسجيل الدخول
        return redirect('/login');
    }
}
