<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:sponsor,guardian',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // إنشاء السجل في جدول الداعمين تلقائياً إذا كان كافل
        if ($user->role === 'sponsor') {
            Sponsor::create([
                'user_id'   => $user->id,
                'name'      => $user->name,
                'email'     => $user->email,
                'phone'     => $user->phone,
                'country'   => '-', // 👈 مرر قيمة افتراضية مؤقتة للدولة
                'city'      => '-', // 👈 مرر قيمة افتراضية مؤقتة للمدينة
                'orphan_id' => null,
            ]);
        }
        Auth::login($user);

        // 👇 السطر السحري لتحديث الجلسة ومنع التداخل والكاش القديم
        $request->session()->regenerate();

        // التوجيه الصحيح والصارم
        if ($user->role === 'guardian') {
            return redirect()->to('/dashboard');
        } elseif ($user->role === 'sponsor') {
            return redirect()->to('/dashboard_sponsor');
        }
    }
}
