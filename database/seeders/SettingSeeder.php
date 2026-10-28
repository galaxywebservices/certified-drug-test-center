<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('site_name', 'Certified Drug Test Center', 'general');
        Setting::set('site_phone', '(800) 221-4291', 'general');
        Setting::set('site_email', 'support@certifieddrugtesting.com', 'general');
        Setting::set('site_tagline', 'Accredited Drug Testing Made Fast, Simple & Confidential', 'general');

        // PayTrace configuration defaults
        Setting::set('paytrace_username', 'demo123', 'payment');
        Setting::set('paytrace_password', 'password123', 'payment', true);
        Setting::set('paytrace_integrator_id', '123456', 'payment');
        Setting::set('paytrace_test_mode', '1', 'payment');
    }
}
