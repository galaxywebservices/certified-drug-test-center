@extends('layouts.main')

@section('content')
<style>
    .state-hero-bar {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        padding: 40px 0;
        border-bottom: 3px solid #C1121F;
    }

    .state-layout-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 36px;
        padding: 40px 0 60px;
    }

    @media (max-width: 992px) {
        .state-layout-grid { grid-template-columns: 1fr; }
    }

    .cities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 10px;
        margin: 16px 0 32px;
    }

    .city-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        padding: 10px 14px;
        text-decoration: none;
        color: #0B2545;
        font-weight: 600;
        font-size: 13px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.15s ease;
    }
    .city-card:hover {
        border-color: #0B2545;
        color: #C1121F;
        background: #F8FAFC;
    }

    .compliance-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 28px;
        margin-bottom: 30px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    .law-badges-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin: 16px 0;
    }

    .law-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
    }
    .law-badge-green { background: #DCFCE7; color: #15803D; }
    .law-badge-amber { background: #FEF3C7; color: #B45309; }
    .law-badge-blue { background: #E0F2FE; color: #0369A1; }

    .faq-accordion-item {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        margin-bottom: 12px;
        overflow: hidden;
    }
    .faq-accordion-item summary {
        padding: 16px 20px;
        font-weight: 700;
        color: #0B2545;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        list-style: none;
        font-size: 15px;
    }
    .faq-accordion-item summary::-webkit-details-marker { display: none; }
    .faq-accordion-item summary::after {
        content: '+';
        font-size: 18px;
        font-weight: 800;
        color: #C1121F;
    }
    .faq-accordion-item[open] summary::after {
        content: '−';
    }
    .faq-accordion-body {
        padding: 0 20px 18px;
        font-size: 14px;
        color: #334155;
        line-height: 1.7;
        border-top: 1px solid #F1F5F9;
        margin-top: 4px;
        padding-top: 14px;
    }

    .lab-cards-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 20px;
        margin: 16px 0 32px;
    }
    .lab-site-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 2px 8px rgba(11, 37, 69, 0.04);
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        position: relative;
    }
    .lab-site-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(11, 37, 69, 0.09);
        border-color: #CBD5E1;
    }
    .lab-site-card-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 8px;
        margin-bottom: 12px;
    }
    .partner-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 6px;
    }
    .partner-badge-labcorp {
        background: #EFF6FF;
        color: #0369A1;
        border: 1px solid #BFDBFE;
    }
    .partner-badge-quest {
        background: #F0FDF4;
        color: #15803D;
        border: 1px solid #BBF7D0;
    }
    .badge-walkin {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 700;
        color: #15803D;
        background: #DCFCE7;
        padding: 3px 9px;
        border-radius: 999px;
    }
    .badge-walkin-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #16A34A;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.2);
    }
    .lab-card-title {
        font-size: 17px;
        font-weight: 800;
        color: #0B2545;
        line-height: 1.35;
        margin: 0 0 8px;
    }
    .lab-card-title a {
        color: #0B2545;
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .lab-card-title a:hover {
        color: #C1121F;
    }
    .lab-card-address {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        font-size: 13px;
        color: #475569;
        line-height: 1.5;
        margin-bottom: 12px;
    }
    .lab-card-address svg {
        flex-shrink: 0;
        margin-top: 2px;
        color: #64748B;
    }
    .lab-card-hours-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 10px 12px;
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin-bottom: 16px;
        min-height: 54px;
        box-sizing: border-box;
    }
    .lab-card-hours-box svg {
        flex-shrink: 0;
        margin-top: 2px;
        color: #0284C7;
    }
    .hours-line {
        font-size: 12px;
        font-weight: 600;
        color: #1E293B;
        line-height: 1.45;
    }
    .hours-line + .hours-line {
        margin-top: 2px;
        color: #475569;
    }
    .lab-card-actions {
        display: flex;
        gap: 8px;
        margin-top: auto;
        padding-top: 14px;
        border-top: 1px solid #F1F5F9;
    }
    .btn-card-schedule {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: #C1121F;
        color: #FFFFFF !important;
        font-weight: 700;
        font-size: 13px;
        padding: 10px 14px;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        box-shadow: 0 2px 6px rgba(193, 18, 31, 0.25);
    }
    .btn-card-schedule:hover {
        background: #9B0E19;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(193, 18, 31, 0.35);
    }
    .btn-card-details {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #FFFFFF;
        color: #0B2545 !important;
        border: 1.5px solid #CBD5E1;
        font-weight: 700;
        font-size: 12.5px;
        padding: 10px 14px;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.15s ease;
        white-space: nowrap;
    }
    .btn-card-details:hover {
        background: #0B2545;
        border-color: #0B2545;
        color: #FFFFFF !important;
    }

    /* Popular Tests Sidebar */
    .popular-tests-card {
        background: #FFFFFF;
        border: 2px solid #0B2545;
        border-radius: 12px;
        padding: 24px;
        position: sticky;
        top: 24px;
        box-shadow: 0 4px 16px rgba(11, 37, 69, 0.06);
    }
    .popular-tests-title {
        font-size: 18px;
        font-weight: 800;
        color: #0B2545;
        margin: 0 0 16px;
        padding-bottom: 10px;
        border-bottom: 2px solid #F1F5F9;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .popular-tests-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .popular-test-item {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 12px 14px;
        transition: all 0.2s ease;
    }
    .popular-test-item:hover {
        background: #FFFFFF;
        border-color: #CBD5E1;
        box-shadow: 0 4px 12px rgba(11, 37, 69, 0.05);
    }
    .popular-test-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 4px;
    }
    .popular-test-name {
        font-size: 14px;
        font-weight: 800;
        color: #0B2545;
        text-decoration: none;
        line-height: 1.35;
        transition: color 0.15s ease;
    }
    .popular-test-name:hover {
        color: #C1121F;
    }
    .popular-test-price {
        font-size: 15px;
        font-weight: 900;
        color: #C1121F;
        white-space: nowrap;
    }
    .popular-test-meta {
        font-size: 12px;
        color: #64748B;
        margin-bottom: 10px;
    }
    .sidebar-order-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        background: #0B2545;
        color: #FFFFFF !important;
        font-size: 13px;
        font-weight: 800;
        padding: 9px 14px;
        border-radius: 6px;
        text-decoration: none;
        border: 1px solid #0B2545;
        transition: all 0.15s ease;
        box-shadow: 0 2px 4px rgba(11, 37, 69, 0.12);
        cursor: pointer;
    }
    .sidebar-order-btn:hover {
        background: #C1121F;
        border-color: #C1121F;
        color: #FFFFFF !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(193, 18, 31, 0.3);
    }
    .sidebar-order-btn .arrow {
        transition: transform 0.2s ease;
    }
    .sidebar-order-btn:hover .arrow {
        transform: translateX(3px);
    }

    @media (max-width: 640px) {
        .lab-cards-list {
            grid-template-columns: 1fr;
        }
        .lab-card-actions {
            flex-direction: column;
        }
        .btn-card-details {
            width: 100%;
        }
    }
</style>

<div class="state-hero-bar">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Breadcrumb" style="display:flex; gap:8px; font-size:13px; color:#94A3B8; margin-bottom:12px;">
            <a href="{{ url('/') }}" style="color:#CBD5E1; text-decoration:none;">Home</a>
            <span>&rsaquo;</span>
            <a href="{{ url('/locations') }}" style="color:#CBD5E1; text-decoration:none;">Locations</a>
            <span>&rsaquo;</span>
            <span style="color:#fff;">{{ $state->name }}</span>
        </nav>

        <h1 style="font-size:32px; font-weight:800; color:#fff; margin-bottom:8px;">
            {{ $state->name }} Drug Testing Centers &amp; Workplace Compliance
        </h1>
        <p style="font-size:16px; color:#E2E8F0; max-width:800px;">
            Certified Quest Diagnostics and Labcorp collection facilities throughout {{ $state->name }}. Instant electronic donor pass, SAMHSA lab verification, and Medical Review Officer (MRO) certified reporting.
        </p>
    </div>
</div>

<div class="container">
    <div class="state-layout-grid">
        <!-- Main Left Column -->
        <div>
            @if($state->statute_code || $state->employer_rights_summary)
            <!-- State Compliance & Workplace Laws Module -->
            <div class="compliance-card">
                <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:10px;">
                    <h2 style="font-size:20px; font-weight:800; color:#0B2545; margin:0;">
                        {{ $state->name }} Workplace Drug Testing Laws &amp; Regulations
                    </h2>
                    @if($state->statute_code)
                    <span class="badge" style="background:#0B2545; color:#fff; font-size:11px; padding:4px 8px;">
                        Statute: {{ $state->statute_code }}
                    </span>
                    @endif
                </div>

                <div class="law-badges-row">
                    @if($state->medical_marijuana_status)
                    <div class="law-badge {{ str_contains(strtolower($state->medical_marijuana_status), 'legal') ? 'law-badge-green' : 'law-badge-amber' }}">
                        <span>Medical Cannabis:</span>
                        <strong>{{ $state->medical_marijuana_status }}</strong>
                    </div>
                    @endif

                    @if($state->recreational_marijuana_status)
                    <div class="law-badge {{ str_contains(strtolower($state->recreational_marijuana_status), 'legal') ? 'law-badge-green' : 'law-badge-blue' }}">
                        <span>Recreational Cannabis:</span>
                        <strong>{{ $state->recreational_marijuana_status }}</strong>
                    </div>
                    @endif

                    <div class="law-badge law-badge-blue">
                        <span>DOT Compliance:</span>
                        <strong>Strict Zero-Tolerance</strong>
                    </div>
                </div>

                @if($state->employer_rights_summary)
                <div style="font-size:14px; line-height:1.7; color:#334155; margin-top:14px;">
                    <strong style="color:#0B2545; display:block; margin-bottom:4px;">Employer Rights &amp; Policy Standards:</strong>
                    {{ $state->employer_rights_summary }}
                </div>
                @endif

                @if($state->worker_comp_rules)
                <div style="font-size:13px; line-height:1.6; color:#475569; margin-top:12px; padding:12px 16px; background:#F8FAFC; border-radius:6px; border-left:3px solid #0B2545;">
                    <strong style="color:#0B2545;">Workers' Compensation Incentives:</strong>
                    {{ $state->worker_comp_rules }}
                </div>
                @endif
            </div>
            @endif

            <!-- Major Cities in this State -->
            <div style="margin-bottom:36px;">
                <h2 style="font-size:22px; font-weight:800; color:#0B2545; margin-bottom:6px;">
                    Major Cities in {{ $state->name }}
                </h2>
                <p style="font-size:14px; color:#64748B; margin-bottom:14px;">
                    Select your city to view local Quest Diagnostics and Labcorp certified collection sites:
                </p>

                <div class="cities-grid">
                    @forelse($cities as $city)
                    <a href="{{ url('/locations/' . $state->slug . '/' . $city->slug) }}" class="city-card">
                        <span>{{ $city->name }}</span>
                        <span style="color:#94A3B8; font-size:12px;">&rarr;</span>
                    </a>
                    @empty
                    <div style="grid-column:1 / -1; color:#64748B; padding:20px; background:#fff; border-radius:6px;">
                        Certified collection sites available across {{ $state->name }}. Enter your zip code at checkout to find your nearest facility.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Accredited Testing Locations in State -->
            @if($sampleLocations->count())
            <div style="margin-bottom:36px;">
                <h2 style="font-size:22px; font-weight:800; color:#0B2545; margin-bottom:6px;">
                    Certified Collection Centers in {{ $state->name }}
                </h2>
                <div class="lab-cards-list">
                    @foreach($sampleLocations as $loc)
                    @php
                        $isLabcorp = stripos($loc->provider, 'labcorp') !== false || stripos($loc->name, 'labcorp') !== false;
                        $partnerClass = $isLabcorp ? 'partner-badge-labcorp' : 'partner-badge-quest';
                        $partnerLabel = $isLabcorp ? 'Labcorp Partner' : 'Quest Partner';
                    @endphp
                    <div class="lab-site-card">
                        <div>
                            <div class="lab-site-card-top">
                                <span class="partner-badge {{ $partnerClass }}">
                                    {{ $partnerLabel }}
                                </span>
                                <span class="badge-walkin">
                                    <span class="badge-walkin-dot"></span>Walk-Ins Welcome
                                </span>
                            </div>

                            <h3 class="lab-card-title">
                                <a href="{{ route('locations.show', $loc->id) }}">
                                    {{ $loc->name }}
                                </a>
                            </h3>

                            <div class="lab-card-address">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <div>
                                    <div>{{ $loc->address1 }}{{ $loc->address2 ? ' ' . $loc->address2 : '' }}</div>
                                    <div style="color:#64748B;">{{ $loc->city }}, {{ $loc->state }} {{ $loc->zip }}</div>
                                </div>
                            </div>

                            <div class="lab-card-hours-box">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                <div class="hours-text">
                                    @foreach($loc->formatted_hours_lines as $hLine)
                                    <div class="hours-line">{{ $hLine }}</div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="lab-card-actions">
                            <a href="{{ route('checkout.index', ['location_id' => $loc->id]) }}" class="btn-card-schedule">
                                Schedule Test &rarr;
                            </a>
                            <a href="{{ route('locations.show', $loc->id) }}" class="btn-card-details">
                                View Details
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- State Legal FAQs Accordion -->
            @if(!empty($state->faqs_json) && is_array($state->faqs_json))
            <div style="margin-bottom:36px;">
                <h2 style="font-size:22px; font-weight:800; color:#0B2545; margin-bottom:14px;">
                    Frequently Asked Questions About {{ $state->name }} Drug Testing
                </h2>

                <div class="faq-accordion-group">
                    @foreach($state->faqs_json as $faq)
                    <details class="faq-accordion-item" {{ $loop->first ? 'open' : '' }}>
                        <summary>{{ $faq['question'] }}</summary>
                        <div class="faq-accordion-body">
                            {{ $faq['answer'] }}
                        </div>
                    </details>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Side: Popular Tests & Instant Phone Scheduling -->
        <div>
            <div class="popular-tests-card">
                <h3 class="popular-tests-title">
                    <span>Popular Tests in {{ $state->name }}</span>
                </h3>

                <div class="popular-tests-list">
                    @foreach($popularTests as $t)
                    <div class="popular-test-item">
                        <div class="popular-test-header">
                            <a href="{{ url('/product/' . $t->slug) }}" class="popular-test-name">
                                {{ $t->name }}
                            </a>
                            <span class="popular-test-price">${{ number_format($t->price, 2) }}</span>
                        </div>
                        <div class="popular-test-meta">
                            <span>⚡ {{ $t->turnaround_time }}</span>
                        </div>
                        <a href="{{ route('checkout.index', $t->slug) }}" class="sidebar-order-btn">
                            <span>Order This Test</span>
                            <span class="arrow">&rarr;</span>
                        </a>
                    </div>
                    @endforeach
                </div>

                <div style="margin-top:20px; background:#0B2545; color:#fff; border-radius:8px; padding:18px; text-align:center;">
                    <div style="font-size:11px; text-transform:uppercase; color:#94A3B8; font-weight:700;">Need Employer Compliance Setup?</div>
                    <div style="font-size:15px; font-weight:800; margin:4px 0 10px;">Nationwide Account Scheduling</div>
                    <a href="tel:18009854339" style="display:inline-block; background:#C1121F; color:#fff; padding:8px 16px; border-radius:4px; font-weight:700; text-decoration:none; font-size:14px;">
                        Call (800)-985-4339
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!empty($state->faqs_json) && is_array($state->faqs_json))
@php
$faqPageSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(function($f) {
        return [
            '@type' => 'Question',
            'name' => $f['question'],
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => $f['answer'],
            ],
        ];
    }, $state->faqs_json),
];
@endphp
<script type="application/ld+json">
{!! json_encode($faqPageSchema, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
@endif
@endsection
