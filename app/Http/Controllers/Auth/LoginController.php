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
        // dd($request->all());
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:sponsor,guardian,admin'
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            $user = Auth::user();

            // // ===== سطر تصحيح مؤقت =====
            // dd([
            //     'db_role' => $user->role,
            //     'db_role_type' => gettype($user->role),
            //     'request_role' => $request->role,
            //     'is_equal' => $user->role === $request->role,
            // ]);
            // // ===========================

            // التحقق من تطابق البوابة المحددة
            if ($user->role !== $request->role) {
                Auth::logout();
                return back()->withErrors(['login_error' => 'عذراً، لا تمتلك صلاحية الدخول عبر هذه البوابة.'])->withInput();
            }

            $request->session()->regenerate();

            // التوجيه الصحيح بناءً على الدور (Role)
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard.html'); // أو اسم راوت الأدمن إذا كان متوفراً
            } elseif ($user->role === 'sponsor') {
                // التوجيه إلى راوت لوحة الكافل التابعة لـ SponsorController
                return redirect()->route('dashboard_sponsor');
            } elseif ($user->role === 'guardian') {
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
