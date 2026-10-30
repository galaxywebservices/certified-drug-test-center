@extends('layouts.main')

@section('content')
<style>
    /* ==========================================================================
       Premium Option 2 Checkout Styling: Corporate Clean, Trust & Precision
       ========================================================================== */
    .checkout-page-wrapper {
        background-color: #F8FAFC;
        padding-bottom: 80px;
    }

    /* Checkout Sub-Header / Trust Bar */
    .checkout-trust-banner {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        padding: 32px 0;
        border-bottom: 3px solid #C1121F;
    }

    .checkout-trust-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
    }

    .checkout-title-wrap h1 {
        font-family: var(--font-heading, 'Montserrat', sans-serif);
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #fff;
        margin-bottom: 6px;
    }

    .checkout-title-wrap p {
        font-size: 14px;
        color: #CBD5E1;
        margin: 0;
    }

    .checkout-security-badges {
        display: flex;
        align-items: center;
        gap: 16px;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.15);
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 13px;
        color: #F1F5F9;
    }

    .checkout-security-badge-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
    }

    /* 2-Column Checkout Layout */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1.8fr 1.2fr;
        gap: 32px;
        margin-top: 36px;
        align-items: start;
    }

    @media (max-width: 992px) {
        .checkout-grid {
            grid-template-columns: 1fr;
            gap: 24px;
        }
    }

    .card-details-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 16px;
    }

    @media (max-width: 640px) {
        .checkout-trust-banner {
            padding: 24px 0;
        }
        .checkout-title-wrap h1 {
            font-size: 22px;
            line-height: 1.25;
        }
        .checkout-security-badges {
            flex-wrap: wrap;
            gap: 10px;
            font-size: 12px;
            padding: 8px 12px;
        }
        .checkout-card {
            padding: 20px 16px;
            margin-bottom: 18px;
        }
        .checkout-card-header {
            flex-wrap: wrap;
            gap: 10px;
        }
        .card-details-row {
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }
        .card-details-row .billing-zip-cell {
            grid-column: span 2;
        }
        .btn-checkout-submit {
            font-size: 15px;
            padding: 16px 16px;
        }
        .order-summary-sidebar {
            padding: 20px 16px;
        }
    }

    /* Step Cards */
    .checkout-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 28px 32px;
        margin-bottom: 24px;
        box-shadow: 0 2px 8px rgba(11,37,69,0.04);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .checkout-card:hover {
        border-color: #CBD5E1;
        box-shadow: 0 4px 16px rgba(11,37,69,0.06);
    }

    .checkout-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #F1F5F9;
    }

    .checkout-card-title-group {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .checkout-step-pill {
        width: 32px;
        height: 32px;
        background: #0B2545;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 800;
        flex-shrink: 0;
    }

    .checkout-card-heading {
        font-family: var(--font-heading, 'Montserrat', sans-serif);
        font-size: 18px;
        font-weight: 800;
        color: #0B2545;
        margin: 0;
        letter-spacing: -0.2px;
    }

    .checkout-card-subheading {
        font-size: 13px;
        color: #64748B;
        margin-top: 2px;
    }

    /* Form Fields & Controls */
    .checkout-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    @media (max-width: 600px) {
        .checkout-form-row { grid-template-columns: 1fr; gap: 16px; }
    }

    .checkout-form-group {
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
    }

    .checkout-label {
        font-size: 13px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .checkout-label-req {
        color: #C1121F;
        font-weight: 800;
    }

    .checkout-input-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .checkout-input-icon {
        position: absolute;
        left: 14px;
        color: #94A3B8;
        pointer-events: none;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .checkout-input {
        width: 100%;
        font-family: 'Inter', sans-serif;
        font-size: 15px;
        color: #0F172A;
        background: #FFFFFF;
        border: 1.5px solid #CBD5E1;
        border-radius: 8px;
        padding: 13px 16px;
        box-sizing: border-box;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.02);
    }

    .checkout-input.with-icon {
        padding-left: 44px;
    }

    .checkout-input:focus {
        border-color: #0B2545;
        outline: none;
        box-shadow: 0 0 0 3px rgba(11,37,69,0.12);
        background: #FFFFFF;
    }

    .checkout-input::placeholder {
        color: #94A3B8;
        font-weight: 400;
    }

    .checkout-select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%230B2545'%3e%3cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 16px;
        padding-right: 42px;
        cursor: pointer;
    }

    .checkout-hint {
        font-size: 12px;
        color: #64748B;
        margin-top: 6px;
    }

    /* Selected Test Highlight Box */
    .selected-product-box {
        background: #F0F5FA;
        border: 1.5px solid #CBD5E1;
        border-radius: 10px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 14px;
    }

    .selected-product-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #475569;
        margin-top: 4px;
    }

    /* Payment Trust Bar */
    .payment-security-notice {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        border-radius: 8px;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 13px;
        color: #166534;
        font-weight: 500;
        margin-bottom: 20px;
    }

    .card-logos-row {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-logo-pill {
        border: 1px solid #E2E8F0;
        border-radius: 4px;
        padding: 2px 8px;
        font-size: 11px;
        font-weight: 800;
        color: #475569;
        background: #fff;
    }

    /* Primary CTA Button */
    .btn-checkout-submit {
        width: 100%;
        background: #C1121F;
        color: #FFFFFF;
        border: none;
        padding: 18px 24px;
        border-radius: 8px;
        font-family: var(--font-heading, 'Montserrat', sans-serif);
        font-size: 17px;
        font-weight: 800;
        letter-spacing: 0.2px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 14px rgba(193, 18, 31, 0.35);
        margin-top: 10px;
    }

    .btn-checkout-submit:hover {
        background: #9E0F1A;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(193, 18, 31, 0.45);
    }

    .btn-checkout-submit:active {
        transform: translateY(0);
    }

    /* Order Summary Card (Sidebar) */
    .order-summary-sidebar {
        background: #FFFFFF;
        border: 2px solid #0B2545;
        border-radius: 12px;
        padding: 28px;
        box-shadow: 0 10px 30px rgba(11,37,69,0.08);
        position: sticky;
        top: 24px;
    }

    .order-summary-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 16px;
        border-bottom: 2px solid #F1F5F9;
        margin-bottom: 20px;
    }

    .order-summary-title {
        font-family: var(--font-heading, 'Montserrat', sans-serif);
        font-size: 20px;
        font-weight: 800;
        color: #0B2545;
        margin: 0;
    }

    .order-item-hero {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 20px;
    }

    .order-item-name {
        font-size: 16px;
        font-weight: 700;
        color: #0B2545;
        margin-bottom: 4px;
    }

    .order-item-badges {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
        font-size: 12px;
    }

    .order-breakdown-list {
        list-style: none;
        padding: 0;
        margin: 0 0 20px;
        font-size: 14px;
    }

    .order-breakdown-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #F1F5F9;
        color: #475569;
    }

    .order-breakdown-row strong {
        color: #0B2545;
    }

    .order-breakdown-free {
        color: #16A34A;
        font-weight: 700;
        font-size: 13px;
    }

    .order-total-block {
        background: #F0F5FA;
        border-radius: 8px;
        padding: 16px 20px;
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        margin-bottom: 20px;
        border: 1px solid #CBD5E1;
    }

    .order-total-label {
        font-size: 16px;
        font-weight: 800;
        color: #0B2545;
    }

    .order-total-amount {
        font-family: var(--font-heading, 'Montserrat', sans-serif);
        font-size: 32px;
        font-weight: 900;
        color: #C1121F;
        line-height: 1;
    }

    .trust-guarantee-bullets {
        list-style: none;
        padding: 0;
        margin: 0 0 20px;
        font-size: 13px;
        color: #475569;
        line-height: 1.6;
    }

    .trust-guarantee-bullets li {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
    }

    .trust-guarantee-bullets svg {
        color: #16A34A;
        flex-shrink: 0;
    }

    .help-hotline-box {
        background: #0B2545;
        color: #fff;
        border-radius: 8px;
        padding: 16px;
        text-align: center;
    }

    .help-hotline-box a {
        color: #FFFFFF;
        font-weight: 800;
        font-size: 17px;
        text-decoration: none;
        display: block;
        margin-top: 4px;
    }

    .help-hotline-box a:hover {
        text-decoration: underline;
    }
</style>

<div class="checkout-page-wrapper">
    <!-- Top Header Trust Banner -->
    <div class="checkout-trust-banner">
        <div class="container checkout-trust-inner">
            <div class="checkout-title-wrap">
                <h1>Express Online Test Registration &amp; Checkout</h1>
                <p>Get your official electronic Donor Pass in 2 minutes. Walk-ins accepted at over 20,000 Quest &amp; Labcorp facilities.</p>
            </div>
            <div class="checkout-security-badges">
                <div class="checkout-security-badge-item">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span>256-Bit SSL Encrypted</span>
                </div>
                <span>•</span>
                <div class="checkout-security-badge-item">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span>HIPAA Compliant</span>
                </div>
                <span>•</span>
                <div class="checkout-security-badge-item">
                    <span>PayTrace Verified</span>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @if(session('error'))
            <div style="background:#FEE2E2; border:1px solid #FECACA; color:#991B1B; padding:16px 20px; border-radius:8px; margin:24px 0 0; font-weight:600; display:flex; align-items:center; gap:10px;">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
            @csrf

            <div class="checkout-grid">
                <!-- Left Column: 3 Structured Registration Steps -->
                <div>
                    <!-- STEP 1: Select Testing Package -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="checkout-card-title-group">
                                <span class="checkout-step-pill">1</span>
                                <div>
                                    <h2 class="checkout-card-heading">Select Testing Package</h2>
                                    <div class="checkout-card-subheading">Choose your drug or alcohol test panel</div>
                                </div>
                            </div>
                            <span class="badge" style="background:#E0F2FE; color:#0369A1; font-weight:700;">Quest &amp; Labcorp</span>
                        </div>

                        <div class="checkout-form-group" style="margin-bottom:0;">
                            <label class="checkout-label" for="product_id">
                                <span>Testing Panel / Service <span class="checkout-label-req">*</span></span>
                                <span style="font-size:12px; color:#64748B; font-weight:500;">Includes lab &amp; MRO doctor review</span>
                            </label>
                            <div class="checkout-input-wrap">
                                <select id="product_id" name="product_id" class="checkout-input checkout-select" onchange="updateSelectedProduct(this)" required>
                                    @foreach($allProducts as $p)
                                        <option value="{{ $p->id }}" 
                                                data-price="{{ $p->price }}" 
                                                data-retail="{{ $p->retail_price }}"
                                                data-name="{{ $p->name }}" 
                                                data-specimen="{{ ucfirst($p->specimen_type) }}"
                                                data-turnaround="{{ $p->turnaround_time }}"
                                                {{ ($product && $product->id == $p->id) ? 'selected' : '' }}>
                                            {{ $p->name }} — ${{ number_format($p->price, 2) }} ({{ $p->turnaround_time }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="selected-product-box">
                                <div>
                                    <strong style="color:#0B2545; font-size:15px;" id="highlightProdName">{{ $product->name ?? 'Drug Test' }}</strong>
                                    <div class="selected-product-meta">
                                        <span class="badge" style="background:#DCFCE7; color:#15803D; font-size:11px;" id="highlightSpecimen">{{ ucfirst($product->specimen_type ?? 'Urine') }} Specimen</span>
                                        <span id="highlightTurnaround">● {{ $product->turnaround_time ?? '24-48 Hours' }}</span>
                                    </div>
                                </div>
                                <div style="text-align:right;">
                                    <div style="font-size:22px; font-weight:900; color:#C1121F;" id="highlightPrice">${{ number_format($product->price ?? 89.99, 2) }}</div>
                                    <small style="color:#16A34A; font-weight:700; font-size:11px;">Online Discount Applied</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: Donor Demographics -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="checkout-card-title-group">
                                <span class="checkout-step-pill">2</span>
                                <div>
                                    <h2 class="checkout-card-heading">Donor Information (Person Being Tested)</h2>
                                    <div class="checkout-card-subheading">Must match government photo ID presented at the testing center</div>
                                </div>
                            </div>
                        </div>

                        @if(!empty($selectedLocation))
                        <div style="background:#F0FDF4; border:1px solid #BBF7D0; border-radius:8px; padding:14px 16px; margin-bottom:18px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div style="width:36px; height:36px; border-radius:50%; background:#DCFCE7; color:#15803D; display:flex; align-items:center; justify-content:center; font-size:18px;">
                                    📍
                                </div>
                                <div>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span class="badge" style="background:#16A34A; color:#fff; font-size:10px; font-weight:800; text-transform:uppercase;">Selected Testing Facility</span>
                                        <span style="font-size:12px; color:#15803D; font-weight:700;">{{ ucfirst($selectedLocation->provider) }} Certified</span>
                                    </div>
                                    <strong style="color:#0B2545; font-size:14px; display:block; margin-top:2px;">{{ $selectedLocation->name }}</strong>
                                    <div style="font-size:12px; color:#475569;">{{ $selectedLocation->address1 }}, {{ $selectedLocation->city }}, {{ $selectedLocation->state }} {{ $selectedLocation->zip }}</div>
                                </div>
                            </div>
                            <a href="{{ route('locations.show', $selectedLocation->id) }}" target="_blank" style="font-size:12px; color:#0B2545; font-weight:700; text-decoration:underline;">
                                View Facility Profile &rarr;
                            </a>
                            <input type="hidden" name="location_id" value="{{ $selectedLocation->id }}">
                        </div>
                        @endif

                        <div class="checkout-form-row">
                            <div class="checkout-form-group">
                                <label class="checkout-label" for="first_name">Donor First Name <span class="checkout-label-req">*</span></label>
                                <div class="checkout-input-wrap">
                                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" class="checkout-input" placeholder="e.g. John" required>
                                </div>
                            </div>

                            <div class="checkout-form-group">
                                <label class="checkout-label" for="last_name">Donor Last Name <span class="checkout-label-req">*</span></label>
                                <div class="checkout-input-wrap">
                                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="checkout-input" placeholder="e.g. Doe" required>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-form-row">
                            <div class="checkout-form-group">
                                <label class="checkout-label" for="email">
                                    <span>Donor Email <span class="checkout-label-req">*</span></span>
                                </label>
                                <div class="checkout-input-wrap">
                                    <span class="checkout-input-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                                    </span>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" class="checkout-input with-icon" placeholder="donor@example.com" required>
                                </div>
                                <div class="checkout-hint">Electronic Donor Pass &amp; lab results notification will be sent here.</div>
                            </div>

                            <div class="checkout-form-group">
                                <label class="checkout-label" for="phone">Donor Phone Number <span class="checkout-label-req">*</span></label>
                                <div class="checkout-input-wrap">
                                    <span class="checkout-input-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    </span>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" class="checkout-input with-icon" placeholder="(555) 000-0000" required>
                                </div>
                                <div class="checkout-hint">For MRO physician verification if needed.</div>
                            </div>
                        </div>

                        <div class="checkout-form-row" style="margin-bottom:0;">
                            <div class="checkout-form-group">
                                <label class="checkout-label" for="test_reason">Reason for Testing <span class="checkout-label-req">*</span></label>
                                <div class="checkout-input-wrap">
                                    <select id="test_reason" name="test_reason" class="checkout-input checkout-select" required>
                                        <option value="employment">Pre-Employment / Job Requirement</option>
                                        <option value="dot">DOT Regulated Federal Test (FMCSA/FAA/USCG)</option>
                                        <option value="court">Court Ordered / Probation / Legal</option>
                                        <option value="personal">Personal / Family Testing</option>
                                        <option value="post-accident">Post-Accident / Reasonable Suspicion</option>
                                    </select>
                                </div>
                            </div>

                            <div class="checkout-form-group">
                                <label class="checkout-label" for="zip">Preferred Collection ZIP Code <span class="checkout-label-req">*</span></label>
                                <div class="checkout-input-wrap">
                                    <span class="checkout-input-icon">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </span>
                                    <input type="text" id="zip" name="zip" value="{{ old('zip', $selectedLocation ? $selectedLocation->zip : request('zip', '')) }}" class="checkout-input with-icon" placeholder="e.g. 90210" maxlength="5" pattern="[0-9]{5}" required>
                                </div>
                                <div class="checkout-hint">We will assign the nearest certified Quest or Labcorp center.</div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: PayTrace Gateway Payment -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <div class="checkout-card-title-group">
                                <span class="checkout-step-pill">3</span>
                                <div>
                                    <h2 class="checkout-card-heading">Secure Payment (PayTrace Gateway)</h2>
                                    <div class="checkout-card-subheading">All major credit and debit cards accepted</div>
                                </div>
                            </div>
                            <div class="card-logos-row">
                                <span class="card-logo-pill">VISA</span>
                                <span class="card-logo-pill">MC</span>
                                <span class="card-logo-pill">AMEX</span>
                                <span class="card-logo-pill">DISC</span>
                            </div>
                        </div>

                        <div class="payment-security-notice">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            <span>Encrypted 256-Bit SSL Connection. Direct PayTrace Merchant Gateway Clearance.</span>
                        </div>

                        <div class="checkout-form-group">
                            <label class="checkout-label" for="card_number">Card Number <span class="checkout-label-req">*</span></label>
                            <div class="checkout-input-wrap">
                                <span class="checkout-input-icon">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </span>
                                <input type="text" id="card_number" name="card_number" class="checkout-input with-icon" placeholder="•••• •••• •••• ••••" required maxlength="19" autocomplete="cc-number">
                            </div>
                        </div>

                        <div class="card-details-row">
                            <div class="checkout-form-group">
                                <label class="checkout-label" for="exp">Exp Date <span class="checkout-label-req">*</span></label>
                                <input type="text" id="exp" name="exp" class="checkout-input" placeholder="MM/YY" required maxlength="5" autocomplete="cc-exp">
                            </div>

                            <div class="checkout-form-group">
                                <label class="checkout-label" for="cvv">CVV / CVC <span class="checkout-label-req">*</span></label>
                                <input type="password" id="cvv" name="cvv" class="checkout-input" placeholder="3 or 4 digits" required maxlength="4" autocomplete="cc-csc">
                            </div>

                            <div class="checkout-form-group billing-zip-cell">
                                <label class="checkout-label" for="billing_zip">Billing ZIP <span class="checkout-label-req">*</span></label>
                                <input type="text" id="billing_zip" name="billing_zip" class="checkout-input" placeholder="10001" required maxlength="5">
                            </div>
                        </div>

                        <button type="submit" class="btn-checkout-submit" id="submitOrderBtn">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            <span>Authorize Payment &amp; Obtain Electronic Donor Pass</span>
                        </button>

                        <div style="text-align:center; margin-top:12px; font-size:12px; color:#64748B;">
                            🔒 Your card will be securely processed for <strong id="btnPricePreview">${{ number_format($product->price ?? 89.99, 2) }}</strong>. No further fees at the testing center.
                        </div>
                    </div>
                </div>

                <!-- Right Column: Sticky Order Summary & Trust Guarantee -->
                <div>
                    <aside class="order-summary-sidebar">
                        <div class="order-summary-header">
                            <h3 class="order-summary-title">Order Summary</h3>
                            <span class="badge" style="background:#DCFCE7; color:#15803D; font-weight:700;">Guaranteed Package</span>
                        </div>

                        <div class="order-item-hero">
                            <div class="order-item-name" id="summaryTestTitle">{{ $product->name ?? '5 Panel NON-DOT Drug Test' }}</div>
                            <div class="order-item-badges">
                                <span class="badge badge-neutral" id="summarySpecimenBadge">{{ ucfirst($product->specimen_type ?? 'Urine') }}</span>
                                <span style="color:#64748B;" id="summaryTurnaroundBadge">• {{ $product->turnaround_time ?? '24-48 Hours' }}</span>
                            </div>
                        </div>

                        <ul class="order-breakdown-list">
                            <li class="order-breakdown-row">
                                <span>Laboratory Testing Service</span>
                                <strong id="summaryBasePrice">${{ number_format($product->price ?? 89.99, 2) }}</strong>
                            </li>
                            <li class="order-breakdown-row">
                                <span>Quest &amp; Labcorp Collection Fee</span>
                                <span class="order-breakdown-free">INCLUDED ($0.00)</span>
                            </li>
                            <li class="order-breakdown-row">
                                <span>Physician MRO Review</span>
                                <span class="order-breakdown-free">INCLUDED ($0.00)</span>
                            </li>
                            <li class="order-breakdown-row">
                                <span>Instant Electronic Donor Pass</span>
                                <span class="order-breakdown-free">FREE ($0.00)</span>
                            </li>
                        </ul>

                        <div class="order-total-block">
                            <span class="order-total-label">Total Amount Due:</span>
                            <div class="order-total-amount" id="summaryTotalDue">${{ number_format($product->price ?? 89.99, 2) }}</div>
                        </div>

                        <ul class="trust-guarantee-bullets">
                            <li>
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span><strong>Zero Hidden On-Site Fees:</strong> Nothing to pay at lab.</span>
                            </li>
                            <li>
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span><strong>Walk-Ins Welcome:</strong> No appointment necessary.</span>
                            </li>
                            <li>
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                <span><strong>SAMHSA Certified:</strong> Court &amp; DOT legally defensible.</span>
                            </li>
                        </ul>

                        <div class="help-hotline-box">
                            <div style="font-size:11px; text-transform:uppercase; color:#94A3B8; font-weight:700;">Prefer Scheduling By Phone?</div>
                            <div style="font-size:13px; color:#E2E8F0; margin-top:2px;">Call Our National Support Team</div>
                            <a href="tel:18009854339">(800)-985-4339</a>
                        </div>
                    </aside>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function updateSelectedProduct(selectElem) {
        const option = selectElem.options[selectElem.selectedIndex];
        const price = parseFloat(option.getAttribute('data-price')).toFixed(2);
        const name = option.getAttribute('data-name');
        const specimen = option.getAttribute('data-specimen');
        const turnaround = option.getAttribute('data-turnaround');

        // Update highlight box in step 1
        document.getElementById('highlightProdName').textContent = name;
        document.getElementById('highlightPrice').textContent = '$' + price;
        document.getElementById('highlightSpecimen').textContent = specimen + ' Specimen';
        document.getElementById('highlightTurnaround').textContent = '● ' + turnaround;

        // Update order summary card
        document.getElementById('summaryTestTitle').textContent = name;
        document.getElementById('summarySpecimenBadge').textContent = specimen;
        document.getElementById('summaryTurnaroundBadge').textContent = '• ' + turnaround;
        document.getElementById('summaryBasePrice').textContent = '$' + price;
        document.getElementById('summaryTotalDue').textContent = '$' + price;
        document.getElementById('btnPricePreview').textContent = '$' + price;
    }

    // Auto-format card number with spaces (4 4 4 4)
    document.getElementById('card_number').addEventListener('input', function (e) {
        let val = e.target.value.replace(/\D/g, '');
        let formatted = val.match(/.{1,4}/g)?.join(' ') || '';
        e.target.value = formatted.substring(0, 19);
    });

    // Auto-format exp date (MM/YY)
    document.getElementById('exp').addEventListener('input', function (e) {
        let val = e.target.value.replace(/\D/g, '');
        if (val.length >= 2) {
            e.target.value = val.substring(0, 2) + '/' + val.substring(2, 4);
        } else {
            e.target.value = val;
        }
    });
</script>
@endsection
