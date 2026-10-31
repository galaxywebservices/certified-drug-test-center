<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Certified Drug Test Centers | Nationwide Drug & Alcohol Testing' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Certified Drug Test Centers provides fast, confidential same-day drug testing, DOT compliance, urine, hair, alcohol, and DNA testing at 20,000+ certified local centers nationwide.' }}">
    <meta name="keywords" content="drug testing, drug test near me, DOT drug test, urine drug test, 5 panel drug test, 10 panel drug test, 12 panel drug test, hair follicle drug test, breath alcohol test, accredited drug testing, Quest Diagnostics drug test, Labcorp drug test">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $pageTitle ?? 'Certified Drug Test Centers' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Same-day drug & alcohol testing at 20,000+ local certified collection centers nationwide.' }}">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:site_name" content="Certified Drug Test Centers">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle ?? 'Certified Drug Test Centers' }}">
    <meta name="twitter:description" content="{{ $metaDescription ?? 'Same-day drug & alcohol testing at 20,000+ local certified collection centers nationwide.' }}">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <!-- Google Fonts: Montserrat (American authoritative headlines) & Inter (ultra-readable body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Montserrat:wght@600;700;800;900&display=swap" rel="stylesheet">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ time() }}">

    <!-- Structured Data (JSON-LD) for 100% SEO Dominance -->
    <!-- Structured Data (JSON-LD) for 100% SEO Dominance -->
    @php
        $faqEntities = [];
        if (isset($faqs) && count($faqs)) {
            foreach ($faqs as $f) {
                $faqEntities[] = [
                    '@type' => 'Question',
                    'name' => $f['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $f['answer'],
                    ],
                ];
            }
        }

        $schemaGraph = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'MedicalBusiness',
                    '@id' => url('/') . '#organization',
                    'name' => 'Certified Drug Test Centers',
                    'url' => url('/'),
                    'logo' => asset('images/logo.png'),
                    'image' => asset('images/logo.png'),
                    'telephone' => '+1-800-985-4339',
                    'priceRange' => '$$',
                    'currenciesAccepted' => 'USD',
                    'paymentAccepted' => 'Credit Card, Paytrace, Debit Card',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'streetAddress' => 'National Scheduling Operations Center',
                        'addressCountry' => 'US',
                    ],
                    'areaServed' => [
                        '@type' => 'Country',
                        'name' => 'United States',
                    ],
                    'description' => 'Nationwide provider of employer, DOT-regulated, court-ordered, and personal drug and alcohol testing services.',
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => url('/') . '#website',
                    'url' => url('/'),
                    'name' => 'Certified Drug Test Centers',
                    'publisher' => [
                        '@id' => url('/') . '#organization',
                    ],
                    'potentialAction' => [
                        '@type' => 'SearchAction',
                        'target' => url('/') . '?zip={search_term_string}',
                        'query-input' => 'required name=search_term_string',
                    ],
                ],
            ],
        ];

        if (count($faqEntities)) {
            $schemaGraph['@graph'][] = [
                '@type' => 'FAQPage',
                '@id' => url()->current() . '#faq',
                'mainEntity' => $faqEntities,
            ];
        }
    @endphp
    <script type="application/ld+json">
    {!! json_encode($schemaGraph, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

</head>
<body>


    <!-- Top Announcement Bar -->
    <div class="top-notice-bar">
        <div class="container top-notice-inner">
            <div class="top-notice-left">
                <span class="top-notice-tag">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    Same-Day Testing Available
                </span>
                <span>Over 20,000 Certified Quest & Labcorp Collection Sites Nationwide</span>
            </div>
            <div class="top-notice-right">
                <a href="{{ route('order.track') }}" style="color:#0B2545; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:4px; font-size:12.5px;">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Track Order / Donor Pass
                </a>
                <span>•</span>
                <a href="{{ route('reviews.index') }}" style="color:#0B2545; font-weight:700; text-decoration:none; display:inline-flex; align-items:center; gap:3px; font-size:12.5px;">
                    <span style="color:#F59E0B;">★</span> 4.9 Reviews (4.8k+)
                </a>
                <span>•</span>
                <span style="color:#C1121F; font-weight:700;">¡Hablamos Español!</span>
                <span>•</span>
                <a href="tel:18009854339" class="top-phone-link">
                    <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z"></path></svg>
                    Call: (800)-985-4339
                </a>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header class="main-header" role="banner">
        <div class="container header-inner">
            <a href="{{ url('/') }}" class="brand-logo-link" title="Certified Drug Test Centers Home">
                <img src="{{ asset('images/logo.png') }}" alt="Certified Drug Test Centers - Local Convenient Confidential" class="brand-logo-img">
            </a>

            <div class="header-contact-callout">
                <button type="button" class="header-search-btn" onclick="openGlobalSearch()" aria-label="Search tests, drugs, or panels">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Search Tests & Substances</span>
                    <kbd class="search-kbd">⌘K</kbd>
                </button>
                <div class="header-hours">
                    <strong>Online Scheduling: 24/7</strong>
                    Phone Assistance: Mon-Fri 7AM - 8PM EST
                </div>
                <div class="header-phone-box">
                    <span class="header-phone-label">Toll Free Scheduling</span>
                    <a href="tel:18009854339" class="header-phone-number">(800)-985-4339</a>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary">
                    Schedule A Test
                </a>
            </div>
        </div>
    </header>

    <!-- Primary Navigation Bar -->
    <nav class="primary-nav-bar" role="navigation" aria-label="Main Navigation">
        <div class="container nav-inner">
            <button class="mobile-nav-toggle" id="mobileNavToggle" aria-label="Toggle Navigation Menu" aria-expanded="false">
                <svg class="hamburger-icon" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <line x1="3" y1="6" x2="21" y2="6" stroke-linecap="round" class="line-top"></line>
                    <line x1="3" y1="12" x2="21" y2="12" stroke-linecap="round" class="line-mid"></line>
                    <line x1="3" y1="18" x2="21" y2="18" stroke-linecap="round" class="line-bot"></line>
                </svg>
            </button>
            <ul class="nav-menu" id="navMenu">
                <li class="nav-item has-dropdown">
                    <a href="{{ url('/category/urine') }}" class="nav-link">
                        <span>Urine Drug Tests</span>
                        <svg class="nav-chevron" width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path></svg>
                    </a>
                    <ul class="nav-dropdown">
                        <li><a href="{{ url('/product/5-panel-nondot') }}" class="nav-dropdown-link">5 Panel NON-DOT ($89.99)</a></li>
                        <li><a href="{{ url('/product/5-panel-exp-opiates') }}" class="nav-dropdown-link">5 Panel + Exp Opiates ($99.99)</a></li>
                        <li><a href="{{ url('/product/10-panel') }}" class="nav-dropdown-link">10 Panel Drug Test ($109.99)</a></li>
                        <li><a href="{{ url('/product/10-panel-exp-opiates') }}" class="nav-dropdown-link">10 Panel + Exp Opiates ($119.99)</a></li>
                        <li><a href="{{ url('/product/12-panel-comprehensive') }}" class="nav-dropdown-link">12 Panel Comprehensive ($139.99)</a></li>
                        <li><a href="{{ url('/category/urine') }}" class="nav-dropdown-link nav-dropdown-viewall">View All Urine Tests &rarr;</a></li>
                    </ul>
                </li>
                <li class="nav-item has-dropdown">
                    <a href="{{ url('/category/dot') }}" class="nav-link">
                        <span>DOT Testing</span>
                        <svg class="nav-chevron" width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path></svg>
                    </a>
                    <ul class="nav-dropdown">
                        <li><a href="{{ url('/product/5-panel-dot') }}" class="nav-dropdown-link">5 Panel DOT Drug Screen ($99.99)</a></li>
                        <li><a href="{{ url('/product/dot-breath-alcohol') }}" class="nav-dropdown-link">DOT Breath Alcohol Test ($89.99)</a></li>
                        <li><a href="{{ url('/product/dot-physical') }}" class="nav-dropdown-link">DOT Physical Exam ($159.99)</a></li>
                        <li><a href="{{ url('/product/1-year-consortium-membership-dot-drug-test') }}" class="nav-dropdown-link">DOT Random Consortium ($99.99)</a></li>
                        <li><a href="{{ url('/product/5-panel-return-to-duty') }}" class="nav-dropdown-link">FMCSA Return to Duty (RTD)</a></li>
                        <li><a href="{{ url('/category/dot') }}" class="nav-dropdown-link nav-dropdown-viewall">View All DOT Services &rarr;</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/category/hair') }}" class="nav-link">
                        Hair Follicle
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/category/alcohol') }}" class="nav-link">
                        Alcohol & EtG
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/category/occupational-health') }}" class="nav-link">
                        Occupational Health
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/category/on-site-mobile') }}" class="nav-link">
                        Mobile Testing
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('locations.index') }}" class="nav-link">
                        Locations
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('test-finder.index') }}" class="nav-link" style="color:#0284C7; font-weight:700;">
                        ✨ Find My Test
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employers.index') }}" class="nav-link" style="color:#C1121F; font-weight:700;">
                        Employers
                    </a>
                </li>
                <li class="nav-item nav-item-contact">
                    <a href="{{ url('/contact-us') }}" class="nav-link">
                        Contact Us
                    </a>
                </li>
                <li class="mobile-nav-footer">
                    <a href="tel:18009854339" class="mobile-nav-call-btn">
                        <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z"></path></svg>
                        <span>Toll-Free: (800)-985-4339</span>
                    </a>
                    <div class="mobile-nav-sublinks">
                        <a href="{{ route('order.track') }}">Track Order / Pass</a>
                        <span>•</span>
                        <a href="{{ route('locations.index') }}">Find Nearby Labs</a>
                        <span>•</span>
                        <a href="{{ url('/contact-us') }}">Support</a>
                    </div>
                </li>
            </ul>

            <div class="nav-actions">
                <button type="button" class="nav-loc-btn" onclick="openZipModal()" aria-label="Find collection centers near you">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Find Lab by ZIP</span>
                </button>

                <a href="{{ route('checkout.index') }}" class="nav-cta-btn">
                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <span>Order Test Online</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main role="main">
        @yield('content')
    </main>

    <!-- Accreditation & Partner Bar -->
    <section class="partner-logo-bar" aria-label="Accreditation & Certified Laboratory Network">
        <div class="container" style="text-align:center;">
            <p class="partner-logo-heading">
                Certified National Specimen Collection &amp; SAMHSA Accredited Laboratory Network
            </p>
            <div class="partner-credbar-wrap">
                <img src="{{ asset('images/credbar.jpg') }}" 
                     alt="Accredited Laboratory & Network Partners: Quest Diagnostics, LabCorp, NDASA, DATIA, Alere, SAPAA, i3screen" 
                     class="partner-credbar-img" 
                     width="1413"
                     height="162"
                     loading="lazy">
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer" role="contentinfo">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col">
                    <img src="{{ asset('images/logo.png') }}" alt="Certified Drug Test Centers" style="max-height:64px; margin-bottom:16px;">
                    <p style="margin-bottom:16px; line-height:1.6; color:#CBD5E1;">
                        Certified Drug Test Centers is a premier nationwide provider of drug, alcohol, DNA, and occupational health testing. Partnering with SAMHSA-certified laboratories and over 20,000 collection facilities across all 50 states.
                    </p>
                    <div class="footer-contact-item">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z"></path></svg>
                        <span><strong>Phone:</strong> (800)-985-4339 (Toll Free)</span>
                    </div>
                    <div class="footer-contact-item">
                        <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                        <span><strong>Scheduling:</strong> 24 Hours / 7 Days Online</span>
                    </div>
                </div>

                <div class="footer-col">
                    <h4>Drug Testing Panels</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('test-finder.index') }}" style="color:#38BDF8; font-weight:700;">Guided Test Selector (Quiz)</a></li>
                        <li><a href="{{ url('/product/5-panel-nondot') }}">5 Panel NON-DOT Test</a></li>
                        <li><a href="{{ url('/product/5-panel-dot') }}">5 Panel DOT Mandated</a></li>
                        <li><a href="{{ url('/product/10-panel') }}">10 Panel Drug Screening</a></li>
                        <li><a href="{{ url('/product/12-panel-comprehensive') }}">12 Panel Comprehensive</a></li>
                        <li><a href="{{ url('/category/hair') }}">Hair Follicle Drug Test</a></li>
                        <li><a href="{{ url('/product/etg-alcohol') }}">EtG 80-Hour Alcohol Screen</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>DOT & Corporate</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('employers.index') }}" style="color:#F59E0B; font-weight:700;">Corporate Accounts &amp; Pricing</a></li>
                        <li><a href="{{ route('employers.portal') }}" style="color:#38BDF8; font-weight:700;">🏢 Employer Portal Login</a></li>
                        <li><a href="{{ route('reviews.index') }}" style="color:#34D399; font-weight:700;">Verified Customer Reviews (4.9★)</a></li>
                        <li><a href="{{ url('/category/dot') }}">FMCSA Drug & Alcohol Testing</a></li>
                        <li><a href="{{ url('/product/dot-physical') }}">DOT Physical Examination (NRCME)</a></li>
                        <li><a href="{{ url('/product/1-year-consortium-membership-dot-drug-test') }}">DOT Random Consortium Pool</a></li>
                        <li><a href="{{ url('/product/fmcsa-clearinghouse-accucheck') }}">FMCSA Clearinghouse Support</a></li>
                        <li><a href="{{ url('/category/on-site-mobile') }}">Mobile On-Site Testing</a></li>
                        <li><a href="{{ url('/background-checks') }}">Background Checks & MVR</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>National Headquarters</h4>
                    <p style="margin-bottom:12px; color:#CBD5E1;">
                        National Scheduling & Operations<br>
                        201 N. Park Ave.<br>
                        Sanford, FL 32771
                    </p>
                    <p style="color:#C1121F; font-weight:700; margin-bottom:16px;">
                        Over 20,000 Certified Testing Locations in All 50 States
                    </p>
                    <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-sm">
                        Schedule Test Today
                    </a>
                </div>
            </div>

            <div class="footer-bottom">
                <div>
                    © {{ date('Y') }} Certified Drug Test Centers. All Rights Reserved. Local, Convenient & Confidential.
                </div>
                <div style="display:flex; gap:16px; flex-wrap:wrap;">
                    <a href="{{ route('test-finder.index') }}" style="color:#CBD5E1; font-weight:700;">Find My Test</a>
                    <a href="{{ route('reviews.index') }}" style="color:#CBD5E1; font-weight:700;">Reviews</a>
                    <a href="{{ route('employers.index') }}" style="color:#CBD5E1; font-weight:700;">Employers &amp; Corporate</a>
                    <a href="{{ route('order.track') }}" style="color:#CBD5E1; font-weight:700;">Track Order &amp; Donor Pass</a>
                    <a href="{{ url('/privacy-policy') }}" style="color:#94A3B8;">Privacy Policy</a>
                    <a href="{{ url('/terms-and-conditions') }}" style="color:#94A3B8;">Terms of Service</a>
                    <a href="{{ route('locations.index') }}" style="color:#94A3B8;">Location Directory</a>
                    <a href="{{ url('/contact-us') }}" style="color:#94A3B8;">Contact Us</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ==========================================================================
         Accessible Native HTML5 Dialog: Donor Registration & Order Preview
         ========================================================================== -->
    <dialog id="orderModal" aria-labelledby="orderModalTitle">
        <div class="modal-header">
            <h2 class="modal-title" id="orderModalTitle">Schedule Your Drug Test</h2>
            <button type="button" class="modal-close-btn" onclick="closeOrderModal()" aria-label="Close dialog">×</button>
        </div>
        <div class="modal-body">
            <div style="background:var(--color-bg-subtle-blue); border-radius:var(--radius-sm); padding:14px; margin-bottom:18px;">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div>
                        <strong id="modalProductName" style="font-size:16px; color:var(--color-primary);">5 Panel NON-DOT Drug Test</strong><br>
                        <span style="font-size:12.5px; color:#16A34A; font-weight:600;">✓ Online Discount Applied • SAMHSA Certified Lab & MRO Included</span>
                    </div>
                    <div id="modalProductPrice" style="font-family:var(--font-heading); font-size:24px; font-weight:800; color:var(--color-accent-red);">
                        $89.99
                    </div>
                </div>
            </div>

            <form id="expressOrderForm" onsubmit="event.preventDefault(); alert('Registration details captured! Donor pass generated and sent to the email address.'); closeOrderModal();">
                <input type="hidden" id="modalInputTestName" name="test_name" value="5 Panel NON-DOT Drug Test">

                <div class="modal-form-group">
                    <label for="donorZip">Testing Zip Code (Closest Center Locator) *</label>
                    <input type="text" id="donorZip" name="donor_zip" placeholder="Enter 5-digit zip code" required maxlength="5">
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="modal-form-group">
                        <label for="donorFirstName">Donor First Name *</label>
                        <input type="text" id="donorFirstName" name="first_name" placeholder="John" required>
                    </div>
                    <div class="modal-form-group">
                        <label for="donorLastName">Donor Last Name *</label>
                        <input type="text" id="donorLastName" name="last_name" placeholder="Doe" required>
                    </div>
                </div>

                <div class="modal-form-group">
                    <label for="donorEmail">Email (To Receive Electronic Donor Pass) *</label>
                    <input type="email" id="donorEmail" name="email" placeholder="donor@example.com" required>
                </div>

                <div class="modal-form-group">
                    <label for="donorPhone">Phone Number (For SMS Pass & Status) *</label>
                    <input type="tel" id="donorPhone" name="phone" placeholder="(555) 000-0000" required>
                </div>

                <div class="modal-form-group">
                    <label for="testingReason">Reason for Testing *</label>
                    <select id="testingReason" name="reason" required>
                        <option value="pre-employment">Pre-Employment Screening</option>
                        <option value="dot">DOT Regulated Mandate</option>
                        <option value="court">Court Ordered / Legal / Probation</option>
                        <option value="personal">Personal / Family Testing</option>
                        <option value="post-accident">Post-Accident / Reasonable Suspicion</option>
                    </select>
                </div>

                <p style="font-size:12px; color:var(--color-text-muted); margin-bottom:16px;">
                    🔒 <strong>Secure Electronic Registration:</strong> Testing centers do not accept payments directly on-site. Once completed, your electronic donor registration pass is immediately generated with local collection site address and barcoded order slip.
                </p>

                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" class="btn btn-outline-navy btn-sm" onclick="closeOrderModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        Proceed to Express Donor Registration →
                    </button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- ==========================================================================
         Accessible Native HTML5 Dialog: Mobile On-Site Testing Quote
         ========================================================================== -->
    <dialog id="mobileQuoteModal" aria-labelledby="mobileModalTitle">
        <div class="modal-header">
            <h2 class="modal-title" id="mobileModalTitle">Request Mobile On-Site Testing</h2>
            <button type="button" class="modal-close-btn" onclick="closeMobileQuoteModal()" aria-label="Close dialog">×</button>
        </div>
        <div class="modal-body">
            <p style="font-size:13.5px; color:var(--color-text-muted); margin-bottom:16px;">
                Our certified collection specialists travel to your workplace, construction site, or warehouse. Minimal downtime, 100% compliant.
            </p>

            <form onsubmit="event.preventDefault(); alert('Mobile testing request received! A corporate coordinator will contact you within 15 minutes.'); closeMobileQuoteModal();">
                <div class="modal-form-group">
                    <label for="mobCompany">Company Name *</label>
                    <input type="text" id="mobCompany" required placeholder="ABC Logistics LLC">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="modal-form-group">
                        <label for="mobName">Contact Person *</label>
                        <input type="text" id="mobName" required placeholder="Jane Smith">
                    </div>
                    <div class="modal-form-group">
                        <label for="mobPhone">Phone Number *</label>
                        <input type="tel" id="mobPhone" required placeholder="(800)-985-4339">
                    </div>
                </div>
                <div class="modal-form-group">
                    <label for="mobEmail">Email Address *</label>
                    <input type="email" id="mobEmail" required placeholder="safety@abclogistics.com">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="modal-form-group">
                        <label for="mobLocation">City & State (or ZIP) *</label>
                        <input type="text" id="mobLocation" required placeholder="Dallas, TX">
                    </div>
                    <div class="modal-form-group">
                        <label for="mobPeople">Estimated Donors to Test *</label>
                        <select id="mobPeople" required>
                            <option value="1-5">1 - 5 Employees</option>
                            <option value="6-15">6 - 15 Employees</option>
                            <option value="16-50">16 - 50 Employees</option>
                            <option value="50+">50+ Employees</option>
                        </select>
                    </div>
                </div>
                <div class="modal-form-group">
                    <label for="mobNotes">Testing Requirements / Date Requested</label>
                    <textarea id="mobNotes" rows="3" placeholder="Specify if DOT or Non-DOT, preferred date and time..."></textarea>
                </div>
                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" class="btn btn-outline-navy btn-sm" onclick="closeMobileQuoteModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Request</button>
                </div>
            </form>
        </div>
    </dialog>

    <!-- ==========================================================================
         Accessible Native HTML5 Dialog: Global Test & Substance Search Modal (Cmd+K)
         ========================================================================== -->
    <dialog id="globalSearchModal" class="search-dialog" aria-labelledby="globalSearchTitle">
        <div class="search-modal-header">
            <div class="search-input-wrap">
                <svg class="search-input-icon" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" id="globalSearchInput" placeholder="Search test name, substance (e.g., THC, Fentanyl, 10-Panel), or specimen..." aria-label="Search drug tests and substances" autocomplete="off">
                <kbd class="search-kbd" style="font-size:11px;">ESC</kbd>
                <button type="button" class="modal-close-btn" onclick="closeGlobalSearch()" aria-label="Close search">×</button>
            </div>
        </div>
        <div class="search-modal-body">
            <div class="search-quick-tags">
                <span class="search-quick-label">Popular Searches:</span>
                <button type="button" class="search-pill" onclick="searchTag('5-Panel')">5-Panel</button>
                <button type="button" class="search-pill" onclick="searchTag('10-Panel')">10-Panel</button>
                <button type="button" class="search-pill" onclick="searchTag('12-Panel')">12-Panel</button>
                <button type="button" class="search-pill" onclick="searchTag('DOT')">DOT Compliant</button>
                <button type="button" class="search-pill" onclick="searchTag('Hair Follicle')">Hair Follicle</button>
                <button type="button" class="search-pill" onclick="searchTag('Fentanyl')">Fentanyl</button>
                <button type="button" class="search-pill" onclick="searchTag('Alcohol')">Alcohol / EtG</button>
            </div>

            <div id="globalSearchResults" class="search-results-list">
                <!-- Dynamically populated via site.js -->
                <div class="search-empty-state">
                    Type a drug panel, substance, or test type above to see instant results.
                </div>
            </div>
        </div>
    </dialog>

    <!-- ==========================================================================
         Accessible Native HTML5 Dialog: Fast ZIP Collection Site Finder Modal
         ========================================================================== -->
    <dialog id="globalZipModal" class="zip-dialog" aria-labelledby="globalZipTitle">
        <div class="modal-header">
            <div>
                <h2 class="modal-title" id="globalZipTitle" style="font-size:18px;">Find Certified Collection Centers Near You</h2>
                <div style="font-size:12.5px; color:#64748B; margin-top:2px;">Over 20,000 Quest & Labcorp sites nationwide • Same-day walk-ins welcome</div>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeZipModal()" aria-label="Close dialog">×</button>
        </div>
        <div class="modal-body" style="padding:20px;">
            <form onsubmit="event.preventDefault(); lookupZipModal();">
                <div style="display:flex; gap:8px;">
                    <input type="text" id="modalZipInput" pattern="[0-9]{5}" maxlength="5" placeholder="Enter 5-digit ZIP (e.g. 85296, 75001, 30301)" required style="flex-grow:1; padding:10px 14px; border:1px solid #CBD5E1; border-radius:6px; font-size:15px; font-weight:600; outline:none;">
                    <button type="submit" class="btn btn-primary" style="padding:10px 18px; font-weight:700;">Find Labs</button>
                </div>
            </form>

            <div id="modalZipResultsList" class="global-zip-results">
                <!-- Initial suggestions / results -->
                <div style="text-align:center; padding:20px; color:#64748B; font-size:13.5px;">
                    Enter your ZIP code to view certified collection sites with hours of operation and instant registration.
                </div>
            </div>

            <div style="margin-top:16px; padding-top:14px; border-top:1px solid #E2E8F0; display:flex; justify-content:space-between; align-items:center;">
                <a href="{{ route('locations.index') }}" style="font-size:13px; color:#0B2545; font-weight:700; text-decoration:none;">
                    &larr; Browse All States & Cities Directory
                </a>
                <a href="tel:18009854339" style="font-size:13px; color:#C1121F; font-weight:700; text-decoration:none;">
                    Need Help? Call (800)-985-4339
                </a>
            </div>
        </div>
    </dialog>

    <!-- Client-side Interactive Script -->
    <script src="{{ asset('js/site.js') }}?v={{ time() }}"></script>
</body>
</html>
