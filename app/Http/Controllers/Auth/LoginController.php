<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        // 1. التحقق من صحة المدخلات
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'role'     => 'required|string',
        ]);

        $remember = $request->has('remember');

        // 2. تسجيل الدخول بالبريد وكلمة المرور
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {

            $user = Auth::user();

            // 3. التحقق من مطابقة الدور المختار مع دور المستخدم
            if (strtolower(trim($user->role)) !== strtolower(trim($request->role))) {
                Auth::logout();
                return back()
                    ->withErrors(['login_error' => 'الدور المختار غير مطابق لنوع هذا الحساب.'])
                    ->withInput();
            }

            // 4. تجديد الجلسة للأمان
            $request->session()->regenerate();

            $userRole = strtolower(trim($user->role));

            // 5. التوجيه الشامل حسب دور المستخدم
            if ($userRole === 'admin') {
                return redirect()->route('dashboard_admin');
            } elseif ($userRole === 'sponsor') {
                return redirect()->route('dashboard_sponsor');
            } elseif ($userRole === 'guardian') {
                return redirect()->route('dashboard');
            }
        }

        // 6. في حال وجود خطأ غير متوقع
        return back()
            ->withErrors(['login_error' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.'])
            ->withInput();
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
