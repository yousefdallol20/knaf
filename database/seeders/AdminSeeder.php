<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء حساب الأدمن في جدول الـ users
        User::updateOrCreate(
            ['email' => 'admin@kanaf.ps'], // التحقق من الإيميل لمنع تكرار الحساب عند تشغيل السيدر مجدداً
            [
                'name'     => 'إدارة منصة كنف',
                'phone'    => '0590000000', // ضع رقم الهاتف الخاص بالأدمن هنا
                'password' => Hash::make('12345678'),
                'role'     => 'admin', // الدور المخصص للأدمن لتوجيهه للوحة التحكم الصحيحة
            ]
        );
    }
}
