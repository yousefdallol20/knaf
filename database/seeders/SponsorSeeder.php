<?php

namespace Database\Seeders;

use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SponsorSeeder extends Seeder
{
    public function run(): void
    {
        $sponsors = [
            [
                'name'    => 'محمد أحمد الأحمد',
                'email'   => 'mohammad@example.com',
                'phone'   => '0591111111',
                'image'   => 'c:\xampp\htdocs\Archive\public\Uploads\guardians\default.png',
                'country' => 'فلسطين',
                'city'    => 'نابلس',
                'status'  => 'active',
            ],
            [
                'name'    => 'مؤسسة الخير الدولية',
                'email'   => 'info@alkhair.org',
                'phone'   => '0592222222',
                'image'   => 'c:\xampp\htdocs\Archive\public\Uploads\guardians\default.png',
                'country' => 'الإمارات',
                'city'    => 'دبي',
                'status'  => 'active',
            ],
            [
                'name'    => 'عبد الله خالد العمري',
                'email'   => 'abdullah@example.com',
                'phone'   => '0593333333',
                'image'   => 'c:\xampp\htdocs\Archive\public\Uploads\guardians\default.png',
                'country' => 'الأردن',
                'city'    => 'عمان',
                'status'  => 'active',
            ],
            [
                'name'    => 'شركة الأمل للإغاثة',
                'email'   => 'info@alamal.org',
                'phone'   => '0594444444',
                'image'   => 'c:\xampp\htdocs\Archive\public\Uploads\guardians\default.png',
                'country' => 'قطر',
                'city'    => 'الدوحة',
                'status'  => 'active',
            ],
            [
                'name'    => 'فاطمة الزهراء البكري',
                'email'   => 'fatima@example.com',
                'phone'   => '0595555555',
                'image'   => 'c:\xampp\htdocs\Archive\public\Uploads\guardians\default.png',
                'country' => 'فلسطين',
                'city'    => 'القدس',
                'status'  => 'active',
            ],
        ];

        foreach ($sponsors as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'phone'    => $data['phone'],
                    'password' => Hash::make('12345678'),
                    'role'     => 'sponsor',
                ]
            );

            Sponsor::updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['user_id' => $user->id])
            );
        }
    }
}
