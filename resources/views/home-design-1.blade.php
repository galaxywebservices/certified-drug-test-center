@extends('layouts.main')

@section('content')

<!-- ==========================================================================
     Look 1: Modern Patriotic Healthcare & Direct Portal
     ========================================================================== -->

<!-- Hero Section -->
<section class="hero-look-1" aria-label="Hero Section">
    <div class="container hero-content">
        <div class="hero-tagline-badge">
            <span class="star-icon">★</span>
            Local • Convenient • Confidential
            <span class="star-icon">★</span>
        </div>

        <h1 class="hero-title">
            Nationwide Drug, Alcohol &amp; <span class="text-red">DOT Testing Centers</span>
        </h1>

        <p class="hero-subtitle">
            Same-day walk-in testing at over 20,000 certified Quest Diagnostics &amp; Labcorp collection sites nationwide. Fast, confidential, and court-admissible results.
        </p>

        <!-- Interactive ZIP Locator Widget -->
        <div class="hero-zip-card">
            <h2 class="zip-card-title">
                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                Find A Certified Testing Center Near You
            </h2>
            <form class="zip-search-form" id="heroZipForm">
                <div class="zip-input-wrap">
                    <svg class="zip-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" class="zip-input" placeholder="Enter Your 5-Digit ZIP Code (e.g. 32771)" maxlength="5" pattern="[0-9]{5}" required>
                </div>
                <select class="zip-select-radius" aria-label="Distance Radius">
                    <option value="10">Within 10 Miles</option>
                    <option value="25" selected>Within 25 Miles</option>
                    <option value="50">Within 50 Miles</option>
                    <option value="100">Within 100 Miles</option>
                </select>
                <button type="submit" class="btn btn-primary zip-search-btn">
                    Locate Centers
                </button>
            </form>
            <div class="zip-feedback-banner"></div>
        </div>

        <!-- Hero Actions -->
        <div class="hero-actions">
            <button type="button" class="btn btn-primary btn-lg" onclick="openOrderModal('5-panel-non-dot', 'Schedule Drug Test', 89.99)">
                Schedule Drug / Alcohol Test Online
            </button>
            <a href="tel:18002214291" class="btn btn-outline-white btn-lg">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z"></path></svg>
                Call to Schedule: (800) 221-4291
            </a>
        </div>
    </div>
</section>

<!-- Trust Credentials Bar -->
<section class="trust-bar" aria-label="Trust Signals">
    <div class="container trust-bar-grid">
        <div class="trust-item">
            <div class="trust-item-icon">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="trust-item-text">
                <h4>Certified &amp; Trained Staff</h4>
                <p>Licensed DOT &amp; Non-DOT specimen collectors</p>
            </div>
        </div>
        <div class="trust-item">
            <div class="trust-item-icon">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="trust-item-text">
                <h4>20,000+ Testing Centers</h4>
                <p>Facilities across all 50 states &amp; US territories</p>
            </div>
        </div>
        <div class="trust-item">
            <div class="trust-item-icon">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7 2a1 1 0 00-.707 1.707L7 4.414v3.758a1 1 0 01-.293.707l-4 4C.814 14.774 2.158 18 4.828 18h10.344c2.67 0 4.014-3.226 2.121-5.121l-4-4A1 1 0 0113 8.172V4.414l.707-.707A1 1 0 0013 2H7zm2 6.172V4h2v4.172a3 3 0 00.879 2.12l1.027 1.028a4 4 0 00-2.171-.32H8.265a4 4 0 00-2.171.32l1.027-1.028A3 3 0 009 8.172z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="trust-item-text">
                <h4>SAMHSA Certified Labs</h4>
                <p>Accredited analysis with MRO physician review</p>
            </div>
        </div>
        <div class="trust-item">
            <div class="trust-item-icon">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="trust-item-text">
                <h4>24/7 Online Scheduling</h4>
                <p>Instant digital donor pass sent immediately</p>
            </div>
        </div>
    </div>
</section>

<!-- Process: How To Schedule Your Test (1, 2, 3) -->
<section class="section section-light" id="how-it-works" aria-labelledby="howItWorksTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Fast &amp; Simple Registration</span>
            <h2 class="section-title" id="howItWorksTitle">How To Schedule Your Test in 3 Easy Steps</h2>
            <p class="section-desc">
                Testing centers do not accept direct payment on-site. Follow these three simple steps to obtain your electronic donor registration pass and complete your test today.
            </p>
        </div>

        <div class="process-grid">
            <div class="process-card">
                <div class="process-step-badge">1</div>
                <div class="process-stars">★</div>
                <h3>Schedule Your Test</h3>
                <p>
                    Select and purchase your drug or alcohol test online in under 2 minutes, or call our scheduling team at <strong>(800) 221-4291</strong>. Same-day walk-in service is readily available.
                </p>
            </div>

            <div class="process-card">
                <div class="process-step-badge">2</div>
                <div class="process-stars">★★</div>
                <h3>Receive Donor Pass</h3>
                <p>
                    Complete the electronic Donor Registration. The zip code you enter automatically pairs you with the closest certified testing center. Your barcoded pass is sent instantly via email and text.
                </p>
            </div>

            <div class="process-card">
                <div class="process-step-badge">3</div>
                <div class="process-stars">★★★</div>
                <h3>Walk-In &amp; Test</h3>
                <p>
                    Take your electronic donor pass on your smartphone or print it out. Walk in to the testing center during collection hours—<strong>no appointment necessary</strong>. Results are emailed confidentially.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Categories Showcase Section -->
<section class="section section-white" id="categories" aria-labelledby="categoriesTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Comprehensive Screening Options</span>
            <h2 class="section-title" id="categoriesTitle">Complete Drug, Alcohol &amp; Occupational Testing Services</h2>
            <p class="section-desc">
                From individual personal testing and court-mandated screenings to enterprise-scale DOT compliance programs, we cover every testing category nationwide.
            </p>
        </div>

        <div class="categories-grid">
            @foreach($categories as $cat)
            <div class="category-card">
                <div>
                    <div class="category-icon-wrap">
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3>{{ $cat['title'] }}</h3>
                    <div class="category-subtitle">{{ $cat['subtitle'] }}</div>
                    <p class="category-desc">{{ $cat['description'] }}</p>
                </div>
                <div>
                    <a href="{{ $cat['link'] }}" class="category-link" onclick="openOrderModal('5-panel-non-dot', '{{ $cat['title'] }}', 89.99)">
                        Explore Options →
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Products / Testing Panels with Interactive Tab Filter -->
<section class="section section-light" id="pricing-panels" aria-labelledby="pricingPanelsTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Accredited Laboratory Panels</span>
            <h2 class="section-title" id="pricingPanelsTitle">Most Popular Drug &amp; Alcohol Testing Panels</h2>
            <p class="section-desc">
                All tests include certified specimen collection at Quest Diagnostics or Labcorp sites, SAMHSA lab analysis, and Medical Review Officer (MRO) verification.
            </p>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <button type="button" class="filter-tab-btn active" data-filter="all">All Panels &amp; Services</button>
            <button type="button" class="filter-tab-btn" data-filter="urine">Urine Drug Tests</button>
            <button type="button" class="filter-tab-btn" data-filter="dot">DOT Mandated</button>
            <button type="button" class="filter-tab-btn" data-filter="hair">Hair Follicle (90 Days)</button>
            <button type="button" class="filter-tab-btn" data-filter="alcohol">Alcohol &amp; EtG</button>
            <button type="button" class="filter-tab-btn" data-filter="occupational">Occupational Health</button>
        </div>

        <!-- Product Cards Grid -->
        <div class="products-grid">
            @foreach($products as $prod)
            <article class="product-card" data-category="{{ $prod['category'] }}">
                @if(!empty($prod['badge']))
                    <span class="product-badge">{{ $prod['badge'] }}</span>
                @endif
                <div class="product-cat-tag">{{ $prod['category_label'] }}</div>
                <h3 class="product-name">{{ $prod['name'] }}</h3>

                <div class="product-price-box">
                    <span class="product-price">${{ number_format($prod['price'], 2) }}</span>
                    @if(!empty($prod['regular_price']))
                        <span class="product-reg-price">${{ number_format($prod['regular_price'], 2) }}</span>
                    @endif
                    <span class="product-discount-label">Online Discount Applied</span>
                </div>

                <p class="product-description">{{ $prod['description'] }}</p>

                <div class="product-substances-list">
                    <div class="product-substances-title">Substances Screened:</div>
                    <div class="substance-tags">
                        @foreach(array_slice($prod['substances'], 0, 5) as $sub)
                            <span class="substance-tag">{{ $sub }}</span>
                        @endforeach
                        @if(count($prod['substances']) > 5)
                            <span class="substance-tag" style="background:#E2E8F0; font-weight:700;">+{{ count($prod['substances']) - 5 }} More</span>
                        @endif
                    </div>
                </div>

                <div class="product-footer-meta">
                    <span>⏱ {{ $prod['turnaround'] }}</span>
                    <span>📍 {{ $prod['method'] }}</span>
                </div>

                <button type="button" class="btn btn-primary" onclick="openOrderModal('{{ $prod['id'] }}', '{{ addslashes($prod['name']) }}', {{ $prod['price'] }})">
                    Schedule This Test →
                </button>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Drug Testing Panels Comparison Matrix Table -->
<section class="section section-white" id="panel-comparison" aria-labelledby="comparisonTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Panel Substance Comparison</span>
            <h2 class="section-title" id="comparisonTitle">5-Panel vs 10-Panel vs 12-Panel Comparison</h2>
            <p class="section-desc">
                Review which drugs and prescription medications are screened across our primary urine drug test panels.
            </p>
        </div>

        <div class="table-responsive">
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th style="width: 35%;">Drug Class / Specific Substance</th>
                        <th style="width: 20%;">Category Type</th>
                        <th style="width: 15%; text-align:center;">5 Panel ($89.99)</th>
                        <th style="width: 15%; text-align:center;">10 Panel ($109.99)</th>
                        <th style="width: 15%; text-align:center;">12 Panel ($139.99)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comparisonPanels as $row)
                    <tr>
                        <td><strong>{{ $row['substance'] }}</strong></td>
                        <td style="color:#64748B;">{{ $row['category'] }}</td>
                        <td style="text-align:center;">
                            @if($row['panel5'] === true)
                                <span class="check-yes">✓ Included</span>
                            @else
                                <span class="check-no">—</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($row['panel10'] === true)
                                <span class="check-yes">✓ Included</span>
                            @elseif($row['panel10'] === 'Add-on')
                                <span class="check-addon">Optional Add-On</span>
                            @else
                                <span class="check-no">—</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($row['panel12'] === true)
                                <span class="check-yes">✓ Included</span>
                            @else
                                <span class="check-no">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="text-align:center; margin-top:28px;">
            <p style="font-size:14px; color:var(--color-text-muted); margin-bottom:14px;">
                Need custom corporate panel configurations, steroid testing, or specialized synthetics (K2/Spice)?
            </p>
            <a href="tel:18002214291" class="btn btn-outline-navy">
                Consult With A Testing Specialist at (800) 221-4291
            </a>
        </div>
    </div>
</section>

<!-- On-Site Mobile Testing Banner -->
<section class="section section-navy" id="mobile-testing" aria-labelledby="mobileTestingTitle">
    <div class="container" style="text-align:center;">
        <span class="section-eyebrow" style="color:#FF5A5F;">We Come To Your Location</span>
        <h2 class="section-title" id="mobileTestingTitle">On-Site &amp; Mobile Drug Testing Nationwide</h2>
        <p class="section-desc" style="max-width:740px; margin:0 auto 28px;">
            Minimize operational downtime and eliminate employee travel. Our mobile testing units dispatch certified collectors directly to your job site, distribution center, or corporate offices 24/7/365.
        </p>
        <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap;">
            <button type="button" class="btn btn-primary btn-lg" onclick="openMobileQuoteModal()">
                Request Mobile Testing Quote
            </button>
            <a href="tel:18002214291" class="btn btn-outline-white btn-lg">
                Speak With Mobile Dispatch
            </a>
        </div>
    </div>
</section>

<!-- 50 States Directory Section -->
<section class="section section-light" id="locations" aria-labelledby="locationsTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Local Collection Facilities</span>
            <h2 class="section-title" id="locationsTitle">Find Drug Testing Centers By State</h2>
            <p class="section-desc">
                Certified collection sites located in every major metro, suburb, and rural county across the United States.
            </p>
        </div>

        <div class="state-search-bar">
            <input type="text" id="stateSearchInput" class="zip-input" placeholder="Type State Name (e.g. Florida, Texas, Ohio)..." style="padding-left:16px;">
        </div>

        <div class="states-grid" id="statesGrid">
            @foreach($states as $st)
            <a href="#locations" class="state-chip" data-state="{{ $st['name'] }}" onclick="document.getElementById('donorZip').value='{{ $st['abbr'] }}'; openOrderModal('5-panel-non-dot', 'Drug Test in {{ $st['name'] }}', 89.99)">
                <span>{{ $st['name'] }}</span>
                <span class="state-count">{{ $st['centers'] }}+ Sites</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- SEO FAQ Accordion -->
<section class="section section-white" id="faq" aria-labelledby="faqTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Frequently Asked Questions</span>
            <h2 class="section-title" id="faqTitle">Frequently Asked Drug Testing Questions</h2>
            <p class="section-desc">
                Everything you need to know about scheduling, collection procedures, detection times, and medical review officer verification.
            </p>
        </div>

        <div class="faq-wrap">
            @foreach($faqs as $faq)
            <details class="faq-item">
                <summary class="faq-summary">
                    <span>{{ $faq['question'] }}</span>
                </summary>
                <div class="faq-content">
                    <p>{{ $faq['answer'] }}</p>
                </div>
            </details>
            @endforeach
        </div>
    </div>
</section>

<!-- Ready To Schedule Banner CTA -->
<section class="section section-light" style="border-top:1px solid var(--color-border);" aria-label="Ready To Schedule">
    <div class="container" style="text-align:center;">
        <h2 style="font-family:var(--font-heading); font-size:32px; font-weight:800; color:var(--color-primary); margin-bottom:12px;">
            Ready To Schedule Your Test Today?
        </h2>
        <p style="font-size:16px; color:var(--color-text-muted); margin-bottom:28px; max-width:640px; margin-left:auto; margin-right:auto;">
            Register online now to receive your instant electronic donor pass or call our certified specialists for immediate phone assistance.
        </p>
        <div style="display:flex; justify-content:center; gap:16px; flex-wrap:wrap;">
            <button type="button" class="btn btn-primary btn-lg" onclick="openOrderModal('5-panel-non-dot', 'Schedule Drug Test', 89.99)">
                Schedule Drug Test Now
            </button>
            <a href="tel:18002214291" class="btn btn-navy btn-lg">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z"></path></svg>
                Call (800) 221-4291
            </a>
        </div>
    </div>
</section>

@endsection
