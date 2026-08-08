<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\guardian;
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
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'required|string|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role'     => 'required|in:sponsor,guardian',
        ]);

        // 1️⃣ إنشاء المستخدم أولاً في جدول users
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // 2️⃣ في حال كان المسجل كافل (Sponsor)
        if ($request->role === 'sponsor') {
            $sponsor = Sponsor::create([
                'user_id' => $user->id,
                'name'    => $request->name,
                'email'   => $request->email,
                'phone'   => $request->phone,
                'country' => '-',
                'city'    => '-',
            ]);

            // تحديث المفتاح الأجنبي في جدول users
            $user->update(['sponsor_id' => $sponsor->id]);
        }

        // 3️⃣ في حال كان المسجل وصي (Guardian)
        elseif ($request->role === 'guardian') {
            $guardian = guardian::create([
                'user_id'                      => $user->id,
                'name'                         => $request->name,
                'national_id'                  => $request->national_id ?? null,
                'birth_date'                   => $request->birth_date ?? null,
                'kinship_relation'             => $request->kinship_relation ?? null,
                'marital_status'               => $request->marital_status ?? null,
                'health_status'                => $request->health_status ?? null,
                'guardian_id_image'            => 'default.jpg',
                'legal_guardianship_document' => 'default.pdf',
                'orphan_id'                    => null,
            ]);

            // تحديث المفتاح الأجنبي في جدول users
            $user->update(['guardian_id' => $guardian->id]);
        }

        // 4️⃣ تسجيل الدخول والتوجيه
        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'guardian') {
            return redirect()->to('/dashboard');
        } elseif ($user->role === 'sponsor') {
            return redirect()->to('/dashboard_sponsor');
        }
    }
}
