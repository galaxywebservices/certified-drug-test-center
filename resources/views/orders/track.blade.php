@extends('layouts.main')

@section('content')
<style>
    @media print {
        header, footer, .top-notice-bar, .no-print, .track-lookup-card, .track-faq-section { display: none !important; }
        body { background: #fff !important; }
        .pass-container { box-shadow: none !important; border: 2px solid #000 !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; }
    }

    .track-hero {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        padding: 40px 0;
        border-bottom: 3px solid #C1121F;
    }

    .track-container {
        max-width: 960px;
        margin: 0 auto;
        padding: 40px 20px 80px;
    }

    .track-lookup-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 32px;
        box-shadow: 0 4px 16px rgba(11, 37, 69, 0.06);
        margin-bottom: 36px;
    }

    /* 5-Step Visual Timeline */
    .timeline-wrap {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 28px 24px;
        margin-bottom: 32px;
        box-shadow: 0 2px 10px rgba(11, 37, 69, 0.04);
    }

    .timeline-steps {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 12px;
        position: relative;
        margin-top: 24px;
    }

    @media (max-width: 768px) {
        .timeline-steps {
            grid-template-columns: 1fr;
            gap: 16px;
        }
    }

    .step-node {
        text-align: center;
        position: relative;
    }

    .step-circle {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        margin: 0 auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 15px;
        transition: all 0.2s ease;
    }

    .step-done .step-circle {
        background: #10B981;
        color: #FFFFFF;
        box-shadow: 0 0 0 4px #D1FAE5;
    }

    .step-active .step-circle {
        background: #0B2545;
        color: #FFFFFF;
        box-shadow: 0 0 0 5px rgba(11, 37, 69, 0.15);
        animation: pulseRing 2s infinite;
    }

    .step-pending .step-circle {
        background: #F1F5F9;
        color: #94A3B8;
        border: 1px solid #CBD5E1;
    }

    .step-title {
        font-size: 13px;
        font-weight: 700;
        color: #0B2545;
        margin-bottom: 2px;
    }

    .step-desc {
        font-size: 11px;
        color: #64748B;
        line-height: 1.4;
    }

    @keyframes pulseRing {
        0% { box-shadow: 0 0 0 0 rgba(11, 37, 69, 0.25); }
        70% { box-shadow: 0 0 0 8px rgba(11, 37, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(11, 37, 69, 0); }
    }

    /* Electronic Donor Pass Document */
    .pass-container {
        background: #FFFFFF;
        border: 2px solid #0B2545;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 24px rgba(11, 37, 69, 0.08);
        margin-bottom: 32px;
    }

    .pass-header {
        background: #0B2545;
        color: #FFFFFF;
        padding: 22px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .pass-body {
        padding: 28px;
    }

    .pass-barcode-box {
        text-align: center;
        background: #F8FAFC;
        border: 2px dashed #CBD5E1;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
    }

    .barcode-display {
        font-family: 'Courier New', monospace;
        font-size: 38px;
        font-weight: 800;
        letter-spacing: 7px;
        color: #0B2545;
        margin: 6px 0;
        word-break: break-all;
    }

    .pass-grid-2col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
    }

    @media (max-width: 680px) {
        .pass-grid-2col { grid-template-columns: 1fr; }
    }

    .pass-info-card {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 16px;
    }

    .pass-info-label {
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        color: #64748B;
        letter-spacing: 0.5px;
        margin-bottom: 6px;
    }

    .pass-info-value {
        font-size: 14.5px;
        font-weight: 700;
        color: #0B2545;
    }

    .track-faq-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 24px;
        margin-top: 32px;
    }
</style>

<!-- Hero Section -->
<div class="track-hero no-print">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Breadcrumb" style="display:flex; gap:8px; font-size:13px; color:#94A3B8; margin-bottom:12px;">
            <a href="{{ url('/') }}" style="color:#CBD5E1; text-decoration:none;">Home</a>
            <span>&rsaquo;</span>
            <span style="color:#fff;">Order Tracking & Donor Pass</span>
        </nav>
        <h1 style="font-size:32px; font-weight:800; color:#fff; margin-bottom:8px;">
            Track Order &amp; Electronic Donor Pass
        </h1>
        <p style="font-size:15px; color:#E2E8F0; max-width:700px; margin:0;">
            Check real-time laboratory verification status, view your assigned Quest &amp; Labcorp collection site, or re-print your authorization barcode.
        </p>
    </div>
</div>

<div class="container track-container">

    @if(session('success'))
        <div style="background:#ECFDF5; border:1px solid #6EE7B7; color:#065F46; padding:16px 20px; border-radius:8px; margin-bottom:24px; font-size:14px; display:flex; align-items:center; gap:10px;">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div style="background:#FEF2F2; border:1px solid #FCA5A5; color:#991B1B; padding:16px 20px; border-radius:8px; margin-bottom:24px; font-size:14px; display:flex; align-items:center; gap:10px;">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Order Lookup Form Card -->
    <div class="track-lookup-card no-print">
        <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:12px; margin-bottom:20px;">
            <div>
                <span class="badge" style="background:#E0F2FE; color:#0369A1; font-size:11px; font-weight:800; text-transform:uppercase;">Self-Service Portal</span>
                <h2 style="font-size:20px; font-weight:800; color:#0B2545; margin-top:6px; margin-bottom:2px;">Lookup Test Registration</h2>
                <p style="font-size:13.5px; color:#64748B; margin:0;">Enter the CDTC Order Number from your confirmation email and donor email address.</p>
            </div>
            <a href="tel:18002214291" style="font-size:13px; font-weight:700; color:#C1121F; text-decoration:none;">
                Lost Your Receipt? Call: (800) 221-4291
            </a>
        </div>

        <form action="{{ route('order.track.lookup') }}" method="POST">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr auto; gap:14px; align-items:end;">
                <div>
                    <label for="order_number" style="display:block; font-size:12.5px; font-weight:700; color:#334155; margin-bottom:6px;">Order Number *</label>
                    <input type="text" id="order_number" name="order_number" value="{{ old('order_number', $orderNumber ?? '') }}" placeholder="e.g. CDTC-A1B2C3D4" required style="width:100%; padding:10px 14px; border:1px solid #CBD5E1; border-radius:6px; font-size:14.5px; font-weight:600; text-transform:uppercase; outline:none;">
                    @error('order_number')
                        <span style="color:#C1121F; font-size:11.5px; display:block; margin-top:4px;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email" style="display:block; font-size:12.5px; font-weight:700; color:#334155; margin-bottom:6px;">Donor Email Address *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email ?? '') }}" placeholder="e.g. donor@example.com" required style="width:100%; padding:10px 14px; border:1px solid #CBD5E1; border-radius:6px; font-size:14.5px; outline:none;">
                    @error('email')
                        <span style="color:#C1121F; font-size:11.5px; display:block; margin-top:4px;">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="btn btn-primary" style="padding:11px 22px; font-weight:700; font-size:14.5px; white-space:nowrap;">
                        Track Registration &rarr;
                    </button>
                </div>
            </div>
        </form>
    </div>

    @if($order)
        @php
            $status = $order->status ?? 'registered';
            $stepMap = [
                'registered' => 1,
                'specimen_collected' => 2,
                'lab_processing' => 3,
                'mro_review' => 4,
                'completed' => 5,
                'cancelled' => 0,
            ];
            $currentStep = $stepMap[$status] ?? 1;
        @endphp

        <!-- 5-Step Status Progression -->
        <div class="timeline-wrap no-print">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:12px; padding-bottom:14px; border-bottom:1px solid #E2E8F0;">
                <div>
                    <span style="font-size:12px; font-weight:700; text-transform:uppercase; color:#64748B;">Current Status</span>
                    <h3 style="font-size:18px; font-weight:800; color:#0B2545; margin:2px 0 0;">
                        @if($status === 'registered')
                            Donor Pass Active — Ready for Same-Day Walk-In
                        @elseif($status === 'specimen_collected')
                            Specimen Collected — In Transit to Reference Lab
                        @elseif($status === 'lab_processing')
                            Laboratory Analysis &amp; GC/MS Screening
                        @elseif($status === 'mro_review')
                            Medical Review Officer (MRO) Verification
                        @elseif($status === 'completed')
                            Results Complete &amp; Securely Transmitted
                        @elseif($status === 'cancelled')
                            Order Registration Cancelled
                        @endif
                    </h3>
                </div>
                <div>
                    <span class="badge" style="background:{{ $status === 'completed' ? '#DCFCE7' : ($status === 'cancelled' ? '#FEE2E2' : '#E0F2FE') }}; color:{{ $status === 'completed' ? '#15803D' : ($status === 'cancelled' ? '#B91C1C' : '#0369A1') }}; font-size:12px; font-weight:700; padding:6px 12px;">
                        {{ strtoupper(str_replace('_', ' ', $status)) }}
                    </span>
                </div>
            </div>

            <div class="timeline-steps">
                <!-- Step 1 -->
                <div class="step-node {{ $currentStep >= 1 ? ($currentStep == 1 ? 'step-active' : 'step-done') : 'step-pending' }}">
                    <div class="step-circle">{{ $currentStep > 1 ? '✓' : '1' }}</div>
                    <div class="step-title">1. Pass Issued</div>
                    <div class="step-desc">Registration active &amp; barcode ready</div>
                </div>

                <!-- Step 2 -->
                <div class="step-node {{ $currentStep >= 2 ? ($currentStep == 2 ? 'step-active' : 'step-done') : 'step-pending' }}">
                    <div class="step-circle">{{ $currentStep > 2 ? '✓' : '2' }}</div>
                    <div class="step-title">2. Specimen Collected</div>
                    <div class="step-desc">Sample taken under chain-of-custody</div>
                </div>

                <!-- Step 3 -->
                <div class="step-node {{ $currentStep >= 3 ? ($currentStep == 3 ? 'step-active' : 'step-done') : 'step-pending' }}">
                    <div class="step-circle">{{ $currentStep > 3 ? '✓' : '3' }}</div>
                    <div class="step-title">3. Lab Testing</div>
                    <div class="step-desc">Quest / Labcorp immunoassay</div>
                </div>

                <!-- Step 4 -->
                <div class="step-node {{ $currentStep >= 4 ? ($currentStep == 4 ? 'step-active' : 'step-done') : 'step-pending' }}">
                    <div class="step-circle">{{ $currentStep > 4 ? '✓' : '4' }}</div>
                    <div class="step-title">4. MRO Review</div>
                    <div class="step-desc">Physician review &amp; confirmation</div>
                </div>

                <!-- Step 5 -->
                <div class="step-node {{ $currentStep >= 5 ? 'step-done' : 'step-pending' }}">
                    <div class="step-circle">{{ $currentStep >= 5 ? '✓' : '5' }}</div>
                    <div class="step-title">5. Results Released</div>
                    <div class="step-desc">Confidential electronic delivery</div>
                </div>
            </div>
        </div>

        <!-- Action Toolbar -->
        <div class="no-print" style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:20px;">
            <div style="font-size:14px; font-weight:700; color:#0B2545;">
                Electronic Donor Pass • Order #{{ $order->order_number }}
            </div>
            <div style="display:flex; gap:10px; flex-wrap:wrap;">
                <button type="button" onclick="window.print()" class="btn btn-navy btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print Donor Pass
                </button>

                <form action="{{ route('order.track.resend') }}" method="POST" style="margin:0;">
                    @csrf
                    <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                    <input type="hidden" name="email" value="{{ $order->donor_email }}">
                    <button type="submit" class="btn btn-outline-navy btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Resend to Email
                    </button>
                </form>

                @if($order->location)
                    <a href="https://maps.google.com/?q={{ urlencode($order->location->address1 . ', ' . $order->location->city . ', ' . $order->location->state . ' ' . $order->location->zip) }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm" style="display:inline-flex; align-items:center; gap:6px;">
                        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Get Lab Directions
                    </a>
                @endif
            </div>
        </div>

        <!-- Official Electronic Donor Pass Printable Card -->
        <div class="pass-container" id="printableDonorPass">
            <div class="pass-header">
                <div>
                    <div style="font-size:11px; font-weight:800; letter-spacing:1px; text-transform:uppercase; color:#94A3B8;">Certified Drug Test Centers • National Network</div>
                    <div style="font-size:22px; font-weight:800; margin-top:2px;">Official Electronic Donor Pass</div>
                    <div style="font-size:12px; color:#E2E8F0;">SAMHSA Certified Laboratory Testing &amp; Medical Review Officer (MRO) Service</div>
                </div>
                <div style="text-align:right;">
                    <div style="font-size:11px; text-transform:uppercase; color:#94A3B8;">Authorization Code:</div>
                    <div style="font-size:20px; font-weight:900; color:#FFFFFF;">{{ $order->order_number }}</div>
                    <div style="font-size:11px; color:#94A3B8;">Date: {{ $order->created_at->format('M d, Y') }}</div>
                </div>
            </div>

            <div class="pass-body">
                <!-- Barcode Area -->
                <div class="pass-barcode-box">
                    <div style="font-size:11px; font-weight:800; text-transform:uppercase; color:#64748B; letter-spacing:1px;">Collection Facility Intake Barcode</div>
                    <div class="barcode-display">||| | |||| || ||| |||| | |||</div>
                    <div style="font-family:monospace; font-size:16px; font-weight:700; color:#0B2545;">*{{ $order->order_number }}*</div>
                    <div style="font-size:12px; color:#475569; margin-top:4px;">Present this barcode on mobile phone or printed document upon arrival at the collection facility.</div>
                </div>

                <!-- Donor & Testing Facility Grids -->
                <div class="pass-grid-2col">
                    <div class="pass-info-card">
                        <div class="pass-info-label">Donor Information</div>
                        <div class="pass-info-value" style="font-size:16px;">{{ $order->donor_full_name }}</div>
                        <div style="font-size:13px; color:#475569; margin-top:6px; line-height:1.6;">
                            <strong>Phone:</strong> {{ $order->donor_phone }}<br>
                            <strong>Email:</strong> {{ $order->donor_email }}<br>
                            <strong>Testing Reason:</strong> {{ ucfirst($order->test_reason) }}
                        </div>
                    </div>

                    <div class="pass-info-card">
                        <div class="pass-info-label">Assigned Collection Site</div>
                        @if($order->location)
                            <div class="pass-info-value" style="font-size:15px; color:#0B2545;">{{ $order->location->name }}</div>
                            <div style="font-size:13px; color:#475569; margin-top:6px; line-height:1.6;">
                                {{ $order->location->address1 }}<br>
                                {{ $order->location->city }}, {{ $order->location->state }} {{ $order->location->zip }}<br>
                                <span style="color:#16A34A; font-weight:700;">● Hours: {{ $order->location->hours ?: 'Mon-Fri 8:00 AM - 5:00 PM' }}</span>
                            </div>
                        @else
                            <div class="pass-info-value">Any Quest Diagnostics or Labcorp Certified Site</div>
                            <div style="font-size:13px; color:#475569; margin-top:6px;">
                                Over 20,000 certified collection facilities nationwide accept this barcode.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Test Details & Ordered Items -->
                <div class="pass-info-card" style="margin-bottom:20px;">
                    <div class="pass-info-label">Authorized Testing Panels</div>
                    <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:8px;">
                        @foreach($order->items as $item)
                            <div>
                                <strong style="font-size:15px; color:#0B2545;">{{ $item->product_name }}</strong>
                                @if($item->product && $item->product->specimen_type)
                                    <span class="badge" style="background:#E0F2FE; color:#0369A1; font-size:11px; margin-left:6px;">
                                        {{ strtoupper($item->product->specimen_type) }}
                                    </span>
                                @endif
                            </div>
                            <div style="font-size:14px; font-weight:700; color:#16A34A;">
                                Paid • Chain of Custody Authorized
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Important Donor Instructions -->
                <div style="background:#FFFBEB; border:1px solid #FDE68A; border-radius:8px; padding:16px; font-size:12.5px; color:#92400E; line-height:1.6;">
                    <strong>Important Instructions for Donor:</strong>
                    <ul style="margin:6px 0 0; padding-left:18px;">
                        <li>You must bring a valid, unexpired government-issued photo ID (Driver's License, State ID, or Passport).</li>
                        <li>No appointment is needed. Walk-ins are accepted during collection hours.</li>
                        <li>For urine drug screens: Avoid drinking excessive fluids (more than 40 oz) within 2-4 hours prior to collection to prevent diluted specimen samples.</li>
                        <li>If you require assistance or collection site directions, call National Dispatch toll-free at <strong>(800) 221-4291</strong>.</li>
                    </ul>
                </div>
            </div>
        </div>

    @endif

    <!-- Donor Support & FAQ Section -->
    <div class="track-faq-card no-print">
        <h3 style="font-size:18px; font-weight:800; color:#0B2545; margin-bottom:14px;">Frequently Asked Questions About Donor Passes</h3>
        
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px;">
            <div>
                <h4 style="font-size:14px; font-weight:700; color:#0B2545; margin-bottom:4px;">Can I go to any Quest or Labcorp location?</h4>
                <p style="font-size:13px; color:#64748B; margin:0; line-height:1.5;">Yes. While an optimal location closest to your ZIP is assigned on your pass, your electronic authorization is recognized at over 20,000 partner collection facilities nationwide.</p>
            </div>
            <div>
                <h4 style="font-size:14px; font-weight:700; color:#0B2545; margin-bottom:4px;">When will my employer or I get the results?</h4>
                <p style="font-size:13px; color:#64748B; margin:0; line-height:1.5;">Negative laboratory results are typically finalized within 24 to 48 business hours after specimen collection. Non-negative results undergo confirmatory GC/MS testing and MRO physician consultation.</p>
            </div>
            <div>
                <h4 style="font-size:14px; font-weight:700; color:#0B2545; margin-bottom:4px;">Do I need to print this pass, or can I show my phone?</h4>
                <p style="font-size:13px; color:#64748B; margin:0; line-height:1.5;">Collection facilities accept both printed passes and digital barcodes displayed on your smartphone screen. Simply show the barcode to the intake technician upon check-in.</p>
            </div>
            <div>
                <h4 style="font-size:14px; font-weight:700; color:#0B2545; margin-bottom:4px;">What if I made a mistake in my registration?</h4>
                <p style="font-size:13px; color:#64748B; margin:0; line-height:1.5;">Call our national scheduling department at <a href="tel:18002214291" style="color:#C1121F; font-weight:700;">(800) 221-4291</a> immediately. Our coordinators can update donor information, change testing panels, or reassign facilities.</p>
            </div>
        </div>
    </div>

</div>
@endsection
