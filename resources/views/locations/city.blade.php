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
                    {{ $loc->name }}
                </h3>

                <div style="font-size:14px; color:#334155; line-height:1.6; margin-bottom:16px;">
                    <strong>Address:</strong> {{ $loc->address1 }} {{ $loc->address2 }}<br>
                    <strong>City/State:</strong> {{ $loc->city }}, {{ $loc->state }} {{ $loc->zip }}<br>
                    <strong>Operating Hours:</strong> {{ $loc->hours ?: 'Monday - Friday 8:00 AM - 5:00 PM' }}
                </div>

                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-sm">
                        Schedule Test at This Center &rarr;
                    </a>
                    <a href="https://maps.google.com/?q={{ urlencode($loc->address1 . ', ' . $loc->city . ', ' . $loc->state . ' ' . $loc->zip) }}" target="_blank" class="btn btn-outline btn-sm">
                        📍 Get Driving Directions
                    </a>
                </div>
            </div>
            @empty
            <div style="background:#fff; border:1px solid #E2E8F0; border-radius:10px; padding:30px; text-align:center;">
                <p style="color:#64748B;">Certified collection sites are available in {{ $cityName }} and surrounding zip codes.</p>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary" style="margin-top:12px;">Order Test Online</a>
            </div>
            @endforelse

            <!-- Easy 3-Step Walkthrough -->
            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:28px; margin-top:30px;">
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
                    <a href="tel:18002214291" style="display:inline-block; background:#C1121F; color:#fff; padding:8px 16px; border-radius:4px; font-weight:700; text-decoration:none; font-size:14px;">
                        Call (800) 221-4291
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
