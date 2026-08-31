<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\guardian;
use App\Models\Sponsor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. حساب الأدمن (Admin)
        User::updateOrCreate(
            ['email' => 'admin@kanaf.ps'],
            [
                'name'     => 'إدارة منصة كنف',
                'phone'    => '0590000000',
                'password' => Hash::make('12345678'),
                'role'     => 'admin',
            ]
        );

        // 2. حساب الوصي (Guardian)
        $guardianUser = User::updateOrCreate(
            ['email' => 'guardian@kanaf.ps'],
            [
                'name'     => 'الوصي علي محمود',
                'phone'    => '0598888888',
                'password' => Hash::make('12345678'),
                'role'     => 'guardian',
            ]
        );

        guardian::updateOrCreate(
            ['user_id' => $guardianUser->id],
            [
                'name' => $guardianUser->name,
            ]
        );

        // 3. حساب الكافل (Sponsor)
        $sponsorUser = User::updateOrCreate(
            ['email' => 'sponsor@kanaf.ps'],
            [
                'name'     => 'محمد أحمد الأحمد',
                'phone'    => '0591111111',
                'password' => Hash::make('12345678'),
                'role'     => 'sponsor',
            ]
        );

        Sponsor::updateOrCreate(
            ['email' => $sponsorUser->email],
            [
                'user_id' => $sponsorUser->id,
                'name'    => $sponsorUser->name,
                'phone'   => $sponsorUser->phone,
                'image'   => 'Uploads/guardians/default.png',
                'country' => 'فلسطين',
                'city'    => 'غزة',
                'status'  => 'active',
            ]
        );
    }
}
