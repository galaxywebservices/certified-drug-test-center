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
                {{ $state->name }} ({{ $state->abbr }}) Directory &bull; {{ number_format($eligibleCities->count()) }} Municipalities
                <span style="color:#C1121F;">★</span>
            </div>

            <h1>
                {{ $chain['name'] }} in <span class="highlight-red">{{ $state->name }}</span>
            </h1>

            <p>
                {{ $chain['description'] }} Find certified walk-in testing facilities across {{ $state->name }} with Quest Diagnostics &amp; Labcorp partner collection sites. Same-day electronic donor pass, strict chain of custody, and official physician MRO results delivered in {{ $chain['turnaround'] }}.
            </p>

            <ul class="hero-split-checklist">
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ $eligibleCities->count() }}+ Verified Cities in {{ $state->abbr }}
                </li>
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Quest &amp; Labcorp Partner Sites
                </li>
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Physician MRO Verification
                </li>
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ $state->statute_code ?: 'State Regulated & Compliant' }}
                </li>
            </ul>

            <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
                <a href="#cities-list" class="btn btn-primary btn-lg" style="box-shadow: 0 4px 16px rgba(193, 18, 31, 0.35);">
                    Browse {{ $state->name }} Cities &darr;
                </a>
                <a href="{{ route('checkout.index', ['slug' => $chain['product_slug']]) }}" class="btn btn-navy btn-lg">
                    Order Test Online (${{ number_format($chain['default_price'], 2) }})
                </a>
                <a href="tel:18009854339" class="top-phone-link" style="font-size:15px; margin-left:6px;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z"/></svg>
                    (800) 985-4339
                </a>
            </div>
        </div>

        <!-- Hero Right: Order Summary Card -->
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
                    <h3 class="service-order-title">{{ $chain['name'] }} in {{ $state->name }}</h3>
                    <p class="service-order-subtitle">Valid at all verified Quest &amp; Labcorp partner collection sites across {{ $state->name }}</p>
                </div>

                <div class="service-order-price-row">
                    <div class="service-order-price-val">${{ number_format($chain['default_price'], 2) }}</div>
                    <div class="service-order-price-note">
                        All-Inclusive Price<br>
                        <span style="color:#64748B; font-weight:500;">No Hidden State or Lab Fees</span>
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
                        <span>Collection Sites:</span>
                        <strong>Quest Diagnostics &amp; Labcorp</strong>
                    </li>
                    <li class="service-order-meta-item">
                        <span>Doctor's Order:</span>
                        <strong style="color:#15803D;">Not Required (Included)</strong>
                    </li>
                </ul>

                <a href="{{ route('checkout.index', ['slug' => $chain['product_slug']]) }}" class="btn btn-primary btn-lg" style="width:100%; text-align:center; box-shadow:0 4px 14px rgba(193, 18, 31, 0.35);">
                    Order Test Online Now &rarr;
                </a>

                <div style="font-size:11.5px; color:#64748B; text-align:center; margin-top:10px;">
                    🔒 256-Bit Encrypted &bull; Donor Pass issued immediately via Email &amp; SMS
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
                    <div class="service-trust-title">Quest &amp; Labcorp Network</div>
                    <div class="service-trust-sub">SAMHSA-Certified Laboratories</div>
                </div>
            </div>

            <div class="service-trust-item">
                <div class="service-trust-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
                <div>
                    <div class="service-trust-title">MRO Physician Verification</div>
                    <div class="service-trust-sub">Legally Defensible Results</div>
                </div>
            </div>

            <div class="service-trust-item">
                <div class="service-trust-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <div class="service-trust-title">Immediate Walk-Ins</div>
                    <div class="service-trust-sub">Electronic Donor Pass via Email/SMS</div>
                </div>
            </div>

            <div class="service-trust-item">
                <div class="service-trust-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <div class="service-trust-title">{{ $state->name }} Statutory Compliance</div>
                    <div class="service-trust-sub">{{ $state->statute_code ?: 'State Regulated' }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Content Body: Cities Selection Grid -->
<section class="section section-light" id="cities-list" aria-labelledby="citiesDirectoryTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">{{ strtoupper($state->name) }} MUNICIPAL COVERAGE</span>
            <h2 class="section-title" id="citiesDirectoryTitle">Active {{ $chain['name'] }} Locations in {{ $state->name }}</h2>
            <p class="section-desc">
                Select your city to view verified collection facilities within 35 miles, operating hours, turn-by-turn directions, and online registration:
            </p>
        </div>

        <div style="background:#FEF2F2; border:1px solid #FECACA; border-radius:10px; padding:14px 20px; margin-bottom:24px; text-align:center; color:#991B1B; font-size:13.5px; font-weight:600;">
            <span style="color:#16A34A; font-weight:800;">✓ Walk-Ins Accepted Today</span> &bull; <strong style="color:#C1121F;">Pre-Registration Required:</strong> All testing requires an electronic donor pass issued prior to arrival at the collection center.
        </div>

        <!-- Filter Search Bar -->
        <div class="state-search-bar" style="margin-bottom: 24px; position:relative;">
            <div style="position:relative;">
                <svg style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94A3B8;" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="citySearchInput" class="zip-input" placeholder="Type city name to filter (e.g. {{ $eligibleCities->first()?->name ?? 'Miami' }})..." style="padding-left:46px; width:100%; background:#fff;">
            </div>
        </div>

        <div class="states-grid-enhanced" id="citiesGrid">
            @foreach($eligibleCities as $eligibleCity)
                <a href="{{ rtrim(url('/services/' . $chain['slug'] . '/' . $state->slug . '/' . $eligibleCity->slug), '/') . '/' }}" class="state-card-v2" data-city="{{ strtolower($eligibleCity->name) }}">
                    <div class="state-card-v2-left">
                        <div class="state-abbr-badge">{{ $state->abbr }}</div>
                        <div class="state-card-v2-info">
                            <span class="state-card-v2-name">{{ $eligibleCity->name }}</span>
                            <span class="state-card-v2-cities">{{ $eligibleCity->active_centers_count ?? '1+' }} Centers</span>
                        </div>
                    </div>
                    <span class="state-card-v2-arrow">&rarr;</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- State Legal & Compliance Overview -->
<section class="section section-white" aria-labelledby="complianceTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">STATUTORY FRAMEWORK</span>
            <h2 class="section-title" id="complianceTitle">{{ $state->name }} Drug Testing Regulations &amp; Compliance</h2>
            <p class="section-desc">
                Summary of statutory drug-testing standards, workers' compensation discounts, and laboratory verification guidelines:
            </p>
        </div>

        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 24px;">
            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:12px; padding:20px;">
                <div style="font-size:11.5px; font-weight:800; text-transform:uppercase; color:#64748B; margin-bottom:6px;">Statutory Code</div>
                <div style="font-family:var(--font-heading); font-size:18px; font-weight:800; color:#0B2545;">{{ $state->statute_code ?: 'State Common Law' }}</div>
            </div>

            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:12px; padding:20px;">
                <div style="font-size:11.5px; font-weight:800; text-transform:uppercase; color:#64748B; margin-bottom:6px;">Medical Marijuana</div>
                <div style="font-family:var(--font-heading); font-size:18px; font-weight:800; color:#0B2545;">{{ $state->medical_marijuana_status ?: 'State Statutes Apply' }}</div>
            </div>

            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:12px; padding:20px;">
                <div style="font-size:11.5px; font-weight:800; text-transform:uppercase; color:#64748B; margin-bottom:6px;">Workers' Comp Discounts</div>
                <div style="font-family:var(--font-heading); font-size:18px; font-weight:800; color:#0B2545;">{{ $state->worker_comp_rules ? 'State Program Available' : 'Standard Policies' }}</div>
            </div>
        </div>

        @if($state->employer_rights_summary)
            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-left:4px solid #0B2545; border-radius:8px; padding:20px; font-size:14px; color:#475569; line-height:1.6;">
                <h3 style="font-family:var(--font-heading); font-size:15px; font-weight:800; color:#0B2545; margin-bottom:6px;">Employer Rights &amp; Drug-Free Workplace Policies</h3>
                <p style="margin:0;">{{ $state->employer_rights_summary }}</p>
            </div>
        @endif
    </div>
</section>

<!-- Live City Filter Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('citySearchInput');
    const citiesGrid = document.getElementById('citiesGrid');
    if (!searchInput || !citiesGrid) return;

    searchInput.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();
        const cards = citiesGrid.querySelectorAll('.state-card-v2');
        cards.forEach(function (card) {
            const cityName = (card.getAttribute('data-city') || '').toLowerCase();
            if (cityName.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>

<!-- Structured Data -->
<script type="application/ld+json">
{!! json_encode($schemaBreadcrumbs, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
@endsection
