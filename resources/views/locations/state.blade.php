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
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 16px;
        margin: 16px 0 32px;
    }
    .lab-site-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 18px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
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
                    <div class="lab-site-card">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:8px;">
                            <span class="badge" style="background:#E0F2FE; color:#0369A1; text-transform:uppercase; font-size:11px;">
                                {{ $loc->provider ?: 'Quest / Labcorp' }} Partner
                            </span>
                            <span style="font-size:12px; color:#16A34A; font-weight:700;">Walk-Ins Welcome</span>
                        </div>
                        <h3 style="font-size:16px; font-weight:700; color:#0B2545; margin-bottom:4px;">
                            <a href="{{ route('locations.show', $loc->id) }}" style="color:#0B2545; text-decoration:none;">
                                {{ $loc->name }}
                            </a>
                        </h3>
                        <div style="font-size:13px; color:#475569; line-height:1.6; margin-bottom:12px;">
                            {{ $loc->address1 }}<br>
                            {{ $loc->city }}, {{ $loc->state }} {{ $loc->zip }}<br>
                            <small style="color:#64748B;">Hours: {{ $loc->hours ?: 'Mon-Fri 8:00 AM - 5:00 PM' }}</small>
                        </div>
                        <div style="display:flex; gap:8px;">
                            <a href="{{ route('checkout.index', ['location_id' => $loc->id]) }}" class="btn btn-primary btn-sm" style="flex:1; justify-content:center;">
                                Schedule Test &rarr;
                            </a>
                            <a href="{{ route('locations.show', $loc->id) }}" class="btn btn-outline btn-sm" style="font-size:12px;">
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
            <div style="background:#fff; border:2px solid #0B2545; border-radius:10px; padding:24px; position:sticky; top:24px;">
                <h3 style="font-size:18px; font-weight:800; color:#0B2545; margin-bottom:16px; padding-bottom:8px; border-bottom:2px solid #F1F5F9;">
                    Popular Tests in {{ $state->name }}
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
