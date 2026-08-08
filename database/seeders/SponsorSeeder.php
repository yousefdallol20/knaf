<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SponsorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsors = [
            [
                'name'    => 'محمد أحمد الأحمد',
                'email'   => 'mohammad@example.com',
                'phone'   => '0591111111',
                'image'   => null,
                'country' => 'فلسطين',
                'city'    => 'نابلس',
                'status'  => 'active',
            ],
            [
                'name'    => 'مؤسسة الخير الدولية',
                'email'   => 'info@alkhair.org',
                'phone'   => '0592222222',
                'image'   => null,
                'country' => 'الإمارات',
                'city'    => 'دبي',
                'status'  => 'active',
            ],
            [
                'name'    => 'عبد الله خالد العمري',
                'email'   => 'abdullah@example.com',
                'phone'   => '0593333333',
                'image'   => null,
                'country' => 'الأردن',
                'city'    => 'عمان',
                'status'  => 'inactive',
            ],
        ];

        foreach ($sponsors as $data) {
            // 1. إنشاء أو جلب المستخدم الخاص بالكافل أولاً
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'phone'    => $data['phone'],
                    'password' => Hash::make('12345678'), // كلمة مرور افتراضية
                    'role'     => 'sponsor', // إعطاء دور الكافل
                ]
            );

            // 2. ربط الـ user_id مع سجل الكافل
            Sponsor::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['user_id' => $user->id])
            );
        }
    }
}
