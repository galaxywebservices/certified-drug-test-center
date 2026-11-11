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
                Accredited Testing &bull; 20,000+ Nationwide Facilities
                <span style="color:#C1121F;">★</span>
            </div>

            <h1>
                Nationwide Drug &amp; Alcohol <span class="highlight-red">Testing Services</span>
            </h1>

            <p>
                Certified Drug Test Centers provides fast, confidential same-day drug, alcohol, DOT, and specialized clinical testing. Register online in 2 minutes, receive an immediate electronic donor pass barcode, and walk into any verified Quest Diagnostics or Labcorp partner facility across all 50 states.
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
                <a href="#services-catalog" class="btn btn-primary btn-lg" style="box-shadow: 0 4px 16px rgba(193, 18, 31, 0.35);">
                    Browse All 9 Testing Chains &darr;
                </a>
                <a href="tel:18009854339" class="top-phone-link" style="font-size:15px; margin-left:6px;">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z"/></svg>
                    (800) 985-4339
                </a>
            </div>
        </div>

        <!-- Hero Right: Interactive Instant Test Selector & Price Estimator -->
        <div class="hero-split-right">
            <div class="quick-estimator-card">
                <div class="estimator-header">
                    <h3>
                        <svg width="22" height="22" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1zm1-4a1 1 0 100 2h.01a1 1 0 100-2H7zm2 1a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zm4-4a1 1 0 100 2h.01a1 1 0 100-2H13zM9 9a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zM7 8a1 1 0 100 2h.01a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                        Express Online Order
                    </h3>
                    <p>Select your testing criteria to instantly view pricing and register</p>
                </div>

                <div class="estimator-field">
                    <label class="estimator-label" for="estReason">1. Reason for Testing</label>
                    <select id="estReason" class="estimator-select">
                        <option value="Pre-Employment">Pre-Employment</option>
                        <option value="Random">Random</option>
                        <option value="Reasonable Suspicion">Reasonable Suspicion</option>
                        <option value="Post-Accident">Post-Accident</option>
                        <option value="Follow-Up">Follow-Up</option>
                        <option value="Return to Duty">Return to Duty</option>
                    </select>
                </div>

                <div class="estimator-field">
                    <label class="estimator-label" for="estMethod">2. Testing Specimen Method</label>
                    <select id="estMethod" class="estimator-select" onchange="handleEstimatorMethodChange(this.value)">
                        <option value="urine">Urine Panels (Standard &amp; DOT)</option>
                        <option value="hair">Hair Follicle (90-Day History)</option>
                        <option value="alcohol">Breath Alcohol / EtG Testing</option>
                        <option value="rapid">Rapid Instant Screen (15 Min)</option>
                    </select>
                </div>

                <div class="estimator-field">
                    <label class="estimator-label" for="estSpecimen">3. Select Specific Test Panel</label>
                    <select id="estSpecimen" class="estimator-select" onchange="updateEstimatorDisplay()">
                        <option value="5-panel-nondot" data-name="5-Panel Non-DOT Urine Test" data-price="89.99">5-Panel Non-DOT Urine Test ($89.99)</option>
                        <option value="10-panel" data-name="10-Panel Comprehensive Urine Test" data-price="109.99">10-Panel Comprehensive Urine Test ($109.99)</option>
                        <option value="12-panel-comprehensive" data-name="12-Panel Maximum Coverage Screen" data-price="139.99">12-Panel Maximum Coverage Screen ($139.99)</option>
                        <option value="5-panel-dot" data-name="DOT 5-Panel Federal Urine Screen" data-price="99.99">DOT 5-Panel Federal Urine Screen ($99.99)</option>
                        <option value="hair-follicle-5-panel" data-name="Hair Follicle 5-Panel (90-Day History)" data-price="169.99">Hair Follicle 5-Panel ($169.99)</option>
                        <option value="dot-breath-alcohol" data-name="Breath Alcohol Test (BAT / EBT)" data-price="89.99">Breath Alcohol Test ($89.99)</option>
                    </select>
                </div>

                <div class="estimator-price-display">
                    <div style="font-size:15px; font-weight:800; color:var(--color-primary); line-height:1.2;" id="estPanelName">
                        5-Panel Non-DOT Urine Test
                    </div>
                    <div class="estimator-price-val" id="estPriceVal">$89.99</div>
                    <div class="estimator-features-preview" style="font-size:12px; color:#166534; font-weight:600; margin-top:4px;">
                        Includes: Lab Analysis, MRO Physician Review &amp; Electronic Pass
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-lg" style="width:100%; margin-top:16px;" onclick="handleEstimatorOrder()">
                    Order Test / Get Donor Pass &rarr;
                </button>
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
            <span class="section-eyebrow">ZERO WAITING TIME</span>
            <h2 class="section-title">The Fastest Way To Complete A Drug Test</h2>
            <p class="section-desc">Our online registration system gets you tested and on with your day in 4 easy steps:</p>
        </div>

        <div class="process-grid-4-wrap">
            <div class="process-card-step">
                <div class="process-step-num">01.</div>
                <h3>Choose Test &amp; Register</h3>
                <p>Select your testing panel online. Enter donor details and zip code to locate the nearest collection facility.</p>
            </div>
            <div class="process-card-step">
                <div class="process-step-num">02.</div>
                <h3>Instant Donor Pass</h3>
                <p>A registration confirmation pass with barcode and site directions is immediately sent to your email and phone.</p>
            </div>
            <div class="process-card-step">
                <div class="process-step-num">03.</div>
                <h3>Walk-In Collection</h3>
                <p>Show your pass on your smartphone. The certified collection site handles testing with SAMHSA laboratory analysis.</p>
            </div>
            <div class="process-card-step">
                <div class="process-step-num">04.</div>
                <h3>Fast Electronic Results</h3>
                <p>Official Medical Review Officer (MRO) verified results delivered securely via email within 24-48 business hours.</p>
            </div>
        </div>
    </div>
</section>

<!-- Main Services Catalog Grid -->
<section class="section section-light" id="services-catalog" aria-labelledby="catalogSectionTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">COMPLETE TESTING CATALOG</span>
            <h2 class="section-title" id="catalogSectionTitle">Select A Certified Drug Screening Service</h2>
            <p class="section-desc">
                Clear upfront pricing with no doctor referral needed. Includes electronic donor pass, laboratory analysis, and certified physician MRO review.
            </p>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs" style="display:flex; flex-wrap:wrap; gap:8px; justify-content:center; margin-bottom:30px;">
            <button type="button" class="filter-tab-btn active" data-filter="all">All Services</button>
            <button type="button" class="filter-tab-btn" data-filter="urine">Urine Panels</button>
            <button type="button" class="filter-tab-btn" data-filter="dot">DOT Regulated</button>
            <button type="button" class="filter-tab-btn" data-filter="hair">Hair Follicle</button>
            <button type="button" class="filter-tab-btn" data-filter="alcohol">Alcohol &amp; EtG</button>
            <button type="button" class="filter-tab-btn" data-filter="rapid">Rapid Testing</button>
        </div>

        <div class="products-grid">
            @foreach($allChains as $slug => $chain)
                @php
                    $catClass = 'urine';
                    if (str_contains($slug, 'dot')) $catClass = 'dot';
                    elseif (str_contains($slug, 'hair')) $catClass = 'hair';
                    elseif (str_contains($slug, 'alcohol') || str_contains($slug, 'breath')) $catClass = 'alcohol';
                    elseif (str_contains($slug, 'instant') || str_contains($slug, 'rapid')) $catClass = 'rapid';
                @endphp
                <article class="product-card" data-category="{{ $catClass }}">
                    <span class="product-badge">{{ $chain['specimen'] }}</span>
                    <div class="product-cat-tag">Nationwide Walk-In</div>
                    <h3 class="product-name">{{ $chain['name'] }}</h3>

                    <div class="product-price-box">
                        <span class="product-price">${{ number_format($chain['default_price'], 2) }}</span>
                        <span class="product-discount-label">MRO Included</span>
                    </div>

                    <p class="product-description">{{ $chain['description'] }}</p>

                    <!-- Substance Pills -->
                    <div class="product-substances-list">
                        <div class="product-substances-title">Key Substances Screened:</div>
                        <div class="substance-tags">
                            @foreach(array_slice($chain['substances'], 0, 4) as $sub)
                                <span class="substance-tag">{{ $sub }}</span>
                            @endforeach
                            @if(count($chain['substances']) > 4)
                                <span class="substance-tag" style="background:#E2E8F0; font-weight:700;">+{{ count($chain['substances']) - 4 }} More</span>
                            @endif
                        </div>
                    </div>

                    <div class="product-footer-meta" style="margin-top:auto; margin-bottom:16px;">
                        <span>⏱ {{ $chain['turnaround'] }}</span>
                        <span>📍 Quest &amp; Labcorp</span>
                    </div>

                    <div style="display:flex; flex-direction:column; gap:8px;">
                        <a href="{{ rtrim(url('/services/' . $slug), '/') . '/' }}" class="btn btn-navy" style="width:100%; font-size:13.5px; padding:11px 16px;">
                            Browse State &amp; City Centers &rarr;
                        </a>
                        <a href="{{ route('checkout.index', ['slug' => $chain['product_slug']]) }}" class="btn btn-primary" style="width:100%; font-size:13.5px; padding:10px 16px;">
                            Order Donor Pass Online
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<!-- Panel Detection Matrix Comparison -->
<section class="section section-white" id="comparison-section" aria-labelledby="compTableTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">PANEL BREAKDOWN</span>
            <h2 class="section-title" id="compTableTitle">Side-by-Side Substance Detection Matrix</h2>
            <p class="section-desc">Quick reference table showing which drugs are screened in each standard panel level:</p>
        </div>

        <div class="clinical-table-wrapper">
            <table class="clinical-spec-table">
                <thead>
                    <tr>
                        <th style="width: 32%;">Drug / Substance Class</th>
                        <th style="width: 20%;">Clinical Class</th>
                        <th style="width: 16%; text-align:center;">5-Panel ($89.99)</th>
                        <th style="width: 16%; text-align:center;">10-Panel ($109.99)</th>
                        <th style="width: 16%; text-align:center;">12-Panel ($139.99)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td data-label="Drug / Substance Class"><strong>Marijuana (THC)</strong></td>
                        <td data-label="Clinical Class">Cannabinoid</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="5-Panel ($89.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="10-Panel ($109.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="12-Panel ($139.99)">✓ Yes</td>
                    </tr>
                    <tr>
                        <td data-label="Drug / Substance Class"><strong>Cocaine (COC)</strong></td>
                        <td data-label="Clinical Class">Stimulant</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="5-Panel ($89.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="10-Panel ($109.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="12-Panel ($139.99)">✓ Yes</td>
                    </tr>
                    <tr>
                        <td data-label="Drug / Substance Class"><strong>Opiates (Codeine, Morphine, Heroin)</strong></td>
                        <td data-label="Clinical Class">Opioid Narcotic</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="5-Panel ($89.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="10-Panel ($109.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="12-Panel ($139.99)">✓ Yes</td>
                    </tr>
                    <tr>
                        <td data-label="Drug / Substance Class"><strong>Amphetamines &amp; Methamphetamines</strong></td>
                        <td data-label="Clinical Class">Stimulant</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="5-Panel ($89.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="10-Panel ($109.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="12-Panel ($139.99)">✓ Yes</td>
                    </tr>
                    <tr>
                        <td data-label="Drug / Substance Class"><strong>Phencyclidine (PCP)</strong></td>
                        <td data-label="Clinical Class">Hallucinogen</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="5-Panel ($89.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="10-Panel ($109.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="12-Panel ($139.99)">✓ Yes</td>
                    </tr>
                    <tr>
                        <td data-label="Drug / Substance Class"><strong>Benzodiazepines (Xanax, Valium)</strong></td>
                        <td data-label="Clinical Class">Depressant</td>
                        <td style="text-align:center; color:#94A3B8;" data-label="5-Panel ($89.99)">&mdash;</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="10-Panel ($109.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="12-Panel ($139.99)">✓ Yes</td>
                    </tr>
                    <tr>
                        <td data-label="Drug / Substance Class"><strong>Barbiturates</strong></td>
                        <td data-label="Clinical Class">Sedative</td>
                        <td style="text-align:center; color:#94A3B8;" data-label="5-Panel ($89.99)">&mdash;</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="10-Panel ($109.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="12-Panel ($139.99)">✓ Yes</td>
                    </tr>
                    <tr>
                        <td data-label="Drug / Substance Class"><strong>Methadone</strong></td>
                        <td data-label="Clinical Class">Synthetic Opioid</td>
                        <td style="text-align:center; color:#94A3B8;" data-label="5-Panel ($89.99)">&mdash;</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="10-Panel ($109.99)">✓ Yes</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="12-Panel ($139.99)">✓ Yes</td>
                    </tr>
                    <tr>
                        <td data-label="Drug / Substance Class"><strong>Expanded Opioids (Oxycodone, Hydrocodone)</strong></td>
                        <td data-label="Clinical Class">Semi-Synthetic</td>
                        <td style="text-align:center; color:#94A3B8;" data-label="5-Panel ($89.99)">&mdash;</td>
                        <td style="text-align:center; color:#94A3B8;" data-label="10-Panel ($109.99)">&mdash;</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="12-Panel ($139.99)">✓ Yes</td>
                    </tr>
                    <tr>
                        <td data-label="Drug / Substance Class"><strong>Buprenorphine (Suboxone)</strong></td>
                        <td data-label="Clinical Class">Opioid Partial</td>
                        <td style="text-align:center; color:#94A3B8;" data-label="5-Panel ($89.99)">&mdash;</td>
                        <td style="text-align:center; color:#94A3B8;" data-label="10-Panel ($109.99)">&mdash;</td>
                        <td style="text-align:center; color:#15803D; font-weight:bold;" data-label="12-Panel ($139.99)">✓ Yes</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- 50-State Nationwide Directory Grid Section -->
<section class="section section-light" id="states-directory" aria-labelledby="statesSectionTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">50 STATES COVERAGE</span>
            <h2 class="section-title" id="statesSectionTitle">Find Certified Drug Testing Centers by State</h2>
            <p class="section-desc">Select your state to locate nearest Quest Diagnostics and Labcorp partner collection facilities:</p>
        </div>

        <!-- Filter Search Bar -->
        <div class="state-search-bar" style="margin-bottom: 24px; position:relative;">
            <div style="position:relative;">
                <svg style="position:absolute; left:16px; top:50%; transform:translateY(-50%); color:#94A3B8;" width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" id="stateFilterInput" class="zip-input" placeholder="Filter states by name (e.g. Florida, Texas, California, New York)..." style="padding-left:46px; width:100%; background:#fff;">
            </div>
        </div>

        <div class="states-grid-enhanced" id="servicesStatesGrid">
            @foreach($states as $st)
                <a href="{{ rtrim(url('/services/5-panel-drug-test/' . $st->slug), '/') . '/' }}" class="state-card-v2" data-state="{{ strtolower($st->name) }}">
                    <div class="state-card-v2-left">
                        <div class="state-abbr-badge">{{ $st->abbr }}</div>
                        <div class="state-card-v2-info">
                            <span class="state-card-v2-name">{{ $st->name }}</span>
                            <span class="state-card-v2-cities">View Centers</span>
                        </div>
                    </div>
                    <span class="state-card-v2-arrow">&rarr;</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Filter Script & Estimator Logic -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Category Filter Tabs
    const filterTabs = document.querySelectorAll('.filter-tab-btn');
    const productCards = document.querySelectorAll('.products-grid .product-card');

    filterTabs.forEach(btn => {
        btn.addEventListener('click', function () {
            filterTabs.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.getAttribute('data-filter');
            productCards.forEach(card => {
                const cat = card.getAttribute('data-category');
                if (filter === 'all' || cat === filter) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // 2. State Live Search Filter
    const stateInput = document.getElementById('stateFilterInput');
    const stateGrid = document.getElementById('servicesStatesGrid');
    if (stateInput && stateGrid) {
        const cards = stateGrid.querySelectorAll('.state-card-v2');
        stateInput.addEventListener('input', function () {
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

// Interactive Estimator Functions
function handleEstimatorMethodChange(method) {
    const specimen = document.getElementById('estSpecimen');
    if (!specimen) return;

    if (method === 'hair') {
        specimen.value = 'hair-follicle-5-panel';
    } else if (method === 'alcohol') {
        specimen.value = 'dot-breath-alcohol';
    } else if (method === 'dot') {
        specimen.value = '5-panel-dot';
    } else {
        specimen.value = '5-panel-nondot';
    }
    updateEstimatorDisplay();
}

function updateEstimatorDisplay() {
    const select = document.getElementById('estSpecimen');
    const opt = select.options[select.selectedIndex];
    const name = opt.getAttribute('data-name');
    const price = opt.getAttribute('data-price');

    document.getElementById('estPanelName').textContent = name;
    document.getElementById('estPriceVal').textContent = '$' + price;
}

function handleEstimatorOrder() {
    const select = document.getElementById('estSpecimen');
    const slug = select.value;
    window.location.href = '/checkout/' + slug;
}
</script>
@endsection
