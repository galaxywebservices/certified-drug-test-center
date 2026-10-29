@extends('layouts.main')

@section('title', 'Corporate Employer Compliance Portal | Certified Drug Test Centers')
@section('meta_description', 'Secure employer self-service portal for nationwide drug testing, electronic donor pass dispatch, real-time lab tracking, and MRO verified result certificates.')

@section('content')
<style>
    .portal-hero {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #FFFFFF;
        padding: 56px 20px 48px;
        text-align: center;
        border-bottom: 4px solid #C1121F;
    }
    .portal-hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(16, 185, 129, 0.15);
        color: #6EE7B7;
        border: 1px solid rgba(16, 185, 129, 0.35);
        padding: 6px 14px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 20px;
    }
    .portal-hero h1 {
        font-size: 38px;
        font-weight: 900;
        margin: 0 0 14px;
        line-height: 1.2;
    }
    .portal-hero p {
        font-size: 16px;
        color: #CBD5E1;
        max-width: 680px;
        margin: 0 auto;
        line-height: 1.6;
    }
    .portal-login-wrap {
        background: #F8FAFC;
        padding: 48px 20px 80px;
        min-height: 600px;
    }
    .portal-login-card {
        max-width: 540px;
        margin: 0 auto;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(11, 37, 69, 0.08);
        overflow: hidden;
    }
    .portal-card-header {
        background: #0B2545;
        color: #FFFFFF;
        padding: 24px 32px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .portal-card-header h2 {
        font-size: 20px;
        font-weight: 800;
        margin: 0 0 4px;
        color: #FFFFFF;
    }
    .portal-card-header p {
        font-size: 12px;
        color: #94A3B8;
        margin: 0;
    }
    .portal-card-body {
        padding: 32px;
    }
    .portal-form-group {
        margin-bottom: 22px;
    }
    .portal-form-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }
    .portal-input {
        width: 100%;
        box-sizing: border-box;
        padding: 13px 16px;
        font-size: 14px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        background: #FFFFFF;
        color: #0F172A;
        font-family: inherit;
        transition: all 0.2s ease;
    }
    .portal-input:focus {
        outline: none;
        border-color: #0B2545;
        box-shadow: 0 0 0 3px rgba(11, 37, 69, 0.12);
    }
    .portal-btn-primary {
        width: 100%;
        padding: 14px 20px;
        background: #0B2545;
        color: #FFFFFF;
        font-size: 15px;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.15s ease;
        box-shadow: 0 4px 12px rgba(11, 37, 69, 0.2);
    }
    .portal-btn-primary:hover {
        background: #133E6E;
    }
    .portal-divider {
        display: flex;
        align-items: center;
        text-align: center;
        margin: 24px 0;
        color: #94A3B8;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .portal-divider::before, .portal-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #E2E8F0;
    }
    .portal-divider:not(:empty)::before { margin-right: 14px; }
    .portal-divider:not(:empty)::after { margin-left: 14px; }
    .portal-btn-demo {
        width: 100%;
        padding: 13px 20px;
        background: #FFFBEB;
        color: #92400E;
        border: 1px solid #FCD34D;
        font-size: 14px;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.15s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .portal-btn-demo:hover {
        background: #FEF3C7;
        border-color: #F59E0B;
    }
    .portal-notice-box {
        background: #EFF6FF;
        border: 1px solid #BFDBFE;
        color: #1E3A8A;
        padding: 14px 18px;
        border-radius: 8px;
        margin-bottom: 24px;
        font-size: 13px;
        font-weight: 500;
        line-height: 1.5;
    }
    .portal-trust-grid {
        max-width: 540px;
        margin: 32px auto 0;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        text-align: center;
    }
    .portal-trust-pill {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 14px 10px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }
    .portal-trust-pill h4 {
        margin: 0;
        font-size: 12px;
        font-weight: 800;
        color: #0B2545;
    }
    .portal-trust-pill p {
        margin: 4px 0 0;
        font-size: 11px;
        color: #64748B;
    }
    @media (max-width: 600px) {
        .portal-hero h1 { font-size: 28px; }
        .portal-trust-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="portal-hero">
    <div class="portal-hero-badge">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        SOC-2 Type II &amp; HIPAA Compliant Gateway
    </div>
    <h1>Corporate Employer <span style="color:#F59E0B;">Self-Service Portal</span></h1>
    <p>Manage your company's drug testing roster, dispatch instant electronic donor passes to remote job candidates, track live specimen accessioning, and download official MRO result certificates.</p>
</div>

<div class="portal-login-wrap">
    <div class="portal-login-card">
        <div class="portal-card-header">
            <div>
                <h2>Authorized Account Sign In</h2>
                <p>Enter your company credentials to access your testing roster</p>
            </div>
            <div style="font-size:24px;">🏢</div>
        </div>

        <div class="portal-card-body">
            @if(session('portal_notice'))
                <div class="portal-notice-box">
                    ℹ️ {{ session('portal_notice') }}
                </div>
            @endif

            <form action="{{ route('employers.portal.login') }}" method="POST">
                @csrf

                <div class="portal-form-group">
                    <label class="portal-form-label" for="account_identifier">Company Account Code or Work Email *</label>
                    <input type="text"
                           id="account_identifier"
                           name="account_identifier"
                           value="{{ old('account_identifier', 'CDTC-CORP-DEMO') }}"
                           required
                           class="portal-input"
                           placeholder="e.g. CDTC-CORP-DEMO or admin@company.com">
                    @error('account_identifier')
                        <p style="color:#DC2626; font-size:12px; font-weight:600; margin:6px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="portal-form-group">
                    <label class="portal-form-label" for="access_pin">Security Access PIN / Password *</label>
                    <input type="password"
                           id="access_pin"
                           name="access_pin"
                           value="123456"
                           required
                           class="portal-input"
                           placeholder="Enter 6-digit PIN">
                </div>

                <button type="submit" class="portal-btn-primary">
                    Sign In to Corporate Portal &rarr;
                </button>
            </form>

            <div class="portal-divider">
                <span>Instant Evaluation</span>
            </div>

            <form action="{{ route('employers.portal.demo') }}" method="POST">
                @csrf
                <button type="submit" class="portal-btn-demo">
                    <span style="font-size:16px;">⚡</span>
                    <span>Instant 1-Click Demo Login</span>
                    <span style="font-size:12px; font-weight:normal; opacity:0.85;">(Apex Logistics Roster)</span>
                </button>
            </form>

            <div style="margin-top:24px; padding-top:20px; border-top:1px solid #F1F5F9; text-align:center;">
                <p style="font-size:13px; color:#64748B; margin:0;">
                    Need a new corporate account?
                    <a href="{{ route('employers.index') }}#corporate-register" style="color:#0B2545; font-weight:700; text-decoration:underline; margin-left:4px;">
                        Register Company &rarr;
                    </a>
                </p>
            </div>
        </div>
    </div>

    <div class="portal-trust-grid">
        <div class="portal-trust-pill">
            <h4>SAMHSA Certified</h4>
            <p>Quest &amp; Labcorp PSCs</p>
        </div>
        <div class="portal-trust-pill">
            <h4>DOT FMCSA Pool</h4>
            <p>Clearinghouse Compliant</p>
        </div>
        <div class="portal-trust-pill">
            <h4>Consolidated Net-30</h4>
            <p>Monthly Itemized Terms</p>
        </div>
    </div>
</div>
@endsection
