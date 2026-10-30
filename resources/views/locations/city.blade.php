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
        font-size: 18px;
        font-weight: 900;
        color: #C1121F;
        background: #FEE2E2;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
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
</style>

<div class="city-hero-bar">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Breadcrumb" style="display:flex; gap:8px; font-size:13px; color:#94A3B8; margin-bottom:12px;">
            <a href="{{ url('/') }}" style="color:#CBD5E1; text-decoration:none;">Home</a>
            <span>&rsaquo;</span>
            <a href="{{ url('/locations') }}" style="color:#CBD5E1; text-decoration:none;">Locations</a>
            <span>&rsaquo;</span>
            <a href="{{ url('/locations/' . $state->slug) }}" style="color:#CBD5E1; text-decoration:none;">{{ $state->name }}</a>
            <span>&rsaquo;</span>
            <span style="color:#fff;">{{ $cityName }}</span>
        </nav>

        <h1 style="font-size:32px; font-weight:800; color:#fff; margin-bottom:8px;">
            {{ $cityName }}, {{ $state->abbr }} Drug Testing Centers &amp; Walk-In Labs
        </h1>
        <p style="font-size:16px; color:#E2E8F0; max-width:800px;">
            Fast, confidential same-day drug and alcohol testing in {{ $cityName }}, {{ $state->abbr }}. Electronic donor pass delivered immediately. Walk in today at Quest Diagnostics and Labcorp certified collection facilities.
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
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:10px;">
                    <span class="badge" style="background:#E0F2FE; color:#0369A1; text-transform:uppercase; font-size:11px;">
                        {{ $loc->provider ?: 'Quest / Labcorp' }} Collection Facility
                    </span>
                    <span style="color:#16A34A; font-weight:700; font-size:12px;">Walk-Ins Accepted Today</span>
                </div>

                <h3 style="font-size:18px; font-weight:800; color:#0B2545; margin-bottom:6px;">
                    <a href="{{ route('locations.show', $loc->id) }}" style="color:#0B2545; text-decoration:none;">
                        {{ $loc->name }}
                    </a>
                </h3>

                <div style="font-size:14px; color:#334155; line-height:1.6; margin-bottom:16px;">
                    <strong>Address:</strong> {{ $loc->address1 }} {{ $loc->address2 }}<br>
                    <strong>City/State:</strong> {{ $loc->city }}, {{ $loc->state }} {{ $loc->zip }}<br>
                    <strong>Operating Hours:</strong> {{ $loc->hours ?: 'Monday - Friday 8:00 AM - 5:00 PM' }}
                </div>

                <div style="display:flex; gap:10px; flex-wrap:wrap;">
                    <a href="{{ route('checkout.index', ['location_id' => $loc->id]) }}" class="btn btn-primary btn-sm">
                        Schedule Test at This Center &rarr;
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

            @if(!empty($city?->content))
            <!-- Localized City Guide Content Formatted Professionally -->
            <div class="city-guide-container">
                <div class="city-guide-top-header">
                    <div>
                        <h3 class="city-guide-main-title">Local Testing Guide for {{ $cityName }}, {{ $state->abbr }}</h3>
                        <small style="color:#64748B; font-size:13px;">Official testing protocols, legal standards, and collection center guidelines</small>
                    </div>
                    <span class="city-guide-trust-pill">
                        🛡️ CLIA &amp; SAMHSA Certified Network
                    </span>
                </div>

                <div class="city-content-body">
                    {!! \App\Services\CityGuideFormatter::format($city->content, $cityName, $state->abbr) !!}
                </div>
            </div>
            @else
            <!-- Standard 3-Step Walkthrough for locations without custom content -->
            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:28px; margin-top:24px;">
                <h3 style="font-size:18px; font-weight:800; color:#0B2545; margin-bottom:14px;">
                    How Walk-In Drug Testing Works in {{ $cityName }}
                </h3>
                <div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px; font-size:13px; color:#334155; line-height:1.6;">
                    <div>
                        <strong style="color:#C1121F; display:block; margin-bottom:4px;">1. Order Online (2 Mins)</strong>
                        Choose your test and register online. Testing centers do not take payment on-site.
                    </div>
                    <div>
                        <strong style="color:#C1121F; display:block; margin-bottom:4px;">2. Get Electronic Pass</strong>
                        Receive your electronic Donor Registration Pass via email with barcode and directions.
                    </div>
                    <div>
                        <strong style="color:#C1121F; display:block; margin-bottom:4px;">3. Walk-In &amp; Test</strong>
                        Walk in during collection hours with your pass and a photo ID. No appointment necessary!
                    </div>
                </div>
            </div>
            @endif
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
</div>

@if($locations->isNotEmpty())
@php
$itemListSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'ItemList',
    'name' => "{$cityName}, {$state->abbr} Certified Drug Testing Centers",
    'itemListElement' => $locations->values()->map(function($loc, $index) {
        return [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'item' => [
                '@type' => 'MedicalBusiness',
                'name' => $loc->name,
                'medicalSpecialty' => 'SubstanceAbuseScreening',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $loc->address1,
                    'addressLocality' => $loc->city,
                    'addressRegion' => $loc->state,
                    'postalCode' => $loc->zip,
                    'addressCountry' => 'US',
                ],
                'telephone' => '+1-800-985-4339',
                'openingHours' => 'Mo-Fr 08:00-17:00',
                'url' => url()->current(),
            ],
        ];
    })->all(),
];
@endphp
<script type="application/ld+json">
{!! json_encode($itemListSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
@endif
@endsection
