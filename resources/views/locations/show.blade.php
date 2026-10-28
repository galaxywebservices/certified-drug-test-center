@extends('layouts.main')

@section('content')
<style>
    /* ==========================================================================
       Dedicated Facility Profile: Option 2 Corporate Clean & Precision
       ========================================================================== */
    .facility-hero-bar {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        padding: 38px 0;
        border-bottom: 3px solid #C1121F;
    }

    .facility-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        font-size: 13px;
        color: #94A3B8;
        margin-bottom: 16px;
    }
    .facility-breadcrumb a {
        color: #E2E8F0;
        text-decoration: none;
        transition: color 0.15s;
    }
    .facility-breadcrumb a:hover {
        color: #fff;
        text-decoration: underline;
    }
    .facility-breadcrumb .separator {
        color: #64748B;
    }
    .facility-breadcrumb .current {
        color: #CBD5E1;
        font-weight: 600;
    }

    .facility-hero-grid {
        display: grid;
        grid-template-columns: 2fr 1.1fr;
        gap: 32px;
        align-items: center;
    }
    @media (max-width: 992px) {
        .facility-hero-grid { grid-template-columns: 1fr; gap: 24px; }
    }

    .facility-title {
        font-family: var(--font-heading, 'Montserrat', sans-serif);
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -0.5px;
        color: #FFFFFF;
        margin: 0 0 10px;
        line-height: 1.25;
    }
    @media (max-width: 768px) {
        .facility-title { font-size: 24px; }
    }

    .facility-badge-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 14px;
    }

    .provider-tag {
        background: {{ strtolower($location->provider) === 'labcorp' ? '#0284C7' : '#047857' }};
        color: #fff;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 700;
        background: {{ $parsedHours['is_open_today'] ? 'rgba(34, 197, 94, 0.18)' : 'rgba(239, 68, 68, 0.18)' }};
        color: {{ $parsedHours['is_open_today'] ? '#4ADE80' : '#FCA5A5' }};
        border: 1px solid {{ $parsedHours['is_open_today'] ? 'rgba(34, 197, 94, 0.4)' : 'rgba(239, 68, 68, 0.4)' }};
    }
    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: {{ $parsedHours['is_open_today'] ? '#22C55E' : '#EF4444' }};
        box-shadow: 0 0 8px {{ $parsedHours['is_open_today'] ? '#22C55E' : '#EF4444' }};
    }

    .facility-address-lead {
        font-size: 16px;
        color: #E2E8F0;
        line-height: 1.5;
        margin: 0;
    }

    /* Fast Action Card */
    .fast-action-card {
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.16);
        backdrop-filter: blur(8px);
        border-radius: 12px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .fast-action-card .btn-schedule {
        background: #C1121F;
        color: #fff;
        font-weight: 800;
        font-size: 15px;
        padding: 14px 20px;
        border-radius: 8px;
        text-align: center;
        text-decoration: none;
        box-shadow: 0 4px 14px rgba(193, 18, 31, 0.4);
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .fast-action-card .btn-schedule:hover {
        background: #9B0E19;
        transform: translateY(-1px);
    }
    .fast-action-card .directions-btn-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }
    .fast-action-card .btn-subaction {
        background: rgba(255,255,255,0.12);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        padding: 10px;
        border-radius: 6px;
        text-align: center;
        text-decoration: none;
        border: 1px solid rgba(255,255,255,0.2);
        transition: background 0.15s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .fast-action-card .btn-subaction:hover {
        background: rgba(255,255,255,0.2);
    }

    /* Main Body Layout */
    .facility-body-layout {
        display: grid;
        grid-template-columns: 1.8fr 1.2fr;
        gap: 36px;
        padding: 40px 0 70px;
        align-items: start;
    }
    @media (max-width: 992px) {
        .facility-body-layout { grid-template-columns: 1fr; }
    }

    .facility-section-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 28px;
        margin-bottom: 28px;
        box-shadow: 0 2px 10px rgba(11, 37, 69, 0.04);
    }

    .section-card-title {
        font-size: 20px;
        font-weight: 800;
        color: #0B2545;
        margin: 0 0 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        border-bottom: 2px solid #F1F5F9;
        padding-bottom: 12px;
    }

    /* Modalities Grid */
    .modalities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 14px;
        margin-top: 14px;
    }
    .modality-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 14px 16px;
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .modality-icon {
        font-size: 22px;
        line-height: 1;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .modality-title {
        font-size: 14px;
        font-weight: 700;
        color: #0B2545;
        margin-bottom: 2px;
    }
    .modality-desc {
        font-size: 12px;
        color: #64748B;
        line-height: 1.4;
    }

    /* Hours Table */
    .hours-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    .hours-table tr {
        border-bottom: 1px solid #F1F5F9;
    }
    .hours-table tr:last-child {
        border-bottom: none;
    }
    .hours-table td {
        padding: 10px 12px;
    }
    .hours-table tr.today-row {
        background: #F0FDF4;
        font-weight: 700;
        color: #166534;
        border-radius: 6px;
    }
    .hours-table tr.today-row td:first-child::after {
        content: " (Today)";
        font-size: 11px;
        font-weight: 800;
        color: #15803D;
        text-transform: uppercase;
        margin-left: 4px;
    }

    /* Amenities List */
    .amenities-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-top: 10px;
    }
    @media (max-width: 600px) {
        .amenities-list { grid-template-columns: 1fr; }
    }
    .amenity-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #334155;
        font-weight: 600;
    }
    .amenity-item svg {
        color: #16A34A;
        flex-shrink: 0;
    }

    /* Quick Test Packages */
    .popular-tests-card-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
        margin-top: 14px;
    }
    .book-test-row {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        transition: all 0.2s;
    }
    .book-test-row:hover {
        border-color: #0B2545;
        box-shadow: 0 4px 12px rgba(11, 37, 69, 0.06);
    }
    .book-test-title {
        font-size: 14px;
        font-weight: 700;
        color: #0B2545;
        margin-bottom: 2px;
    }
    .book-test-meta {
        font-size: 12px;
        color: #64748B;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .book-test-price {
        font-size: 17px;
        font-weight: 800;
        color: #C1121F;
        white-space: nowrap;
    }

    /* GPS Navigation Box */
    .gps-routing-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
    }
    .gps-buttons-row {
        display: flex;
        gap: 10px;
        justify-content: center;
        flex-wrap: wrap;
        margin-top: 14px;
    }
    .btn-nav-app {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #FFFFFF;
        border: 1px solid #CBD5E1;
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 700;
        color: #0B2545;
        text-decoration: none;
        transition: all 0.15s;
    }
    .btn-nav-app:hover {
        background: #0B2545;
        color: #fff;
        border-color: #0B2545;
    }

    /* Nearby locations sidebar list */
    .nearby-facility-item {
        padding: 14px 0;
        border-bottom: 1px solid #F1F5F9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
    }
    .nearby-facility-item:last-child {
        border-bottom: none;
    }
</style>

<!-- Facility Header / Trust Banner -->
<div class="facility-hero-bar">
    <div class="container">
        <!-- Breadcrumbs -->
        <nav class="facility-breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="separator">&rsaquo;</span>
            <a href="{{ route('locations.index') }}">Testing Centers</a>
            @if($state)
                <span class="separator">&rsaquo;</span>
                <a href="{{ route('locations.state', $state->slug) }}">{{ $state->name }}</a>
            @endif
            @if($state && $city)
                <span class="separator">&rsaquo;</span>
                <a href="{{ route('locations.city', ['state_slug' => $state->slug, 'city_slug' => $city->slug]) }}">{{ $city->name }}</a>
            @endif
            <span class="separator">&rsaquo;</span>
            <span class="current">{{ $location->name }}</span>
        </nav>

        <div class="facility-hero-grid">
            <div>
                <div class="facility-badge-row">
                    <span class="provider-tag">
                        🛡️ {{ $providerName }} Certified Collection Site
                    </span>
                    <span class="status-pill">
                        <span class="status-dot"></span>
                        {{ $parsedHours['today_status'] }}
                    </span>
                    <span style="font-size:12px; color:#CBD5E1; font-weight:600;">
                        ● Walk-Ins Accepted Daily
                    </span>
                </div>

                <h1 class="facility-title">
                    {{ $location->name }}
                </h1>

                <p class="facility-address-lead">
                    📍 <strong>{{ $location->address1 }} {{ $location->address2 }}</strong>, {{ $location->city }}, {{ $location->state }} {{ $location->zip }}
                </p>
                <div style="font-size:13px; color:#94A3B8; margin-top:8px;">
                    Facility Phone: <a href="tel:{{ preg_replace('/[^0-9]/', '', $location->phone ?: '8002214291') }}" style="color:#CBD5E1; text-decoration:underline;">{{ $location->phone ?: '(800) 221-4291' }}</a> &nbsp;|&nbsp; National Dispatch: <a href="tel:8002214291" style="color:#CBD5E1; text-decoration:underline;">(800) 221-4291</a>
                </div>
            </div>

            <!-- Top Right Fast Action Box -->
            <div class="fast-action-card">
                <a href="{{ route('checkout.index', ['location_id' => $location->id]) }}" class="btn-schedule">
                    <span>Order Test &amp; Walk-In Here &rarr;</span>
                </a>
                <div class="directions-btn-group">
                    <a href="{{ $googleMapsUrl }}" target="_blank" rel="noopener" class="btn-subaction">
                        🗺️ Google Maps
                    </a>
                    <a href="{{ $appleMapsUrl }}" target="_blank" rel="noopener" class="btn-subaction">
                        🧭 Apple Maps
                    </a>
                </div>
                <div style="text-align:center; font-size:11px; color:#CBD5E1;">
                    ⚡ Immediate Electronic Donor Pass issued via email upon registration.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Body Details -->
<div class="container">
    <div class="facility-body-layout">
        <!-- Left Column: Specs, Operating Hours, Modalities, Procedure -->
        <div>
            <!-- Section 1: Overview & Walk-in Instructions -->
            <div class="facility-section-card">
                <h2 class="section-card-title">
                    <span>🏢</span> Testing Center Overview &amp; Walk-In Rules
                </h2>
                <p style="font-size:15px; color:#334155; line-height:1.7; margin-bottom:18px;">
                    This official <strong>{{ $providerName }} collection facility</strong> is fully accredited under <strong>CLIA</strong> and <strong>SAMHSA</strong> regulatory standards. Testing services are confidential, court-admissible, and supported by a licensed Medical Review Officer (MRO).
                </p>

                <div style="background:#F0FDF4; border:1px solid #BBF7D0; border-radius:8px; padding:16px; margin-bottom:20px;">
                    <div style="font-size:14px; font-weight:800; color:#166534; margin-bottom:4px;">
                        ✓ Walk-In Testing Instructions (No Appointment Necessary)
                    </div>
                    <p style="font-size:13px; color:#14532D; line-height:1.6; margin:0;">
                        1. Register online in 2 minutes to obtain your official CDTC Electronic Donor Pass with barcode.<br>
                        2. Bring a valid government photo ID (Driver's License, Passport, or State ID).<br>
                        3. Walk into this center during donor collection hours. Present your barcode pass at check-in. Testing takes 10–15 minutes.
                    </p>
                </div>

                <div class="amenities-list">
                    <div class="amenity-item">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Electronic CCF &amp; Barcode Check-In</span>
                    </div>
                    <div class="amenity-item">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>DOT Certified Specimen Collector</span>
                    </div>
                    <div class="amenity-item">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>ADA Wheelchair Accessible</span>
                    </div>
                    <div class="amenity-item">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Free Dedicated Parking On-Site</span>
                    </div>
                    <div class="amenity-item">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>CLIA &amp; CAP Certified Reference Lab</span>
                    </div>
                    <div class="amenity-item">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>MRO Medical Doctor Result Review</span>
                    </div>
                </div>
            </div>

            <!-- Section 2: Accepted Testing Modalities -->
            <div class="facility-section-card">
                <h2 class="section-card-title">
                    <span>🧪</span> Accepted Testing Modalities &amp; Specimen Types
                </h2>
                <p style="font-size:14px; color:#475569; margin-bottom:14px;">
                    This facility is equipped to collect the following biological specimens under strict Chain of Custody procedures:
                </p>

                <div class="modalities-grid">
                    <div class="modality-box">
                        <span class="modality-icon">💧</span>
                        <div>
                            <div class="modality-title">Urine Drug Screening</div>
                            <div class="modality-desc">Standard 5 to 14-panel tests, rapid instant cups, and DOT federal panels. Detection window: 1–4 days.</div>
                        </div>
                    </div>

                    <div class="modality-box">
                        <span class="modality-icon">💇</span>
                        <div>
                            <div class="modality-title">Hair Follicle Testing</div>
                            <div class="modality-desc">90-day historical window. Ingestion analysis impervious to detox shampoos and temporary abstention.</div>
                        </div>
                    </div>

                    <div class="modality-box">
                        <span class="modality-icon">🌬️</span>
                        <div>
                            <div class="modality-title">Breath Alcohol Testing</div>
                            <div class="modality-desc">NHTSA and DOT approved evidential breath testers (EBT) with immediate printed confirmation.</div>
                        </div>
                    </div>

                    <div class="modality-box">
                        <span class="modality-icon">🧪</span>
                        <div>
                            <div class="modality-title">EtG Alcohol Testing</div>
                            <div class="modality-desc">Extended 80-hour urine or 90-day hair metabolite screening for probation, custody, and zero-tolerance.</div>
                        </div>
                    </div>

                    <div class="modality-box">
                        <span class="modality-icon">📋</span>
                        <div>
                            <div class="modality-title">DOT Compliance Tests</div>
                            <div class="modality-desc">Full 49 CFR Part 40 compliant collections for FMCSA, FAA, FRA, FTA, PHMSA, and USCG maritime.</div>
                        </div>
                    </div>

                    <div class="modality-box">
                        <span class="modality-icon">⚖️</span>
                        <div>
                            <div class="modality-title">Court &amp; Legal Testing</div>
                            <div class="modality-desc">Observed and monitored collections with admissible legal documentation for family court and probation.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section 3: Available Tests to Book for this Facility -->
            <div class="facility-section-card">
                <h2 class="section-card-title">
                    <span>💳</span> Order a Test for This Location
                </h2>
                <p style="font-size:14px; color:#475569; margin-bottom:16px;">
                    Select any test package below. Your Electronic Donor Pass will be configured specifically for <strong>{{ $location->name }}</strong>.
                </p>

                <div class="popular-tests-card-grid">
                    @foreach($popularTests as $p)
                    <div class="book-test-row">
                        <div>
                            <div class="book-test-title">{{ $p->name }}</div>
                            <div class="book-test-meta">
                                <span class="badge" style="background:#E0F2FE; color:#0369A1; font-size:11px;">{{ ucfirst($p->specimen_type) }} Specimen</span>
                                <span>● {{ $p->turnaround_time }}</span>
                                @if($p->dot_required)
                                    <span class="badge" style="background:#FEF3C7; color:#92400E; font-size:11px;">DOT Approved</span>
                                @endif
                            </div>
                        </div>
                        <div style="display:flex; align-items:center; gap:14px;">
                            <div class="book-test-price">${{ number_format($p->price, 2) }}</div>
                            <a href="{{ route('checkout.index', ['product_id' => $p->id, 'location_id' => $location->id]) }}" class="btn btn-primary btn-sm" style="white-space:nowrap;">
                                Select Test &rarr;
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div style="text-align:center; margin-top:20px;">
                    <a href="{{ route('checkout.index', ['location_id' => $location->id]) }}" class="btn btn-outline">
                        View All 123+ Testing Panels for This Location &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Column: Operating Hours, GPS Navigation, Nearby Alternative Centers -->
        <div>
            <!-- Operating Hours Card -->
            <div class="facility-section-card">
                <h2 class="section-card-title" style="font-size:18px;">
                    <span>🕒</span> Weekly Operating Hours
                </h2>

                <div style="margin-bottom:14px; font-size:13px; color:#64748B;">
                    Walk-in specimens accepted during standard collection hours.
                </div>

                <table class="hours-table">
                    <tbody>
                        @foreach($parsedHours['days'] as $h)
                        <tr class="{{ $h['is_today'] ? 'today-row' : '' }}">
                            <td style="font-weight:{{ $h['is_today'] ? '800' : '600' }};">
                                {{ $h['day'] }}
                            </td>
                            <td style="text-align:right; color:{{ $h['is_closed'] ? '#94A3B8' : '#0B2545' }};">
                                {{ $h['hours'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top:16px; padding-top:14px; border-top:1px solid #F1F5F9; font-size:12px; color:#64748B; line-height:1.5;">
                    💡 <strong>Tip:</strong> We recommend arriving at least 30 minutes prior to closing time to complete specimen collection.
                </div>
            </div>

            <!-- Turn-by-Turn GPS Directions Card -->
            <div class="facility-section-card">
                <h2 class="section-card-title" style="font-size:18px;">
                    <span>🧭</span> Turn-by-Turn GPS Directions
                </h2>

                <div class="gps-routing-box">
                    <div style="font-size:14px; font-weight:700; color:#0B2545;">
                        {{ $location->address1 }} {{ $location->address2 }}
                    </div>
                    <div style="font-size:13px; color:#64748B; margin-top:2px;">
                        {{ $location->city }}, {{ $location->state }} {{ $location->zip }}
                    </div>

                    <div class="gps-buttons-row">
                        <a href="{{ $googleMapsUrl }}" target="_blank" rel="noopener" class="btn-nav-app">
                            <span>🗺️</span> Google Maps
                        </a>
                        <a href="{{ $appleMapsUrl }}" target="_blank" rel="noopener" class="btn-nav-app">
                            <span>🍎</span> Apple Maps
                        </a>
                        <a href="{{ $wazeUrl }}" target="_blank" rel="noopener" class="btn-nav-app">
                            <span>🚗</span> Waze
                        </a>
                    </div>

                    <button type="button" onclick="copyAddressText()" id="copyAddressBtn" style="margin-top:12px; background:transparent; border:none; color:#0B2545; font-size:12px; font-weight:700; cursor:pointer; text-decoration:underline;">
                        📋 Copy Full Address to Clipboard
                    </button>
                </div>
            </div>

            <!-- Alternative Nearby Facilities in Same Region -->
            @if($nearbyLocations->isNotEmpty())
            <div class="facility-section-card">
                <h2 class="section-card-title" style="font-size:18px;">
                    <span>📍</span> Nearby Alternative Facilities
                </h2>

                <div>
                    @foreach($nearbyLocations as $near)
                    <div class="nearby-facility-item">
                        <div>
                            <strong style="font-size:13px; color:#0B2545; display:block;">{{ $near->name }}</strong>
                            <div style="font-size:12px; color:#64748B;">
                                {{ $near->address1 }}, {{ $near->city }}, {{ $near->state }} {{ $near->zip }}
                            </div>
                            <span class="badge" style="background:#F1F5F9; color:#475569; font-size:10px; margin-top:4px;">
                                {{ ucfirst($near->provider) }} Site
                            </span>
                        </div>
                        <a href="{{ route('locations.show', $near->id) }}" class="btn btn-outline btn-sm" style="font-size:11px; white-space:nowrap;">
                            View Center &rarr;
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Customer Support Help Box -->
            <div style="background:#0B2545; color:#fff; border-radius:10px; padding:22px; text-align:center;">
                <h3 style="font-size:16px; font-weight:800; color:#fff; margin:0 0 8px;">
                    Need Help Selecting a Test?
                </h3>
                <p style="font-size:13px; color:#CBD5E1; line-height:1.5; margin:0 0 14px;">
                    Our certified toxicologists and corporate testing advisors are available to assist you.
                </p>
                <a href="tel:8002214291" style="display:inline-block; background:#C1121F; color:#fff; font-weight:800; padding:10px 18px; border-radius:6px; text-decoration:none; font-size:14px;">
                    📞 Call National Dispatch: (800) 221-4291
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function copyAddressText() {
    const text = "{{ addslashes($location->address1 . ', ' . $location->city . ', ' . $location->state . ' ' . $location->zip) }}";
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(function() {
            const btn = document.getElementById('copyAddressBtn');
            btn.innerText = "✓ Address Copied!";
            setTimeout(() => { btn.innerText = "📋 Copy Full Address to Clipboard"; }, 2500);
        });
    }
}
</script>

<!-- Structured JSON-LD Schema: MedicalBusiness / DiagnosticLab -->
<script type="application/ld+json">
{
    "@@context": "https://schema.org",
    "@type": "MedicalBusiness",
    "name": "{{ $location->name }} - Certified Drug Test Center",
    "image": "{{ asset('img/cdtc-logo-option2.svg') }}",
    "url": "{{ route('locations.show', $location->id) }}",
    "telephone": "{{ $location->phone ?: '(800) 221-4291' }}",
    "priceRange": "$$",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ $location->address1 }} {{ $location->address2 }}",
        "addressLocality": "{{ $location->city }}",
        "addressRegion": "{{ $location->state }}",
        "postalCode": "{{ $location->zip }}",
        "addressCountry": "US"
    },
    @if(!empty($location->lat) && !empty($location->lng))
    "geo": {
        "@type": "GeoCoordinates",
        "latitude": {{ $location->lat }},
        "longitude": {{ $location->lng }}
    },
    @endif
    "medicalSpecialty": "Toxicology",
    "isAcceptingNewPatients": true,
    "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Drug and Alcohol Testing Services",
        "itemListElement": [
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "MedicalTest",
                    "name": "5-Panel Urine Drug Test"
                }
            },
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "MedicalTest",
                    "name": "10-Panel Urine Drug Test"
                }
            },
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "MedicalTest",
                    "name": "DOT Federal Drug Screening"
                }
            },
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "MedicalTest",
                    "name": "Hair Follicle Drug Test (90-Day)"
                }
            }
        ]
    }
}
</script>
@endsection
