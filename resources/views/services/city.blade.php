@extends('layouts.main')

@section('content')
<!-- Dynamic Breadcrumbs -->
<div class="breadcrumbs-bar">
    <div class="container breadcrumbs-inner">
        @foreach($breadcrumbs as $idx => $bc)
            @if(!$loop->last)
                <a href="{{ $bc['url'] }}">{{ $bc['name'] }}</a>
                <span class="breadcrumbs-sep">/</span>
            @else
                <span class="breadcrumbs-current">{{ $bc['name'] }}</span>
            @endif
        @endforeach
    </div>
</div>

<!-- Option 2 Split Hero Section -->
<section class="hero-split" aria-label="Hero Section">
    <div class="container hero-split-grid">
        <!-- Hero Left -->
        <div class="hero-split-left">
            <div class="hero-tagline-badge" style="background:#F0F5FA; border:1px solid #CBD5E1; color:#0B2545;">
                <span style="color:#C1121F;">★</span>
                SAMHSA Certified &bull; Same-Day Walk-Ins in {{ $city->name }}
                <span style="color:#C1121F;">★</span>
            </div>

            <h1>
                {{ $chain['name'] }} in <span class="highlight-red">{{ $city->name }}, {{ $state->abbr }}</span>
            </h1>

            <p>
                {{ $chain['description'] }} Walk into verified Quest Diagnostics &amp; Labcorp partner collection facilities today in {{ $city->name }}. Instant electronic donor pass sent to your phone and email in 2 minutes. No doctor referral or appointment required.
            </p>

            <ul class="hero-split-checklist">
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ $locations->count() }} Collection Centers in Radius
                </li>
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Quest &amp; Labcorp Partner Facilities
                </li>
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Licensed Physician MRO Verification
                </li>
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Legally Defensible CCF Documentation
                </li>
            </ul>

            <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
                <a href="#locations-list" class="btn btn-primary btn-lg" style="box-shadow: 0 4px 16px rgba(193, 18, 31, 0.35);">
                    View Nearby Centers &darr;
                </a>
                <a href="{{ route('checkout.index', ['slug' => $product?->slug ?? $chain['product_slug']]) }}" class="btn btn-navy btn-lg">
                    Order Test Online (${{ number_format($price, 2) }})
                </a>
                <a href="tel:18009854339" class="top-phone-link" style="font-size:15px; margin-left:6px;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z"/></svg>
                    (800) 985-4339
                </a>
            </div>
        </div>

        <!-- Hero Right: Direct Order Pass Card -->
        <div class="hero-split-right">
            <div class="service-order-summary-card">
                <div class="service-order-summary-header">
                    <div class="service-order-badge-row">
                        <span class="service-order-spec-pill">{{ $chain['specimen'] }} Testing</span>
                        <span class="service-order-verified-pill">
                            <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            MRO Verified
                        </span>
                    </div>
                    <h3 class="service-order-title">{{ $chain['name'] }} Pass</h3>
                    <p class="service-order-subtitle">Valid at all verified {{ $city->name }} partner collection sites</p>
                </div>

                <div class="service-order-price-row">
                    <div class="service-order-price-val">${{ number_format($price, 2) }}</div>
                    <div class="service-order-price-note">
                        All-Inclusive Price<br>
                        <span style="color:#64748B; font-weight:500;">Includes Lab Analysis &amp; Physician MRO</span>
                    </div>
                </div>

                <ul class="service-order-meta-list">
                    <li class="service-order-meta-item">
                        <span>Specimen Method:</span>
                        <strong>{{ $chain['specimen'] }} Screen</strong>
                    </li>
                    <li class="service-order-meta-item">
                        <span>Turnaround Time:</span>
                        <strong>{{ $chain['turnaround'] }}</strong>
                    </li>
                    <li class="service-order-meta-item">
                        <span>Collection Site Radius:</span>
                        <strong>Within 35 Miles of {{ $city->name }}</strong>
                    </li>
                    <li class="service-order-meta-item">
                        <span>Doctor's Prescription:</span>
                        <strong style="color:#15803D;">Not Required (Included)</strong>
                    </li>
                </ul>

                <a href="{{ route('checkout.index', ['slug' => $product?->slug ?? $chain['product_slug']]) }}" class="btn btn-primary btn-lg" style="width:100%; text-align:center; box-shadow:0 4px 14px rgba(193, 18, 31, 0.35);">
                    Order Pass &amp; Walk In Today &rarr;
                </a>

                <div style="font-size:11.5px; color:#64748B; text-align:center; margin-top:10px;">
                    🔒 Electronic barcode pass sent immediately via Email &amp; SMS
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4-Item Feature Strip Below Hero -->
<section class="service-trust-strip" aria-label="Testing Standards">
    <div class="container">
        <div class="service-trust-grid">
            <div class="service-trust-item">
                <div class="service-trust-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <div class="service-trust-title">SAMHSA-Certified Labs</div>
                    <div class="service-trust-sub">Quest &amp; Labcorp Network</div>
                </div>
            </div>

            <div class="service-trust-item">
                <div class="service-trust-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <div class="service-trust-title">Licensed Physician MRO</div>
                    <div class="service-trust-sub">Certified Result Verification</div>
                </div>
            </div>

            <div class="service-trust-item">
                <div class="service-trust-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <div class="service-trust-title">Same-Day Walk-Ins</div>
                    <div class="service-trust-sub">Electronic Donor Pass in 2 Min</div>
                </div>
            </div>

            <div class="service-trust-item">
                <div class="service-trust-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <div class="service-trust-title">Legally Defensible</div>
                    <div class="service-trust-sub">Court, Probation &amp; Workplace CCF</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Grid Layout (2 Col / 1 Col) -->
<div class="container" id="locations-list" style="padding: 40px 20px 60px;">
    <div class="pseo-city-grid">
        <!-- Main Column (Left) -->
        <div>
            <!-- Nearest Collection Facilities Section -->
            <div style="margin-bottom: 30px;">
                <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; margin-bottom:20px;">
                    <div>
                        <h2 style="font-family:var(--font-heading); font-size:22px; font-weight:800; color:#0B2545; margin:0 0 4px 0;">
                            Nearest Collection Centers in {{ $city->name }}, {{ $state->abbr }}
                        </h2>
                        <p style="font-size:13.5px; color:#64748B; margin:0;">
                            Showing verified collection partner facilities within 35 miles of {{ $city->name }}:
                        </p>
                    </div>
                    <span style="display:inline-flex; align-items:center; gap:6px; background:#EFF6FF; color:#1D4ED8; border:1px solid #BFDBFE; padding:5px 12px; border-radius:9999px; font-size:12.5px; font-weight:700;">
                        <span style="width:8px; height:8px; border-radius:50%; background:#2563EB;"></span>
                        {{ $locations->count() }} Centers Available
                    </span>
                </div>

                <div>
                    @foreach($locations as $location)
                        <div class="pseo-location-card">
                            <div class="pseo-card-header">
                                <div>
                                    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap;">
                                        <h3 class="pseo-location-name">{{ $location->name }}</h3>
                                        <span style="background:#EFF6FF; color:#1D4ED8; font-size:11.5px; font-weight:700; padding:2px 8px; border-radius:9999px; border:1px solid #BFDBFE;">
                                            {{ ucfirst($location->provider ?: 'Quest / Labcorp') }} Partner
                                        </span>
                                    </div>
                                    <div class="pseo-distance-badge" style="margin-top:4px;">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        {{ $location->distance_label }}
                                    </div>
                                </div>

                                <div>
                                    <a href="{{ route('checkout.index', ['slug' => $product?->slug ?? $chain['product_slug']]) }}" class="btn btn-navy" style="font-size:12.5px; padding:8px 14px;">
                                        Select Center &rarr;
                                    </a>
                                </div>
                            </div>

                            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap:16px; padding-top:14px;">
                                <div>
                                    <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#0B2545; margin-bottom:4px; display:flex; align-items:center; gap:6px;">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        Facility Address
                                    </div>
                                    <p style="font-size:13.5px; color:#1E293B; margin:0 0 2px 0; font-weight:600;">{{ $location->address1 }}</p>
                                    <p style="font-size:13px; color:#64748B; margin:0 0 8px 0;">{{ $location->city }}, {{ $location->state }} {{ $location->zip }}</p>

                                    <!-- Navigation Links -->
                                    <div style="display:flex; align-items:center; gap:10px; font-size:12px; font-weight:600;">
                                        @php
                                            $destQuery = urlencode("{$location->address1}, {$location->city}, {$location->state} {$location->zip}");
                                            if (!empty($location->lat) && !empty($location->lng)) {
                                                $destQuery = "{$location->lat},{$location->lng}";
                                            }
                                        @endphp
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $destQuery }}" target="_blank" rel="noopener" style="color:#0B2545; text-decoration:underline;">Google Maps</a>
                                        <span style="color:#CBD5E1;">&bull;</span>
                                        <a href="https://maps.apple.com/?daddr={{ $destQuery }}" target="_blank" rel="noopener" style="color:#0B2545; text-decoration:underline;">Apple Maps</a>
                                        <span style="color:#CBD5E1;">&bull;</span>
                                        <a href="https://waze.com/ul?ll={{ $destQuery }}&navigate=yes" target="_blank" rel="noopener" style="color:#0B2545; text-decoration:underline;">Waze</a>
                                    </div>
                                </div>

                                <div>
                                    <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#0B2545; margin-bottom:4px; display:flex; align-items:center; gap:6px;">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Operating Hours &amp; Walk-In
                                    </div>
                                    <div style="font-size:12px; color:#475569; line-height:1.4;">
                                        @foreach($location->formatted_hours_lines as $hLine)
                                            <div>{{ $hLine }}</div>
                                        @endforeach
                                    </div>
                                    <div style="margin-top:8px; display:inline-flex; align-items:center; gap:5px; font-size:11.5px; font-weight:700; color:#15803D; background:#F0FDF4; border:1px solid #BBF7D0; padding:3px 8px; border-radius:4px;">
                                        ✓ Walk-Ins Welcome Today
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Unique Local Editorial / Municipal Testing Overview -->
            @if(!empty($uniqueLocalText))
                <div class="pseo-section-card">
                    <div style="display:flex; align-items:center; gap:10px; padding-bottom:12px; border-bottom:1px solid #F1F5F9; margin-bottom:16px;">
                        <div style="width:34px; height:34px; border-radius:8px; background:#EFF6FF; color:#1D4ED8; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h2 style="margin:0; font-size:18px;">Local Drug Testing Overview for {{ $city->name }}, {{ $state->abbr }}</h2>
                            <p style="margin:0; font-size:12px; color:#64748B;">Verified municipal standards, screening protocols, and local testing guidelines.</p>
                        </div>
                    </div>

                    <div style="font-size:13.5px; color:#334155; line-height:1.65;">
                        {!! $uniqueLocalText !!}
                    </div>
                </div>
            @endif

            <!-- 3-Step Walk-In Guide -->
            <div class="pseo-section-card">
                <div style="padding-bottom:12px; border-bottom:1px solid #F1F5F9; margin-bottom:18px;">
                    <h2 style="margin:0; font-size:18px;">How to Take Your {{ $chain['name'] }} in {{ $city->name }}</h2>
                    <p style="margin:0; font-size:12px; color:#64748B;">Follow these 3 quick steps for same-day walk-in testing:</p>
                </div>

                <div class="process-grid-4-wrap" style="grid-template-columns: repeat(3, 1fr) !important; margin-top:0 !important;">
                    <div class="process-card-step">
                        <div class="process-step-num">01.</div>
                        <h3>Order Pass Online</h3>
                        <p>Purchase your test online or over the phone to automatically register your electronic chain of custody form (eCCF).</p>
                    </div>
                    <div class="process-card-step">
                        <div class="process-step-num">02.</div>
                        <h3>Walk In With Barcode</h3>
                        <p>Walk into any verified {{ $city->name }} partner facility with your digital donor pass barcode and photo ID.</p>
                    </div>
                    <div class="process-card-step">
                        <div class="process-step-num">03.</div>
                        <h3>Fast MRO Results</h3>
                        <p>Specimens are analyzed at SAMHSA-certified labs. Certified MRO results are securely delivered in 24–48 hours.</p>
                    </div>
                </div>
            </div>

            <!-- Substances Screened -->
            <div class="pseo-section-card">
                <h2 style="margin:0 0 6px 0; font-size:18px;">Substances Screened in {{ $chain['name'] }}</h2>
                <p style="margin:0 0 16px 0; font-size:13px; color:#64748B;">
                    Federal SAMHSA and CLIA regulatory cutoff levels:
                </p>

                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap:10px;">
                    @foreach($chain['substances'] as $substance)
                        <div style="display:flex; align-items:center; gap:8px; background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:10px 14px; font-size:13px; font-weight:700; color:#0B2545;">
                            <span style="width:8px; height:8px; border-radius:50%; background:#C1121F; flex-shrink:0;"></span>
                            <span>{{ $substance }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- State Legal & Compliance Overview -->
            <div class="pseo-section-card">
                <div style="display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; padding-bottom:12px; border-bottom:1px solid #F1F5F9; margin-bottom:16px;">
                    <h2 style="margin:0; font-size:18px;">{{ $state->name }} Drug Testing Laws &amp; Statutory Compliance</h2>
                    @if($state->statute_code)
                        <span style="background:#F1F5F9; color:#0B2545; font-family:monospace; font-size:11.5px; font-weight:700; padding:3px 8px; border-radius:4px; border:1px solid #CBD5E1;">
                            {{ $state->statute_code }}
                        </span>
                    @endif
                </div>

                <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:12px; margin-bottom:16px;">
                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:12px 14px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; color:#64748B;">Medical Marijuana</div>
                        <div style="font-weight:800; color:#0B2545; margin-top:2px;">{{ $state->medical_marijuana_status ?: 'Regulated by State' }}</div>
                    </div>
                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:12px 14px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; color:#64748B;">Recreational Cannabis</div>
                        <div style="font-weight:800; color:#0B2545; margin-top:2px;">{{ $state->recreational_marijuana_status ?: 'State Statutes Apply' }}</div>
                    </div>
                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:12px 14px;">
                        <div style="font-size:11px; font-weight:700; text-transform:uppercase; color:#64748B;">Confirmation Testing</div>
                        <div style="font-weight:800; color:#0B2545; margin-top:2px;">Mandatory GC/MS or LC/MS</div>
                    </div>
                </div>

                @if($state->employer_rights_summary)
                    <div style="font-size:13px; color:#475569; line-height:1.55;">
                        <strong style="color:#0B2545;">Employer Rights:</strong> {{ $state->employer_rights_summary }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Column (Right) -->
        <div>
            <!-- Fast Booking Summary Card -->
            <div class="pseo-booking-card">
                <span class="service-order-spec-pill" style="margin-bottom:8px; display:inline-block;">Immediate Booking</span>
                <h3 style="font-family:var(--font-heading); font-size:20px; font-weight:800; color:#0B2545; margin:0 0 6px 0;">{{ $chain['name'] }}</h3>

                <div class="service-order-price-row" style="margin-bottom:14px;">
                    <div class="service-order-price-val">${{ number_format($price, 2) }}</div>
                    <div class="service-order-price-note">All-Inclusive Price<br><span style="color:#64748B; font-weight:500;">Includes Lab Fee &amp; MRO</span></div>
                </div>

                <ul class="service-order-meta-list" style="margin-bottom:16px;">
                    <li class="service-order-meta-item">
                        <span>Doctor's Order:</span>
                        <strong style="color:#15803D;">✓ Included (No Rx)</strong>
                    </li>
                    <li class="service-order-meta-item">
                        <span>Barcode Pass Validity:</span>
                        <strong>21 Days</strong>
                    </li>
                    <li class="service-order-meta-item">
                        <span>Partner Labs:</span>
                        <strong>All {{ $city->name }} Sites</strong>
                    </li>
                    <li class="service-order-meta-item">
                        <span>Result Turnaround:</span>
                        <strong>{{ $chain['turnaround'] }}</strong>
                    </li>
                </ul>

                <a href="{{ route('checkout.index', ['slug' => $product?->slug ?? $chain['product_slug']]) }}" class="btn btn-primary btn-lg" style="width:100%; text-align:center; box-shadow:0 4px 14px rgba(193, 18, 31, 0.35); margin-bottom:10px;">
                    Order Online &amp; Walk In &rarr;
                </a>

                <a href="tel:18009854339" class="btn btn-navy" style="width:100%; text-align:center; font-size:13px; padding:10px;">
                    Call (800) 985-4339
                </a>
            </div>

            <!-- Cross-Service City Switcher -->
            <div class="pseo-section-card" style="margin-top:24px;">
                <h3 style="font-family:var(--font-heading); font-size:16px; font-weight:800; color:#0B2545; margin:0 0 8px 0;">
                    Other Testing Panels in {{ $city->name }}
                </h3>
                <p style="font-size:12.5px; color:#64748B; margin:0 0 14px 0;">
                    All panels can be completed at the same local {{ $city->name }} partner collection facilities:
                </p>

                <div style="display:flex; flex-direction:column; gap:8px;">
                    @foreach($otherServices as $other)
                        <a href="{{ $other['url'] }}" style="display:flex; align-items:center; justify-content:space-between; padding:10px 12px; border-radius:8px; border:1px solid #E2E8F0; text-decoration:none; font-size:12.5px; font-weight:700; color:#0B2545; transition:all 0.2s ease;">
                            <span>{{ $other['name'] }}</span>
                            <span style="color:#C1121F;">&rarr;</span>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Accreditations -->
            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:14px; padding:18px; text-align:center; font-size:12px; color:#64748B;">
                <div style="font-weight:800; color:#0B2545; margin-bottom:8px; text-transform:uppercase; font-size:11px; letter-spacing:0.5px;">Accredited Laboratories</div>
                <div style="display:flex; align-items:center; justify-content:center; gap:8px; flex-wrap:wrap; font-weight:700; color:#0B2545; margin-bottom:10px;">
                    <span style="background:#fff; border:1px solid #CBD5E1; padding:3px 8px; border-radius:4px;">SAMHSA Certified</span>
                    <span style="background:#fff; border:1px solid #CBD5E1; padding:3px 8px; border-radius:4px;">CAP Accredited</span>
                    <span style="background:#fff; border:1px solid #CBD5E1; padding:3px 8px; border-radius:4px;">CLIA Licensed</span>
                </div>
                <p style="margin:0; font-size:11px; color:#94A3B8;">
                    All specimens analyzed under strict chain of custody and verified by an independent Medical Review Officer (MRO).
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Structured Data: JSON-LD -->
<script type="application/ld+json">
{!! json_encode($schemaBreadcrumbs, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>

<script type="application/ld+json">
{!! json_encode($schemaMedicalBusiness, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection
