@extends('layouts.main')

@section('content')
<style>
    .city-hero-bar {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        padding: 40px 0;
        border-bottom: 3px solid #C1121F;
    }

    .city-layout-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 36px;
        align-items: start;
        padding: 40px 0 60px;
    }

    @media (max-width: 992px) {
        .city-layout-grid { grid-template-columns: 1fr; }
    }

    .lab-location-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 24px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    /* -------------------------------------------------------------
       City Guide Modern Formatting & Typography System
       ------------------------------------------------------------- */
    .city-guide-container {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 32px 30px;
        margin-top: 28px;
        box-shadow: 0 2px 12px rgba(11, 37, 69, 0.03);
    }

    .city-guide-top-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        padding-bottom: 18px;
        border-bottom: 2px solid #F1F5F9;
        margin-bottom: 24px;
    }

    .city-guide-main-title {
        font-size: 21px;
        font-weight: 800;
        color: #0B2545;
        margin: 0;
        letter-spacing: -0.3px;
    }

    .city-guide-trust-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #F0F5FA;
        color: #0B2545;
        border: 1px solid #D0E1F2;
        padding: 5px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 700;
    }

    /* 3-Step Process Card Grid */
    .guide-steps-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin: 20px 0 28px;
    }
    @media (max-width: 768px) {
        .guide-steps-grid { grid-template-columns: 1fr; }
    }

    .guide-step-card {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 20px 18px;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .guide-step-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(0,0,0,0.04);
        border-color: #CBD5E1;
    }

    .guide-step-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .guide-step-num {
        font-size: 13px;
        font-weight: 800;
        color: #C1121F;
        background: #FEE2E2;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        letter-spacing: 0.3px;
    }

    .guide-step-badge {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: #E0F2FE;
        color: #0369A1;
        padding: 3px 8px;
        border-radius: 4px;
    }

    .guide-step-title {
        font-size: 15px;
        font-weight: 700;
        color: #0B2545;
        margin: 0 0 8px;
    }

    .guide-step-text {
        font-size: 13px;
        color: #475569;
        line-height: 1.6;
        margin: 0;
    }

    /* Section Headers */
    .guide-section-header {
        margin-top: 32px;
        margin-bottom: 14px;
        padding-bottom: 10px;
        border-bottom: 1px solid #F1F5F9;
    }

    .guide-section-pill {
        display: inline-block;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 3px 10px;
        border-radius: 4px;
        background: #E0F2FE;
        color: #0369A1;
        margin-bottom: 6px;
    }
    .guide-pill-navy { background: #0B2545; color: #fff; }
    .guide-pill-blue { background: #E0F2FE; color: #0284C7; }
    .guide-pill-green { background: #DCFCE7; color: #15803D; }

    .guide-section-title {
        font-size: 18px;
        font-weight: 800;
        color: #0B2545;
        margin: 4px 0 0;
        letter-spacing: -0.2px;
    }

    .guide-subheading {
        font-size: 16px;
        font-weight: 700;
        color: #0B2545;
        margin: 26px 0 10px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .guide-subheading::before {
        content: '';
        display: inline-block;
        width: 4px;
        height: 16px;
        background: #C1121F;
        border-radius: 2px;
    }

    /* Feature Checkmark Lists */
    .guide-feature-list-wrap {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 18px 24px;
        margin: 16px 0 24px;
    }

    .guide-feature-list {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px 20px;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    @media (max-width: 640px) {
        .guide-feature-list { grid-template-columns: 1fr; }
    }

    .guide-feature-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        font-size: 13.5px;
        color: #334155;
        line-height: 1.5;
    }

    .guide-check-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #DCFCE7;
        color: #16A34A;
        font-size: 12px;
        font-weight: 900;
        flex-shrink: 0;
        margin-top: 1px;
    }

    /* Callout Cards */
    .guide-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 22px 24px;
        margin: 26px 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }

    .guide-card-legal {
        border-left: 4px solid #C1121F;
        background: #FFFBFB;
    }

    .guide-badge-legal {
        display: inline-block;
        background: #FEE2E2;
        color: #991B1B;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    .guide-card-mobile {
        border-left: 4px solid #0B2545;
        background: #F0F5FA;
    }

    .guide-badge-mobile {
        display: inline-block;
        background: #0B2545;
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    .guide-card-trust {
        border: 2px solid #0B2545;
        background: #F8FAFC;
    }

    .guide-badge-trust {
        display: inline-block;
        background: #0B2545;
        color: #fff;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 4px;
        margin-bottom: 8px;
    }

    .guide-card-title {
        font-size: 17px;
        font-weight: 800;
        color: #0B2545;
        margin: 4px 0 10px;
        letter-spacing: -0.2px;
    }

    .guide-card-body {
        font-size: 14px;
        color: #334155;
        line-height: 1.7;
    }
    .guide-card-body p:last-child {
        margin-bottom: 0;
    }

    .guide-section-body {
        margin-bottom: 16px;
        font-size: 14px;
        color: #334155;
        line-height: 1.7;
    }

    .guide-phone-inline {
        color: #C1121F;
        font-weight: 700;
        text-decoration: none;
        background: #FEE2E2;
        padding: 2px 7px;
        border-radius: 4px;
        display: inline-block;
        white-space: nowrap;
    }
    .guide-phone-inline:hover {
        background: #FCA5A5;
        color: #991B1B;
    }

    .guide-phone-link {
        color: #C1121F;
        font-weight: 700;
        text-decoration: underline;
    }
    .guide-phone-link:hover {
        color: #0B2545;
    }

    .city-content-body p {
        margin-bottom: 14px;
        line-height: 1.7;
        color: #334155;
        font-size: 14px;
    }
    .breadcrumbs {
        flex-wrap: wrap;
    }
    .city-content-body {
        max-width: 100%;
        overflow-wrap: break-word;
        word-break: break-word;
    }
    .city-content-body table {
        display: block;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    .city-content-body img {
        max-width: 100%;
        height: auto;
    }
</style>

<div class="city-hero-bar">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Breadcrumb" style="display:flex; gap:8px; font-size:13px; color:#94A3B8; margin-bottom:12px;">
            <a href="{{ url('/') }}" style="color:#CBD5E1; text-decoration:none;">Home</a>
            <span>&rsaquo;</span>
            <a href="{{ $breadcrumbs[1]['url'] ?? url('/certified-drug-test-centers') }}" style="color:#CBD5E1; text-decoration:none;">{{ $baseTitle ?? 'Locations' }}</a>
            <span>&rsaquo;</span>
            <a href="{{ url(($baseRoutePrefix ?? '/locations') . '/' . $state->slug) }}" style="color:#CBD5E1; text-decoration:none;">{{ $state->name }}</a>
            <span>&rsaquo;</span>
            <span style="color:#fff;">{{ $cityName }}</span>
        </nav>

        <h1 style="font-size:32px; font-weight:800; color:#fff; margin-bottom:8px;">
            {{ $cityName }}, {{ $state->abbr }} Drug Testing Centers
        </h1>
        <p style="font-size:16px; color:#E2E8F0; max-width:800px;">
            Certified Drug Test Centers in {{ $cityName }}, {{ $state->abbr }}. Order online or call (800) 985-4339 for an electronic donor pass. Same-day testing at Quest Diagnostics, Labcorp and affiliated certified collection facilities.
        </p>
    </div>
</div>

<div class="container">
    <div class="city-layout-grid">
        <!-- Left: Collection Sites & Testing Steps -->
        <div>
            <h2 style="font-size:22px; font-weight:800; color:#0B2545; margin-bottom:18px;">
                Certified Collection Centers in &amp; Near {{ $cityName }}
            </h2>

            @forelse($locations as $loc)
            <div class="lab-location-card">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                    <span class="badge" style="background:#E0F2FE; color:#0369A1; text-transform:uppercase; font-size:11px;">
                        {{ $loc->provider ?: 'Quest / Labcorp' }} Collection Facility
                    </span>
                </div>

                <div style="background:#FFFBEB; border:1px solid #FDE68A; border-radius:6px; padding:8px 12px; margin-bottom:12px; font-size:12px; color:#92400E;">
                    <strong style="color:#B45309;">Pre-registration required:</strong> You must receive a registration form/donor pass prior to proceeding to the testing center.
                </div>

                <h3 style="font-size:18px; font-weight:800; color:#0B2545; margin-bottom:6px;">
                    <a href="{{ route('locations.show', $loc->id) }}" style="color:#0B2545; text-decoration:none;">
                        {{ $loc->name }}
                    </a>
                </h3>

                <div style="font-size:14px; color:#334155; line-height:1.6; margin-bottom:16px;">
                    <strong>Address:</strong> {{ $loc->address1 }} {{ $loc->address2 }}<br>
                    <strong>City/State:</strong> {{ $loc->city }}, {{ $loc->state }} {{ $loc->zip }}<br>
                    <strong>Operating Hours:</strong> {{ str_replace('|', ' • ', $loc->hours ?: 'Monday - Friday 8:00 AM - 5:00 PM') }}
                </div>

                <div style="display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                    <a href="{{ route('checkout.index', ['location_id' => $loc->id]) }}" class="btn btn-primary btn-sm">
                        Schedule Test at This Center &rarr;
                    </a>
                    <a href="tel:18009854339" class="btn btn-navy btn-sm" style="background:#0B2545; color:#fff; border-color:#0B2545; display:inline-flex; align-items:center; gap:6px;">
                        📞 Call Now
                    </a>
                    <a href="{{ route('locations.show', $loc->id) }}" class="btn btn-outline btn-sm">
                        Facility Profile &amp; Hours
                    </a>
                    @php
                        $coordDest = (!empty($loc->lat) && !empty($loc->lng)) ? "{$loc->lat},{$loc->lng}" : urlencode("{$loc->address1}, {$loc->city}, {$loc->state} {$loc->zip}");
                    @endphp
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $coordDest }}" target="_blank" rel="noopener" class="btn btn-outline btn-sm" style="color:#64748B;">
                        📍 GPS Directions
                    </a>
                </div>
            </div>
            @empty
            <div style="background:#fff; border:1px solid #E2E8F0; border-radius:10px; padding:30px; text-align:center;">
                <p style="color:#64748B;">Certified collection sites are available in {{ $cityName }} and surrounding zip codes.</p>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="margin-top:12px;">Order Test Online</a>
            </div>
            @endforelse
        </div>

        <!-- Right Side: Available Tests in this city -->
        <div>
            <div style="background:#fff; border:2px solid #0B2545; border-radius:10px; padding:24px; position:sticky; top:24px;">
                <h3 style="font-size:18px; font-weight:800; color:#0B2545; margin-bottom:16px; padding-bottom:8px; border-bottom:2px solid #F1F5F9;">
                    Popular Tests in {{ $cityName }}
                </h3>

                <div style="display:flex; flex-direction:column; gap:14px;">
                    @foreach($popularTests as $t)
                    <div style="padding-bottom:12px; border-bottom:1px solid #F1F5F9;">
                        <a href="{{ url('/product/' . $t->slug) }}" style="font-size:14px; font-weight:700; color:#0B2545; text-decoration:none; display:block; margin-bottom:2px;">
                            {{ $t->name }}
                        </a>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:12px; color:#64748B;">{{ $t->turnaround_time }}</span>
                            <strong style="color:#C1121F;">${{ number_format($t->price, 2) }}</strong>
                        </div>
                        <a href="{{ route('checkout.index', $t->slug) }}" class="btn btn-outline btn-sm" style="width:100%; justify-content:center; margin-top:8px; font-size:12px;">
                            Order This Test &rarr;
                        </a>
                    </div>
                    @endforeach
                </div>

                <div style="margin-top:14px;">
                    <a href="{{ url('/services') }}" class="btn btn-navy btn-sm" style="width:100%; display:block; text-align:center; padding:10px 14px; font-weight:700; border-radius:6px; background:#0B2545; color:#fff; text-decoration:none; box-sizing:border-box;">
                        View All Tests &rarr;
                    </a>
                </div>

                <div style="margin-top:20px; background:#0B2545; color:#fff; border-radius:8px; padding:18px; text-align:center;">
                    <div style="font-size:11px; text-transform:uppercase; color:#94A3B8; font-weight:700;">Need Help Ordering?</div>
                    <div style="font-size:15px; font-weight:800; margin:4px 0 10px;">Phone Scheduling Available</div>
                    <a href="tel:18009854339" style="display:inline-block; background:#C1121F; color:#fff; padding:8px 16px; border-radius:4px; font-weight:700; text-decoration:none; font-size:14px;">
                        Call (800)-985-4339
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Full-Width Local Testing Guide Section -->
    @if(!empty($city?->content))
    <div class="city-guide-container" style="margin-top:10px; margin-bottom:40px;">
        <div class="city-guide-top-header">
            <div>
                <h3 class="city-guide-main-title">Local Testing Guide for {{ $cityName }}, {{ $state->abbr }}</h3>
                <small style="color:#64748B; font-size:13px;">Official testing protocols, legal standards, and collection center guidelines</small>
            </div>
            <span class="city-guide-trust-pill">
                🛡️ CLIA &amp; SAMHSA Certified Network
            </span>
        </div>

        <!-- Dynamic Real Local Clinic Metrics for AEO, GEO & Uniqueness -->
        <div class="city-metrics-bar" style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:18px 20px; margin-bottom:24px; display:grid; grid-template-columns:repeat(auto-fit, minmax(200px, 1fr)); gap:16px;">
            <div>
                <div style="font-size:11px; text-transform:uppercase; color:#64748B; font-weight:800; letter-spacing:0.5px;">Certified Facilities</div>
                <div style="font-size:18px; font-weight:900; color:#0B2545;">{{ $locations->count() }} Collection Sites</div>
                <small style="color:#15803D; font-weight:700;">Quest &amp; Labcorp in {{ $cityName }}</small>
            </div>
            <div>
                <div style="font-size:11px; text-transform:uppercase; color:#64748B; font-weight:800; letter-spacing:0.5px;">Earliest Opening</div>
                <div style="font-size:18px; font-weight:900; color:#0B2545;">{{ $earliestOpen ?? '7:00 AM' }}</div>
                <small style="color:#64748B; font-weight:600;">Same-day pass accepted</small>
            </div>
            <div>
                <div style="font-size:11px; text-transform:uppercase; color:#64748B; font-weight:800; letter-spacing:0.5px;">Schedule Options</div>
                <div style="font-size:18px; font-weight:900; color:#0B2545;">{{ !empty($weekendOr24Count) && $weekendOr24Count > 0 ? "{$weekendOr24Count} Extended/Sat Sites" : "Mon–Fri Business Hours" }}</div>
                <small style="color:#64748B; font-weight:600;">{{ !empty($has24Hrs) ? '1 facility open 24/7' : 'Walk-ins with electronic pass' }}</small>
            </div>
            <div>
                <div style="font-size:11px; text-transform:uppercase; color:#64748B; font-weight:800; letter-spacing:0.5px;">Covered ZIP Codes</div>
                <div style="font-size:12.5px; font-weight:700; color:#0B2545; line-height:1.4; word-break:break-word;">
                    {{ $coveredZipsString ?? '' }}
                </div>
                <small style="color:#64748B; font-weight:600;">{{ $state->name }} Metro Network</small>
            </div>
        </div>

        <div class="city-content-body">
            {!! \App\Services\CityGuideFormatter::format($city->content, $cityName, $state->abbr) !!}
        </div>
    </div>
    @else
    <!-- Standard 3-Step Walkthrough for locations without custom content -->
    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:28px; margin-top:20px; margin-bottom:40px;">
        <h3 style="font-size:18px; font-weight:800; color:#0B2545; margin-bottom:14px;">
            How Drug Testing Works in {{ $cityName }}
        </h3>
        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr)); gap:16px; font-size:13px; color:#334155; line-height:1.6;">
            <div>
                <strong style="color:#C1121F; display:block; margin-bottom:4px;">Step 1: Order Online or Call</strong>
                Choose your test and register online or call (800) 985-4339. Testing centers do not take payment on-site.
            </div>
            <div>
                <strong style="color:#C1121F; display:block; margin-bottom:4px;">Step 2: Receive Donor Pass</strong>
                Receive your electronic Donor Registration Pass immediately via email or text with barcode and facility directions.
            </div>
            <div>
                <strong style="color:#C1121F; display:block; margin-bottom:4px;">Step 3: Complete Testing</strong>
                Visit the certified collection center with your donor pass and photo ID. Negative results are typically available within 24–48 hours.
            </div>
        </div>
    </div>
    @endif

    @if(isset($siblingCities) && $siblingCities->isNotEmpty())
    <!-- Sibling Cities Horizontal Crawl Architecture -->
    <div class="sibling-cities-section" style="margin-top:20px; padding:32px 0 50px; border-top:1px solid #E2E8F0;">
        <div style="display:flex; justify-content:space-between; align-items:baseline; flex-wrap:wrap; gap:12px; margin-bottom:18px;">
            <div>
                <h3 style="font-size:20px; font-weight:800; color:#0B2545; margin:0 0 4px;">
                    Nearby Drug Testing Centers in {{ $state->name }}
                </h3>
                <p style="font-size:13.5px; color:#64748B; margin:0;">
                    Explore same-day certified drug and alcohol testing collection facilities in neighboring {{ $state->name }} communities:
                </p>
            </div>
            <a href="{{ url(($baseRoutePrefix ?? '/locations') . '/' . $state->slug) }}" style="color:#C1121F; font-size:13px; font-weight:700; text-decoration:none;">
                View All {{ $state->name }} Cities &rarr;
            </a>
        </div>

        <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:12px;">
            @foreach($siblingCities as $sibling)
            <a href="{{ url(($baseRoutePrefix ?? '/locations') . '/' . $state->slug . '/' . $sibling->slug) }}" 
               style="background:#fff; border:1px solid #E2E8F0; border-radius:8px; padding:12px 16px; text-decoration:none; color:#0B2545; font-size:13.5px; font-weight:700; display:flex; justify-content:space-between; align-items:center; transition:all 0.15s ease;"
               onmouseover="this.style.borderColor='#0B2545'; this.style.color='#C1121F'; this.style.backgroundColor='#F8FAFC';"
               onmouseout="this.style.borderColor='#E2E8F0'; this.style.color='#0B2545'; this.style.backgroundColor='#fff';">
                <span>{{ $sibling->name }} Drug Testing</span>
                <span style="color:#94A3B8; font-size:13px;">&rarr;</span>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>

@endsection
