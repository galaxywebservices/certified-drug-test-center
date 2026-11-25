@extends('layouts.main')

@section('content')
<style>
    .loc-hero-bar {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        padding: 44px 0 40px;
        border-bottom: 3px solid #C1121F;
    }

    .loc-breadcrumbs {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #94A3B8;
        margin-bottom: 16px;
    }
    .loc-breadcrumbs a {
        color: #CBD5E1;
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .loc-breadcrumbs a:hover {
        color: #fff;
        text-decoration: underline;
    }
    .loc-breadcrumbs .sep {
        color: #64748B;
    }

    .loc-hero-title {
        font-size: 34px;
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
        margin-bottom: 12px;
        letter-spacing: -0.02em;
    }

    .loc-hero-subtitle {
        font-size: 16px;
        color: #E2E8F0;
        max-width: 820px;
        line-height: 1.6;
        margin-bottom: 24px;
    }

    /* ZIP and State Search in Hero */
    .loc-search-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        align-items: stretch;
        max-width: 860px;
    }

    .loc-zip-form {
        display: flex;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        flex: 1;
        min-width: 280px;
    }
    .loc-zip-input {
        flex: 1;
        border: none;
        padding: 14px 18px;
        font-size: 15px;
        color: #0B2545;
        outline: none;
        min-width: 140px;
    }
    .loc-zip-input::placeholder {
        color: #94A3B8;
    }
    .loc-zip-btn {
        background: #C1121F;
        color: #fff;
        border: none;
        padding: 0 24px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s ease;
        white-space: nowrap;
    }
    .loc-zip-btn:hover {
        background: #9E0D18;
    }

    .loc-filter-box {
        display: flex;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 8px;
        overflow: hidden;
        flex: 1;
        min-width: 240px;
        backdrop-filter: blur(4px);
    }
    .loc-filter-input {
        flex: 1;
        background: transparent;
        border: none;
        padding: 14px 18px;
        font-size: 15px;
        color: #fff;
        outline: none;
    }
    .loc-filter-input::placeholder {
        color: #CBD5E1;
    }

    /* Key Value Highlights */
    .loc-trust-bar {
        background: #F8FAFC;
        border-bottom: 1px solid #E2E8F0;
        padding: 14px 0;
    }
    .loc-trust-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 16px;
        align-items: center;
        font-size: 13px;
        color: #475569;
        font-weight: 600;
    }
    .loc-trust-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .loc-trust-icon {
        color: #10B981;
        flex-shrink: 0;
    }

    /* State Grid */
    .loc-content-wrap {
        padding: 40px 0 60px;
    }

    .loc-section-header {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
        padding-bottom: 12px;
        border-bottom: 2px solid #E2E8F0;
    }

    .loc-section-title {
        font-size: 24px;
        font-weight: 800;
        color: #0B2545;
        letter-spacing: -0.01em;
        margin: 0;
    }

    .loc-section-count {
        font-size: 14px;
        color: #64748B;
        font-weight: 600;
    }

    .state-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 14px;
    }

    .state-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 16px 18px;
        text-decoration: none;
        color: #0B2545;
        font-weight: 700;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.15s ease;
        box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    }
    .state-card:hover {
        border-color: #0B2545;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(11,37,69,0.08);
        color: #C1121F;
    }
    .state-card .state-name {
        font-size: 15px;
    }

    .state-meta {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .state-abbr-badge {
        background: #F1F5F9;
        color: #475569;
        font-size: 11px;
        font-weight: 800;
        padding: 4px 7px;
        border-radius: 4px;
        letter-spacing: 0.05em;
    }

    .state-arrow {
        color: #CBD5E1;
        transition: transform 0.15s ease, color 0.15s ease;
    }
    .state-card:hover .state-arrow {
        color: #C1121F;
        transform: translateX(3px);
    }

    .loc-no-results {
        display: none;
        text-align: center;
        padding: 40px 20px;
        background: #F8FAFC;
        border: 1px dashed #CBD5E1;
        border-radius: 8px;
        color: #64748B;
        font-size: 15px;
    }

    /* How It Works 3-Step Section */
    .loc-steps-box {
        margin-top: 50px;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 32px 28px;
    }
    .loc-steps-title {
        font-size: 20px;
        font-weight: 800;
        color: #0B2545;
        text-align: center;
        margin-bottom: 24px;
    }
    .loc-steps-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
    }
    .loc-step-item {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 20px;
        position: relative;
    }
    .loc-step-num {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #0B2545;
        color: #fff;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        margin-bottom: 12px;
    }
    .loc-step-heading {
        font-size: 16px;
        font-weight: 700;
        color: #0B2545;
        margin-bottom: 6px;
    }
    .loc-step-desc {
        font-size: 14px;
        color: #64748B;
        line-height: 1.5;
        margin: 0;
    }

    /* National Chain Hub Promo Bar */
    .loc-chain-promo {
        margin-top: 32px;
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        border-radius: 10px;
        padding: 24px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
    }
    .loc-chain-promo h3 {
        margin: 0 0 6px;
        font-size: 18px;
        font-weight: 800;
        color: #fff;
    }
    .loc-chain-promo p {
        margin: 0;
        font-size: 14px;
        color: #CBD5E1;
    }
    .loc-chain-promo .promo-btn {
        background: #C1121F;
        color: #fff;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 14px;
        white-space: nowrap;
        transition: background 0.15s ease;
    }
    .loc-chain-promo .promo-btn:hover {
        background: #9E0D18;
    }

    @media (max-width: 640px) {
        .loc-hero-title { font-size: 26px; }
        .loc-hero-subtitle { font-size: 14px; }
        .state-grid { grid-template-columns: 1fr; }
        .loc-section-header { flex-direction: column; align-items: flex-start; }
    }
</style>

<!-- Hero Bar with Breadcrumbs & Dual Search -->
<div class="loc-hero-bar">
    <div class="container">
        <nav class="loc-breadcrumbs" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="sep">&rsaquo;</span>
            <span style="color:#fff; font-weight:600;">Locations Directory</span>
        </nav>

        <h1 class="loc-hero-title">
            Nationwide Drug Testing Collection Locations
        </h1>
        <p class="loc-hero-subtitle">
            Same-day testing at 20,000+ certified Quest Diagnostics and Labcorp partner collection facilities across all 50 states &amp; territories. Select your state below or search by ZIP code to find your local testing center.
        </p>

        <div class="loc-search-row">
            <!-- Direct ZIP Search Form -->
            <form action="{{ url('/locations') }}" method="GET" class="loc-zip-form" role="search">
                <input type="text" name="zip" class="loc-zip-input" inputmode="numeric" pattern="[0-9]{5}" maxlength="5" autocomplete="postal-code" placeholder="Enter 5-digit ZIP code (e.g. 34711)" required aria-label="ZIP Code">
                <button type="submit" class="loc-zip-btn">
                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    <span>Find Nearest Center</span>
                </button>
            </form>

            <!-- Instant Live State Filter Input -->
            <div class="loc-filter-box">
                <input type="text" id="stateFilterInput" class="loc-filter-input" placeholder="Filter states (e.g. Florida, Texas)..." aria-label="Filter states">
            </div>
        </div>
    </div>
</div>

<!-- Trust & Credibility Bar -->
<div class="loc-trust-bar">
    <div class="container">
        <div class="loc-trust-grid">
            <div class="loc-trust-item">
                <svg class="loc-trust-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                <span>20,000+ Quest &amp; Labcorp Partner Facilities</span>
            </div>
            <div class="loc-trust-item">
                <svg class="loc-trust-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                <span>SAMHSA-Certified Laboratories</span>
            </div>
            <div class="loc-trust-item">
                <svg class="loc-trust-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                <span>Licensed MRO Physician Review</span>
            </div>
            <div class="loc-trust-item">
                <svg class="loc-trust-icon" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                <span>Instant Donor Pass (Email &amp; SMS)</span>
            </div>
        </div>
    </div>
</div>

<!-- 50 States Directory Grid -->
<div class="container loc-content-wrap">
    <div class="loc-section-header">
        <h2 class="loc-section-title">
            Select Your State (50 States &amp; Territories)
        </h2>
        <div class="loc-section-count" id="stateCountBadge">
            Showing {{ $states->count() }} states &amp; jurisdictions
        </div>
    </div>

    <div class="state-grid" id="statesGrid">
        @foreach($states as $s)
        <a href="{{ url('/locations/' . $s->slug) }}" class="state-card" data-state-name="{{ strtolower($s->name) }}" data-state-abbr="{{ strtolower($s->abbr) }}">
            <span class="state-name">{{ $s->name }}</span>
            <div class="state-meta">
                <span class="state-abbr-badge">{{ $s->abbr }}</span>
                <svg class="state-arrow" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>
        @endforeach
    </div>

    <div class="loc-no-results" id="locNoResults">
        <p style="margin:0 0 8px; font-weight:700; color:#0B2545;">No state directories found matching your search.</p>
        <p style="margin:0;">Try typing another state name or enter your 5-digit ZIP code above to find nearby collection facilities.</p>
    </div>

    <!-- How It Works 3-Step Guide -->
    <div class="loc-steps-box">
        <h3 class="loc-steps-title">How Testing at Our Collection Locations Works</h3>
        <div class="loc-steps-grid">
            <div class="loc-step-item">
                <div class="loc-step-num">1</div>
                <div class="loc-step-heading">Order Online or By Phone</div>
                <p class="loc-step-desc">Choose your test panel (employment, DOT, personal, or legal) and register in under 3 minutes.</p>
            </div>
            <div class="loc-step-item">
                <div class="loc-step-num">2</div>
                <div class="loc-step-heading">Receive Electronic Donor Pass</div>
                <p class="loc-step-desc">An instant donor pass with a barcode is sent immediately to your email and phone.</p>
            </div>
            <div class="loc-step-item">
                <div class="loc-step-num">3</div>
                <div class="loc-step-heading">Walk In &amp; Provide Sample</div>
                <p class="loc-step-desc">Walk into any partner Quest Diagnostics or Labcorp facility. No appointment needed. No on-site payment.</p>
            </div>
        </div>
    </div>

    <!-- National Chain Hub Link -->
    <div class="loc-chain-promo">
        <div>
            <h3>Looking for National Chain Testing Information?</h3>
            <p>Learn about our nationwide network of certified testing facilities, testing types, turnaround times, and employer programs.</p>
        </div>
        <a href="{{ url('/certified-drug-test-centers') }}" class="promo-btn">
            View National Chain Hub &rarr;
        </a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var filterInput = document.getElementById('stateFilterInput');
        var stateCards = document.querySelectorAll('#statesGrid .state-card');
        var noResults = document.getElementById('locNoResults');
        var countBadge = document.getElementById('stateCountBadge');
        var totalStates = stateCards.length;

        if (filterInput && stateCards.length > 0) {
            filterInput.addEventListener('input', function () {
                var query = this.value.toLowerCase().trim();
                var visibleCount = 0;

                stateCards.forEach(function (card) {
                    var name = card.getAttribute('data-state-name') || '';
                    var abbr = card.getAttribute('data-state-abbr') || '';
                    if (!query || name.indexOf(query) !== -1 || abbr === query) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (noResults) {
                    noResults.style.display = visibleCount === 0 ? 'block' : 'none';
                }

                if (countBadge) {
                    if (query) {
                        countBadge.textContent = 'Showing ' + visibleCount + ' of ' + totalStates + ' states';
                    } else {
                        countBadge.textContent = 'Showing ' + totalStates + ' states & jurisdictions';
                    }
                }
            });
        }
    });
</script>
@endsection
