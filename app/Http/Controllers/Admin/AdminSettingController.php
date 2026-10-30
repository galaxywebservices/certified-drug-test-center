<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'Certified Drug Test Center'),
            'site_phone' => Setting::get('site_phone', '(800)-985-4339'),
            'site_email' => Setting::get('site_email', 'support@certifieddrugtesting.com'),
            'site_tagline' => Setting::get('site_tagline', 'Accredited Drug Testing Made Fast, Simple & Confidential'),
            'paytrace_username' => Setting::get('paytrace_username', 'demo123'),
            'paytrace_password' => Setting::get('paytrace_password', 'password123'),
            'paytrace_integrator_id' => Setting::get('paytrace_integrator_id', '123456'),
            'paytrace_test_mode' => Setting::get('paytrace_test_mode', '1'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:150',
            'site_phone' => 'required|string|max:50',
            'site_email' => 'required|email|max:150',
            'site_tagline' => 'nullable|string|max:255',
            'paytrace_username' => 'required|string|max:100',
            'paytrace_password' => 'nullable|string',
            'paytrace_integrator_id' => 'required|string|max:100',
            'paytrace_test_mode' => 'required|in:0,1',
        ]);

        Setting::set('site_name', $validated['site_name'], 'general');
        Setting::set('site_phone', $validated['site_phone'], 'general');
        Setting::set('site_email', $validated['site_email'], 'general');
        Setting::set('site_tagline', $validated['site_tagline'] ?? '', 'general');

        Setting::set('paytrace_username', $validated['paytrace_username'], 'payment');
        if (!empty($validated['paytrace_password'])) {
            Setting::set('paytrace_password', $validated['paytrace_password'], 'payment', true);
        }
        Setting::set('paytrace_integrator_id', $validated['paytrace_integrator_id'], 'payment');
        Setting::set('paytrace_test_mode', $validated['paytrace_test_mode'], 'payment');

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
