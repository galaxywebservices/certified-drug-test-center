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
                SAMHSA Certified &bull; Same-Day Walk-Ins Nationwide
                <span style="color:#C1121F;">★</span>
            </div>

            <h1>
                Nationwide <span class="highlight-red">{{ $chain['full_title'] }}</span>
            </h1>

            <p>
                {{ $chain['description'] }} Walk in today at over 20,000 certified Quest Diagnostics &amp; Labcorp partner collection facilities across all 50 states. Confidential Medical Review Officer (MRO) verified results delivered in {{ $chain['turnaround'] }}.
            </p>

            <ul class="hero-split-checklist">
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    20,000+ Quest &amp; Labcorp Sites
                </li>
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    SAMHSA Certified Laboratories
                </li>
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Licensed Physician MRO Included
                </li>
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Court, DOT &amp; Workplace Defensible
                </li>
            </ul>

            <div style="display:flex; flex-wrap:wrap; gap:12px; align-items:center;">
                <a href="#states-grid" class="btn btn-primary btn-lg" style="box-shadow: 0 4px 16px rgba(193, 18, 31, 0.35);">
                    Select Your State &darr;
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

        <!-- Hero Right: Order Pass Summary Card -->
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
                    <p class="service-order-subtitle">Same-day walk-in authorization with electronic barcode pass</p>
                </div>

                <div class="service-order-price-row">
                    <div class="service-order-price-val">${{ number_format($chain['default_price'], 2) }}</div>
                    <div class="service-order-price-note">
                        All-Inclusive Price<br>
                        <span style="color:#64748B; font-weight:500;">No Hidden Collection or Lab Fees</span>
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
                        <span>Partner Facilities:</span>
                        <strong>Quest Diagnostics &amp; Labcorp</strong>
                    </li>
                    <li class="service-order-meta-item">
                        <span>Doctor's Order:</span>
                        <strong style="color:#15803D;">Not Required (Included)</strong>
                    </li>
                </ul>

                <!-- State Jump Selector -->
                <div class="service-state-jump-wrap">
                    <label class="service-state-jump-label" for="heroStateJump">
                        1. Jump to Your State Collection Sites:
                    </label>
                    <select id="heroStateJump" class="service-state-jump-select" onchange="if(this.value) window.location.href=this.value;">
                        <option value="">-- Choose Your State --</option>
                        @foreach($states as $st)
                            <option value="{{ rtrim(url('/services/' . $chain['slug'] . '/' . $st->slug), '/') . '/' }}">
                                {{ $st->name }} ({{ number_format($st->eligible_cities_count) }} Cities)
                            </option>
                        @endforeach
                    </select>
                </div>

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

<!-- 4-Step Express Timeline -->
<section class="section section-white" aria-label="Process Overview">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">HOW TESTING WORKS</span>
            <h2 class="section-title">Fast &amp; Simple Same-Day Walk-In Process</h2>
            <p class="section-desc">Get tested today at a certified partner collection site near you in four easy steps:</p>
        </div>

        <div class="process-grid-4-wrap">
            <div class="process-card-step">
                <div class="process-step-num">01.</div>
                <h3>Choose State &amp; Register</h3>
                <p>Select your state and city below, or order online. Enter donor details to generate your official testing requisition.</p>
            </div>
            <div class="process-card-step">
                <div class="process-step-num">02.</div>
                <h3>Instant Donor Pass</h3>
                <p>An official registration donor pass barcode with directions to the nearest collection site is sent to your email &amp; phone.</p>
            </div>
            <div class="process-card-step">
                <div class="process-step-num">03.</div>
                <h3>Walk-In Collection</h3>
                <p>Show your digital barcode pass on your smartphone. Certified technicians collect your specimen with chain of custody integrity.</p>
            </div>
            <div class="process-card-step">
                <div class="process-step-num">04.</div>
                <h3>MRO Verified Results</h3>
                <p>Specimens are processed at SAMHSA accredited laboratories. Physician MRO signed results delivered securely in {{ $chain['turnaround'] }}.</p>
            </div>
        </div>
    </div>
</section>

<!-- States Selection Grid Section -->
<section class="section section-light" id="states-grid" aria-labelledby="statesDirectoryTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">NATIONAL COLLECTION DIRECTORY</span>
            <h2 class="section-title" id="statesDirectoryTitle">Select Your State for {{ $chain['name'] }}</h2>
            <p class="section-desc">
                Choose your state below to see local certified collection centers, city directories, and state statutory compliance notes:
            </p>
        </div>

        <!-- Pre-registration notice banner -->
        <div style="background:#FEF2F2; border:1px solid #FECACA; border-radius:10px; padding:14px 20px; margin-bottom:24px; text-align:center; color:#991B1B; font-size:13.5px; font-weight:600;">
            <span style="color:#16A34A; font-weight:800;">✓ Same-Day Walk-Ins Accepted</span> &bull; <strong style="color:#C1121F;">Pre-Registration Required:</strong> You must purchase online or by phone to generate your electronic barcode donor pass before walking into partner facilities.
        </div>

        <!-- Popular States Quick Bar -->
        <div class="popular-states-bar">
            <span class="popular-states-label">Top States:</span>
            @php
                $popularStateSlugs = ['california', 'texas', 'florida', 'new-york', 'pennsylvania', 'illinois', 'ohio', 'georgia', 'north-carolina', 'michigan'];
            @endphp
            @foreach($states as $st)
                @if(in_array($st->slug, $popularStateSlugs))
                    <a href="{{ rtrim(url('/services/' . $chain['slug'] . '/' . $st->slug), '/') . '/' }}" class="popular-state-chip">
                        {{ $st->name }}
                    </a>
                @endif
            @endforeach
        </div>

        <!-- Interactive Search Bar -->
        <div class="state-search-bar" style="margin-bottom: 24px; position:relative;">
            <div style="position:relative;">
                <svg style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94A3B8;" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="stateSearchInput" class="zip-input" placeholder="Search state name (e.g. Florida, Texas, California, New York)..." style="padding-left:46px; width:100%; background:#fff;">
            </div>
        </div>

        <!-- Enhanced States Grid -->
        <div class="states-grid-enhanced" id="statesGrid">
            @foreach($states as $st)
                <a href="{{ rtrim(url('/services/' . $chain['slug'] . '/' . $st->slug), '/') . '/' }}" class="state-card-v2" data-state="{{ strtolower($st->name) }}">
                    <div class="state-card-v2-left">
                        <div class="state-abbr-badge">{{ $st->abbr }}</div>
                        <div class="state-card-v2-info">
                            <span class="state-card-v2-name">{{ $st->name }}</span>
                            <span class="state-card-v2-cities">{{ number_format($st->eligible_cities_count) }} Cities</span>
                        </div>
                    </div>
                    <span class="state-card-v2-arrow">&rarr;</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Clinical Substance Detection & Cutoff Levels -->
<section class="section section-white" aria-labelledby="substancesSectionTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">LABORATORY SPECIFICATIONS</span>
            <h2 class="section-title" id="substancesSectionTitle">Substances Screened &amp; Detection Thresholds</h2>
            <p class="section-desc">
                All screening and GC/MS confirmation cutoff levels conform strictly to federal SAMHSA and CLIA regulatory mandates:
            </p>
        </div>

        <div class="clinical-table-wrapper">
            <table class="clinical-spec-table">
                <thead>
                    <tr>
                        <th style="width:28%;">Drug / Metabolite Class</th>
                        <th style="width:26%;">Common Names / Brand Examples</th>
                        <th style="width:18%;">Initial Immunoassay Cutoff</th>
                        <th style="width:18%;">GC/MS Confirmation Cutoff</th>
                        <th style="width:10%;">Approx. Window</th>
                    </tr>
                </thead>
                <tbody>
                    @if($chain['slug'] === '5-panel-drug-test')
                        <tr>
                            <td><strong>Marijuana (THC)</strong></td>
                            <td>Cannabis, Weed, Delta-9-THC metabolites</td>
                            <td>50 ng/mL</td>
                            <td>15 ng/mL</td>
                            <td><span class="clinical-badge-detect">1–30 Days</span></td>
                        </tr>
                        <tr>
                            <td><strong>Cocaine Metabolites</strong></td>
                            <td>Benzoylecgonine, Crack, Cocaine HCL</td>
                            <td>150 ng/mL</td>
                            <td>100 ng/mL</td>
                            <td><span class="clinical-badge-detect">2–4 Days</span></td>
                        </tr>
                        <tr>
                            <td><strong>Basic Opiates</strong></td>
                            <td>Codeine, Morphine, 6-Acetylmorphine (Heroin)</td>
                            <td>2,000 ng/mL</td>
                            <td>2,000 ng/mL</td>
                            <td><span class="clinical-badge-detect">2–4 Days</span></td>
                        </tr>
                        <tr>
                            <td><strong>Amphetamines</strong></td>
                            <td>d-Amphetamine, Methamphetamine, MDMA (Ecstasy)</td>
                            <td>500 ng/mL</td>
                            <td>250 ng/mL</td>
                            <td><span class="clinical-badge-detect">2–3 Days</span></td>
                        </tr>
                        <tr>
                            <td><strong>Phencyclidine (PCP)</strong></td>
                            <td>Angel Dust, PCP</td>
                            <td>25 ng/mL</td>
                            <td>25 ng/mL</td>
                            <td><span class="clinical-badge-detect">7–14 Days</span></td>
                        </tr>
                    @else
                        @foreach($chain['substances'] as $sub)
                            <tr>
                                <td><strong>{{ $sub }}</strong></td>
                                <td>Standard Clinical Screen Panel</td>
                                <td>SAMHSA Standard</td>
                                <td>LC/MS Confirmed</td>
                                <td><span class="clinical-badge-detect">Clinical Window</span></td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Cross-Service Switcher Grid -->
<section class="section section-light" aria-labelledby="otherServicesTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">EXPLORE OTHER PANELS</span>
            <h2 class="section-title" id="otherServicesTitle">Compare Related Drug &amp; Alcohol Testing Chains</h2>
            <p class="section-desc">
                Need more comprehensive testing? Explore our complete testing panel catalog:
            </p>
        </div>

        <div class="products-grid">
            @foreach($allChains as $slug => $other)
                @if($slug !== $chain['slug'])
                    <article class="product-card">
                        <span class="product-badge">{{ $other['specimen'] }}</span>
                        <div class="product-cat-tag">Nationwide Walk-In</div>
                        <h3 class="product-name">{{ $other['name'] }}</h3>

                        <div class="product-price-box">
                            <span class="product-price">${{ number_format($other['default_price'], 2) }}</span>
                            <span class="product-discount-label">MRO Included</span>
                        </div>

                        <p class="product-description">{{ $other['description'] }}</p>

                        <div class="product-footer-meta" style="margin-top:auto; margin-bottom:16px;">
                            <span>⏱ {{ $other['turnaround'] }}</span>
                            <span>📍 Quest &amp; Labcorp</span>
                        </div>

                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <a href="{{ rtrim(url('/services/' . $slug), '/') . '/' }}" class="btn btn-navy" style="width:100%; font-size:13.5px; padding:11px 16px;">
                                View State Centers &rarr;
                            </a>
                            <a href="{{ route('checkout.index', ['slug' => $other['product_slug']]) }}" class="btn btn-primary" style="width:100%; font-size:13.5px; padding:10px 16px;">
                                Order Donor Pass Online
                            </a>
                        </div>
                    </article>
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- Frequently Asked Questions -->
<section class="section section-white" aria-labelledby="faqTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">PATIENT &amp; EMPLOYER QUESTIONS</span>
            <h2 class="section-title" id="faqTitle">Frequently Asked Questions About {{ $chain['name'] }}</h2>
            <p class="section-desc">Common answers regarding scheduling, laboratory analysis, and certified results:</p>
        </div>

        <div class="pseo-faq-grid">
            <div class="pseo-faq-card">
                <h3>Do I need a doctor's prescription or appointment?</h3>
                <p>No. When you register online with Certified Drug Test Centers, a physician order and electronic chain of custody form (eCCF) are automatically generated. You can walk in same-day to any verified partner collection facility during normal business hours.</p>
            </div>
            <div class="pseo-faq-card">
                <h3>How quickly do I receive my electronic donor pass?</h3>
                <p>Immediately. Once your online order is placed, your donor pass barcode is sent within 2 minutes via email and SMS. Simply show this barcode on your phone to the collection facility staff upon arrival.</p>
            </div>
            <div class="pseo-faq-card">
                <h3>Who reviews the test results?</h3>
                <p>All laboratory analyses are supervised and verified by an independent, licensed Medical Review Officer (MRO). The MRO confirms negative results and contacts donors if prescription validation is required for legally defensible documentation.</p>
            </div>
            <div class="pseo-faq-card">
                <h3>Are the results legally admissible for court or employment?</h3>
                <p>Yes. All specimens are processed at SAMHSA/CLIA accredited facilities following strict forensic chain of custody standards. Results include signed MRO documentation suitable for employers, courts, probation, and DOT compliance.</p>
            </div>
        </div>
    </div>
</section>

<!-- State Live Filter Search Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('stateSearchInput');
    const statesGrid = document.getElementById('statesGrid');
    if (searchInput && statesGrid) {
        const cards = statesGrid.querySelectorAll('.state-card-v2');
        searchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            cards.forEach(card => {
                const stateName = card.getAttribute('data-state') || '';
                if (!query || stateName.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection
