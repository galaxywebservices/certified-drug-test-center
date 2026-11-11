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
            'site_email' => Setting::get('site_email', 'support@certifieddrugtestingcenters.com'),
            'site_tagline' => Setting::get('site_tagline', 'Accredited Drug Testing Made Fast, Simple & Confidential'),
            'online_orders_email' => Setting::get('online_orders_email', config('mail.online_orders.to', 'onlineorders@accrediteddrugtesting.com')),
            'online_orders_bcc' => Setting::get('online_orders_bcc', implode(', ', config('mail.online_orders.bcc', ['galaxywebservices@gmail.com', 'jacserafini@gmail.com']))),
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
            'online_orders_email' => 'required|email|max:150',
            'online_orders_bcc' => 'nullable|string|max:255',
            'paytrace_username' => 'required|string|max:100',
            'paytrace_password' => 'nullable|string',
            'paytrace_integrator_id' => 'nullable|string|max:100',
            'paytrace_test_mode' => 'required|in:0,1',
        ]);

        try {
            Setting::set('site_name', trim($validated['site_name']), 'general');
            Setting::set('site_phone', trim($validated['site_phone']), 'general');
            Setting::set('site_email', trim($validated['site_email']), 'general');
            Setting::set('site_tagline', isset($validated['site_tagline']) ? trim($validated['site_tagline']) : '', 'general');
            Setting::set('online_orders_email', trim($validated['online_orders_email']), 'orders');
            Setting::set('online_orders_bcc', isset($validated['online_orders_bcc']) ? trim($validated['online_orders_bcc']) : '', 'orders');

            Setting::set('paytrace_username', trim($validated['paytrace_username']), 'payment');
            if (!empty($validated['paytrace_password'])) {
                Setting::set('paytrace_password', trim($validated['paytrace_password']), 'payment', true);
            }
            Setting::set('paytrace_integrator_id', isset($validated['paytrace_integrator_id']) ? trim($validated['paytrace_integrator_id']) : '', 'payment');
            Setting::set('paytrace_test_mode', (string)$validated['paytrace_test_mode'], 'payment');

            return redirect()->route('admin.settings.index')->with('success', 'PayTrace credentials and site settings updated successfully.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Settings update failed: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            return redirect()->back()->withInput()->with('error', 'Failed to save settings: ' . $e->getMessage());
        }
    }
}
