@extends('admin.layouts.app', ['title' => 'PayTrace & Settings', 'heading' => 'PayTrace Gateway & Site Settings'])

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
        <!-- PayTrace Gateway Card -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">PayTrace Payment Gateway</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Configure client's PayTrace merchant gateway credentials
                    </p>
                </div>
                <span class="badge badge-info">Direct REST API</span>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="paytrace_username">PayTrace Username *</label>
                    <input type="text" id="paytrace_username" name="paytrace_username" value="{{ old('paytrace_username', $settings['paytrace_username']) }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="paytrace_password">PayTrace Password / API Key</label>
                    <input type="password" id="paytrace_password" name="paytrace_password" class="form-control" placeholder="•••••••••••••• (Leave blank to keep unchanged)">
                    <div class="form-hint">Stored securely using 256-bit AES encryption.</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="paytrace_integrator_id">PayTrace Integrator ID <span style="font-weight:normal; color:#64748B;">(Optional)</span></label>
                    <input type="text" id="paytrace_integrator_id" name="paytrace_integrator_id" value="{{ old('paytrace_integrator_id', $settings['paytrace_integrator_id']) }}" class="form-control" placeholder="Leave blank if not provided by PayTrace">
                    <div class="form-hint">Optional. PayTrace does not require this for standard direct merchant accounts. Only enter if PayTrace explicitly assigned you an Integrator ID.</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="paytrace_test_mode">Environment Mode *</label>
                    <select id="paytrace_test_mode" name="paytrace_test_mode" class="form-control" required>
                        <option value="1" {{ $settings['paytrace_test_mode'] == '1' ? 'selected' : '' }}>
                            Sandbox / Test Mode (Simulated approvals enabled)
                        </option>
                        <option value="0" {{ $settings['paytrace_test_mode'] == '0' ? 'selected' : '' }}>
                            Live Production Gateway (Real credit card charges)
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <!-- General Site Configuration Card -->
        <div class="card">
            <div class="card-header">
                <div>
                    <h2 class="card-title">General Brand &amp; Contact Info</h2>
                    <p style="font-size:13px; color:var(--admin-slate-500); margin-top:2px;">
                        Displayed across header, footer, and electronic donor pass
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="form-label" for="site_name">Company / Site Name *</label>
                    <input type="text" id="site_name" name="site_name" value="{{ old('site_name', $settings['site_name']) }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="site_phone">Toll-Free Phone Hotline *</label>
                    <input type="text" id="site_phone" name="site_phone" value="{{ old('site_phone', $settings['site_phone']) }}" class="form-control" required>
                    <div class="form-hint">Displayed prominently in Option 2 header: (800)-985-4339</div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="site_email">Support Email Address *</label>
                    <input type="email" id="site_email" name="site_email" value="{{ old('site_email', $settings['site_email']) }}" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="site_tagline">Brand Tagline</label>
                    <input type="text" id="site_tagline" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline']) }}" class="form-control">
                </div>

                <div style="border-top:1px solid var(--admin-slate-200); margin:20px 0 16px; padding-top:16px;">
                    <h3 style="font-size:14px; font-weight:800; color:var(--admin-navy-900); margin-bottom:4px;">
                        🚨 Online Order Notifications
                    </h3>
                    <p style="font-size:12px; color:var(--admin-slate-500); margin-bottom:12px;">
                        Configure automated dispatch email recipients for all incoming customer orders.
                    </p>

                    <div class="form-group">
                        <label class="form-label" for="online_orders_email">Primary Order Recipient (To:) *</label>
                        <input type="email" id="online_orders_email" name="online_orders_email" value="{{ old('online_orders_email', $settings['online_orders_email']) }}" class="form-control" required>
                        <div class="form-hint">Default: onlineorders@accrediteddrugtesting.com</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="online_orders_bcc">Order Tracking BCC Recipients</label>
                        <input type="text" id="online_orders_bcc" name="online_orders_bcc" value="{{ old('online_orders_bcc', $settings['online_orders_bcc']) }}" class="form-control" placeholder="comma-separated emails">
                        <div class="form-hint">Comma-separated emails (e.g. galaxywebservices@gmail.com, jacserafini@gmail.com)</div>
                    </div>
                </div>

                <div style="margin-top:24px;">
                    <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; padding:12px;">
                        Save Configuration Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
