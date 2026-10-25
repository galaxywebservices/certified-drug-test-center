@extends('layouts.main')

@section('content')

<!-- ==========================================================================
     Look 2: Corporate Clean Trust & Speed (Streamlined Direct-to-Test Focus)
     ========================================================================== -->

<!-- Split Hero Section with Instant Test Estimator Card -->
<section class="hero-split" aria-label="Hero Section">
    <div class="container hero-split-grid">
        <div class="hero-split-left">
            <div class="hero-tagline-badge" style="background:#F0F5FA; border:1px solid #CBD5E1; color:#0B2545;">
                <span style="color:#C1121F;">★</span>
                Express Online Drug &amp; Alcohol Testing
                <span style="color:#C1121F;">★</span>
            </div>

            <h1>
                Accredited Drug Testing Made <span class="highlight-red">Fast, Simple &amp; Confidential</span>
            </h1>

            <p>
                Get your electronic donor pass in 2 minutes. Walk in today at over 20,000 Quest Diagnostics and Labcorp certified collection sites nationwide. No doctor order or appointment necessary.
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
                    Physician MRO Verification
                </li>
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Court &amp; DOT Legally Defensible
                </li>
            </ul>

            <!-- Inline Quick Zip Search -->
            <div class="zip-search-wrapper" style="margin-top:20px;">
                <form class="zip-search-form">
                    <div class="zip-input-wrap">
                        <svg class="zip-icon" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        <input type="text" class="zip-input" placeholder="Enter ZIP Code to Find Nearest Center" maxlength="5" pattern="[0-9]{5}" required>
                    </div>
                    <button type="submit" class="btn btn-navy">
                        Find Centers
                    </button>
                </form>
                <div class="zip-feedback-banner"></div>
            </div>
        </div>

        <!-- Right Side: Interactive Instant Test Selector & Price Estimator -->
        <div class="hero-split-right">
            <div class="quick-estimator-card">
                <div class="estimator-header">
                    <h3>
                        <svg width="22" height="22" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1zm1-4a1 1 0 100 2h.01a1 1 0 100-2H7zm2 1a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zm4-4a1 1 0 100 2h.01a1 1 0 100-2H13zM9 9a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zM7 8a1 1 0 100 2h.01a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                        Instant Test Selector &amp; Estimator
                    </h3>
                    <p>Select your testing criteria to instantly view pricing and register</p>
                </div>

                <div class="estimator-field">
                    <label class="estimator-label" for="estReason">1. What is the reason for testing?</label>
                    <select id="estReason" class="estimator-select">
                        <option value="employment">Pre-Employment / Workplace</option>
                        <option value="dot">DOT Regulated (FMCSA / FAA / USCG)</option>
                        <option value="court">Court Ordered / Probation / Legal</option>
                        <option value="personal">Personal / Family Testing</option>
                    </select>
                </div>

                <div class="estimator-field">
                    <label class="estimator-label" for="estSpecimen">2. Select Specimen or Test Panel</label>
                    <select id="estSpecimen" class="estimator-select">
                        <option value="urine-5">5 Panel Non-DOT Urine Test (Basic)</option>
                        <option value="urine-10">10 Panel Comprehensive Urine Test</option>
                        <option value="urine-12">12 Panel Maximum Coverage Urine Test</option>
                        <option value="dot-5">5 Panel DOT Federal Urine Screen</option>
                        <option value="hair-5">Hair Follicle 5-Panel (90-Day History)</option>
                        <option value="alcohol-breath">Breath Alcohol Test (BAT / EBT)</option>
                        <option value="physical-dot">DOT Physical Exam (NRCME Doctor)</option>
                    </select>
                </div>

                <div class="estimator-price-display">
                    <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#64748B; margin-bottom:4px;">
                        Guaranteed Package Price
                    </div>
                    <div class="estimator-price-val" id="estPriceVal">$89.99</div>
                    <div style="font-size:14px; font-weight:700; color:var(--color-primary); margin-top:4px;" id="estPanelName">
                        5 Panel Non-DOT Urine Test
                    </div>
                    <div class="estimator-features-preview" id="estTurnaround">
                        Turnaround: 1 - 2 Business Days • MRO Physician Reviewed
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-lg" style="width:100%; margin-top:16px;" onclick="openOrderModal('5-panel-non-dot', document.getElementById('estPanelName').textContent, 89.99)">
                    Register &amp; Obtain Donor Pass Now →
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Interactive Substance Lookup Tool -->
<section class="section section-light" id="substance-checker" aria-labelledby="substanceToolTitle">
    <div class="container container-narrow">
        <div class="substance-checker-box">
            <div style="text-align:center; margin-bottom:20px;">
                <span class="section-eyebrow">Smart Drug Screening Tool</span>
                <h2 style="font-family:var(--font-heading); font-size:24px; font-weight:800; color:var(--color-primary);" id="substanceToolTitle">
                    Looking For A Specific Drug Or Medication?
                </h2>
                <p style="font-size:14px; color:var(--color-text-muted);">
                    Type a drug name, medication, or substance below to find which testing panel detects it.
                </p>
            </div>

            <input type="text" id="substanceSearchInput" class="substance-search-input" placeholder="Search drug e.g. Xanax, Oxycodone, Marijuana, Fentanyl, Cocaine, Tramadol...">

            <div class="substance-pills-quick">
                <span style="font-size:12px; font-weight:700; color:#64748B; align-self:center;">Quick Select:</span>
                <button type="button" class="substance-quick-pill" data-substance="Marijuana">Marijuana (THC)</button>
                <button type="button" class="substance-quick-pill" data-substance="Cocaine">Cocaine</button>
                <button type="button" class="substance-quick-pill" data-substance="Oxycodone">Oxycodone (Percocet)</button>
                <button type="button" class="substance-quick-pill" data-substance="Xanax">Xanax (Benzos)</button>
                <button type="button" class="substance-quick-pill" data-substance="Hydrocodone">Hydrocodone (Vicodin)</button>
                <button type="button" class="substance-quick-pill" data-substance="Tramadol">Tramadol</button>
                <button type="button" class="substance-quick-pill" data-substance="Fentanyl">Fentanyl</button>
                <button type="button" class="substance-quick-pill" data-substance="Alcohol">Alcohol (EtG)</button>
            </div>

            <div id="substanceMatchResult" class="substance-match-result"></div>
        </div>
    </div>
</section>

<!-- Horizontal 3-Step Express Timeline -->
<section class="section section-white" aria-label="Process Overview">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Zero Waiting Time</span>
            <h2 class="section-title">The Fastest Way To Complete A Drug Test</h2>
            <p class="section-desc">Our automated digital dispatch gets you tested and on with your day.</p>
        </div>

        <div class="process-grid">
            <div class="process-card" style="text-align:left;">
                <div style="font-family:var(--font-heading); font-size:32px; font-weight:800; color:var(--color-accent-red); margin-bottom:10px;">01.</div>
                <h3>Choose Test &amp; Register</h3>
                <p>Select your testing panel online. Enter donor details and zip code to locate the nearest collection facility.</p>
            </div>
            <div class="process-card" style="text-align:left;">
                <div style="font-family:var(--font-heading); font-size:32px; font-weight:800; color:var(--color-accent-red); margin-bottom:10px;">02.</div>
                <h3>Instant Donor Pass</h3>
                <p>A registration confirmation pass with barcode and site directions is immediately sent to your email and phone.</p>
            </div>
            <div class="process-card" style="text-align:left;">
                <div style="font-family:var(--font-heading); font-size:32px; font-weight:800; color:var(--color-accent-red); margin-bottom:10px;">03.</div>
                <h3>Walk-In Collection</h3>
                <p>Show your pass on your smartphone. The certified collection site handles testing with SAMHSA laboratory analysis.</p>
            </div>
        </div>
    </div>
</section>

<!-- Full Product Grid with Filter Tabs -->
<section class="section section-light" id="products-section" aria-labelledby="allPanelsTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Catalog &amp; Pricing</span>
            <h2 class="section-title" id="allPanelsTitle">Drug &amp; Alcohol Testing Catalog</h2>
            <p class="section-desc">
                Clear upfront pricing with no hidden laboratory fees or collection charges.
            </p>
        </div>

        <div class="filter-tabs">
            <button type="button" class="filter-tab-btn active" data-filter="all">All Products</button>
            <button type="button" class="filter-tab-btn" data-filter="urine">Urine Panels</button>
            <button type="button" class="filter-tab-btn" data-filter="dot">DOT Regulated</button>
            <button type="button" class="filter-tab-btn" data-filter="hair">Hair Follicle</button>
            <button type="button" class="filter-tab-btn" data-filter="alcohol">Alcohol &amp; EtG</button>
            <button type="button" class="filter-tab-btn" data-filter="occupational">Occupational</button>
        </div>

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
                    <span class="product-discount-label">Save Today</span>
                </div>

                <p class="product-description">{{ $prod['description'] }}</p>

                <div class="product-substances-list">
                    <div class="product-substances-title">Included Substances:</div>
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

                <button type="button" class="btn btn-navy" onclick="openOrderModal('{{ $prod['id'] }}', '{{ addslashes($prod['name']) }}', {{ $prod['price'] }})">
                    Order Test Online →
                </button>
            </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Panel Comparison Table -->
<section class="section section-white" id="comparison-section" aria-labelledby="compTableTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Panel Breakdown</span>
            <h2 class="section-title" id="compTableTitle">Side-by-Side Substance Detection Matrix</h2>
            <p class="section-desc">Quick reference table showing which drugs are screened in each panel level.</p>
        </div>

        <div class="table-responsive">
            <table class="comparison-table">
                <thead>
                    <tr>
                        <th style="width: 35%;">Drug / Metabolite</th>
                        <th style="width: 20%;">Class</th>
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
                                <span class="check-yes">✓ Yes</span>
                            @else
                                <span class="check-no">—</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($row['panel10'] === true)
                                <span class="check-yes">✓ Yes</span>
                            @elseif($row['panel10'] === 'Add-on')
                                <span class="check-addon">Add-On</span>
                            @else
                                <span class="check-no">—</span>
                            @endif
                        </td>
                        <td style="text-align:center;">
                            @if($row['panel12'] === true)
                                <span class="check-yes">✓ Yes</span>
                            @else
                                <span class="check-no">—</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- State Locator Filter -->
<section class="section section-light" id="locations" aria-labelledby="statesDirectoryTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">National Directory</span>
            <h2 class="section-title" id="statesDirectoryTitle">Browse Collection Centers By State</h2>
            <p class="section-desc">More than 20,000 collection sites serving every metropolitan and regional area.</p>
        </div>

        <div class="state-search-bar">
            <input type="text" id="stateSearchInput" class="zip-input" placeholder="Search state name..." style="padding-left:16px;">
        </div>

        <div class="states-grid" id="statesGrid">
            @foreach($states as $st)
            <a href="#locations" class="state-chip" data-state="{{ $st['name'] }}" onclick="document.getElementById('donorZip').value='{{ $st['abbr'] }}'; openOrderModal('5-panel-non-dot', 'Drug Test in {{ $st['name'] }}', 89.99)">
                <span>{{ $st['name'] }}</span>
                <span class="state-count">{{ $st['centers'] }}+ Centers</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ Accordion -->
<section class="section section-white" id="faq-section" aria-labelledby="faqTitle2">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Help &amp; Support</span>
            <h2 class="section-title" id="faqTitle2">Frequently Asked Questions</h2>
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

@endsection
