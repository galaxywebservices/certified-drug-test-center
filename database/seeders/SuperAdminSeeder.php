<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@certifieddrugtesting.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('Admin@CDTC2026!'),
                'is_super_admin' => true,
                'phone' => '(800) 221-4291',
            ]
        );
    }
}
