<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@kanaf.ps'],
            [
                'name'     => 'إدارة منصة كنف',
                'phone'    => '0590000000',
                'password' => Hash::make('12345678'),
                'role'     => 'admin',
            ]
        );
    }
}
