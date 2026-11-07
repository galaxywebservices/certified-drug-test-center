<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'Certified Drug Test Centers | Nationwide Drug & Alcohol Testing' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Certified Drug Test Centers provides fast, confidential same-day drug testing, DOT compliance, urine, hair, alcohol, and DNA testing at 20,000+ certified local centers nationwide.' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'drug testing, drug test near me, DOT drug test, urine drug test, 5 panel drug test, 10 panel drug test, 12 panel drug test, hair follicle drug test, breath alcohol test, accredited drug testing, Quest Diagnostics drug test, Labcorp drug test' }}">
    @php
        $canonicalUrl = $canonicalUrl ?? (str_starts_with(request()->getPathInfo(), '/services') ? url(rtrim(request()->getPathInfo(), '/')) : url()->current());
    @endphp
    <link rel="canonical" href="{{ $canonicalUrl }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $canonicalUrl }}">
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

    <!-- Tailwind CSS (Vite Compiled Utilities) -->
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css'])
    @endif

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/site.css') }}?v={{ time() }}">

    <style>
        /* Header Trust Badges & Alignment */
        .header-inner {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            gap: 16px !important;
        }
        .header-brand-wrap {
            display: flex !important;
            align-items: center !important;
            gap: 16px !important;
            flex-wrap: nowrap !important;
            flex-shrink: 0 !important;
        }
        .header-trust-badges {
            display: inline-flex !important;
            align-items: center !important;
            gap: 10px !important;
            background: #F8FAFC !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 999px !important;
            padding: 7px 16px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #0B2545 !important;
            box-shadow: 0 1px 4px rgba(11,37,69,0.05) !important;
            white-space: nowrap !important;
            flex-shrink: 0 !important;
            transition: all 0.2s ease !important;
        }
        .header-trust-badges:hover {
            border-color: #CBD5E1 !important;
            box-shadow: 0 2px 8px rgba(11,37,69,0.08) !important;
        }
        .header-review-link {
            color: #0B2545 !important;
            text-decoration: none !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            font-weight: 700 !important;
        }
        .header-review-link:hover {
            color: #C1121F !important;
        }
        .header-espanol-tag {
            color: #0284C7 !important;
            font-weight: 700 !important;
            font-size: 12.5px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
        }
        @media (max-width: 992px) {
            .header-trust-badges {
                display: none !important;
            }
        }

        /* Accreditation & Partner Network Bar */
        .partner-logo-bar {
            background: #F8FAFC !important;
            border-top: 1px solid #E2E8F0 !important;
            border-bottom: 1px solid #E2E8F0 !important;
            padding: 34px 0 !important;
        }
        .partner-logo-heading {
            font-size: 11.5px !important;
            font-weight: 800 !important;
            letter-spacing: 1.5px !important;
            text-transform: uppercase !important;
            color: #64748B !important;
            margin: 0 0 18px 0 !important;
            text-align: center !important;
        }
        .partner-network-flex {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 14px !important;
            flex-wrap: wrap !important;
        }
        .partner-network-hero-pill {
            display: inline-flex !important;
            align-items: center !important;
            gap: 10px !important;
            background: #0B2545 !important;
            color: #FFFFFF !important;
            padding: 10px 22px !important;
            border-radius: 999px !important;
            font-size: 13.5px !important;
            font-weight: 800 !important;
            letter-spacing: 0.2px !important;
            box-shadow: 0 3px 10px rgba(11,37,69,0.15) !important;
            border: 1px solid rgba(255,255,255,0.15) !important;
            white-space: nowrap !important;
        }
        .partner-org-pills {
            display: inline-flex !important;
            align-items: center !important;
            gap: 12px !important;
            flex-wrap: wrap !important;
            justify-content: center !important;
        }
        .partner-badge-item {
            display: inline-flex !important;
            align-items: center !important;
            background: #FFFFFF !important;
            border: 1px solid #CBD5E1 !important;
            border-radius: 8px !important;
            padding: 7px 16px !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;
            transition: all 0.2s ease !important;
            white-space: nowrap !important;
        }
        .partner-badge-item:hover {
            transform: translateY(-2px) !important;
            border-color: #0B2545 !important;
            box-shadow: 0 4px 12px rgba(11,37,69,0.08) !important;
        }
        .partner-badge-name {
            font-weight: 900 !important;
            color: #0B2545 !important;
            font-size: 13px !important;
            letter-spacing: 0.5px !important;
        }
        .partner-badge-divider {
            color: #CBD5E1 !important;
            margin: 0 8px !important;
            font-weight: 300 !important;
        }
        .partner-badge-sub {
            font-size: 11px !important;
            font-weight: 700 !important;
            color: #64748B !important;
            letter-spacing: 0.5px !important;
        }
    </style>

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


    <!-- Main Header -->
    <header class="main-header" role="banner">
        <div class="container header-inner">
            <div class="header-brand-wrap">
                <a href="{{ url('/') }}" class="brand-logo-link" title="Certified Drug Test Centers Home">
                    <img src="{{ asset('images/logo.png') }}" alt="Certified Drug Test Centers - Local Convenient Confidential" class="brand-logo-img">
                </a>
                <div class="header-trust-badges">
                    <a href="{{ route('reviews.index') }}" class="header-review-link" title="Verified Customer Reviews">
                        <span style="color:#F59E0B; font-weight:800;">★ 4.9</span> Reviews (4.8k+)
                    </a>
                    <span class="header-badge-sep">•</span>
                    <span class="header-espanol-tag">¡Hablamos Español!</span>
                </div>
            </div>

            <div class="header-contact-callout">
                <div class="header-hours">
                    <strong>Online Scheduling: 24/7</strong>
                    <span>M-F 8am - 8pm EST &bull; SAT 9am - 5pm</span>
                </div>
                <div class="header-phone-box">
                    <a href="tel:18009854339" class="header-phone-number">(800)-985-4339</a>
                </div>
                <a href="{{ route('checkout.index') }}" class="btn btn-primary">
                    Schedule A Test
                </a>
            </div>
        </div>
    </header>

    <!-- Primary Navigation Bar (Toolbar) -->
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
                    <a href="{{ url('/services') }}" class="nav-link" style="color: #FEF08A; font-weight: 700;">
                        <span>Services</span>
                        <svg class="nav-chevron" width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"></path></svg>
                    </a>
                    <ul class="nav-dropdown">
                        <li><a href="{{ url('/services/5-panel-drug-test') }}" class="nav-dropdown-link font-semibold">5-Panel Urine Drug Test</a></li>
                        <!-- <li><a href="{{ url('/services/10-panel-drug-test/') }}" class="nav-dropdown-link">10-Panel Drug Test</a></li>
                        <li><a href="{{ url('/services/12-panel-drug-test/') }}" class="nav-dropdown-link">12-Panel Comprehensive</a></li>
                        <li><a href="{{ url('/services/dot-drug-test/') }}" class="nav-dropdown-link">DOT Drug Test &amp; Physical</a></li>
                        <li><a href="{{ url('/services/hair-follicle-drug-test/') }}" class="nav-dropdown-link">Hair Follicle Drug Test</a></li>
                        <li><a href="{{ url('/services/breath-alcohol-test/') }}" class="nav-dropdown-link">Breath Alcohol Test</a></li>
                        <li><a href="{{ url('/services/instant-drug-test/') }}" class="nav-dropdown-link">Rapid / Instant Test</a></li>
                        <li><a href="{{ url('/services/court-ordered-drug-test/') }}" class="nav-dropdown-link">Court-Ordered Drug Test</a></li>
                        <li><a href="{{ url('/services/random-drug-testing/') }}" class="nav-dropdown-link">Random Testing &amp; Consortium</a></li>
                        <li><a href="{{ url('/services/') }}" class="nav-dropdown-link nav-dropdown-viewall">All Testing Services Directory &rarr;</a></li> -->
                    </ul>
                </li>
                <li class="nav-item has-dropdown">
                    <a href="{{ url('/category/urine') }}" class="nav-link">
                        <span>Urine Tests</span>
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
                        <span>DOT Tests/Services</span>
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
                        Hair Tests
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/category/alcohol') }}" class="nav-link">
                        Alcohol/EtG Tests
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/category/oral-fluid-testing') }}" class="nav-link">
                        Oral Fluid Tests
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/category/occupational-health') }}" class="nav-link">
                        Occupational Tests
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/category/labblood-testing') }}" class="nav-link">
                        Clinical Tests
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/category/dna-testing') }}" class="nav-link">
                        DNA Tests
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('employers.index') }}" class="nav-link" style="color:#F59E0B; font-weight:700;">
                        EMPLOYER SERVICES
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/category/on-site-mobile') }}" class="nav-link">
                        MOBILE TESTING
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('locations.index') }}" class="nav-link">
                        LOCATIONS
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
    <section class="partner-logo-bar" aria-label="Accreditation &amp; Certified Laboratory Network" style="background:#F8FAFC; border-top:1px solid #E2E8F0; border-bottom:1px solid #E2E8F0; padding:34px 0;">
        <div class="container" style="text-align:center;">
            <p class="partner-logo-heading" style="font-size:11.5px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase; color:#64748B; margin:0 0 18px 0; text-align:center;">
                Certified National Specimen Collection &amp; SAMHSA Accredited Laboratory Network
            </p>
            <div class="partner-network-flex" style="display:flex; align-items:center; justify-content:center; gap:14px; flex-wrap:wrap;">
                <div class="partner-network-hero-pill" style="display:inline-flex; align-items:center; gap:10px; background:#0B2545; color:#FFFFFF; padding:10px 22px; border-radius:999px; font-size:13.5px; font-weight:800; letter-spacing:0.2px; box-shadow:0 3px 10px rgba(11,37,69,0.15); border:1px solid rgba(255,255,255,0.15); white-space:nowrap;">
                    <svg width="18" height="18" viewBox="0 0 20 20" fill="currentColor" style="color:#22C55E; flex-shrink:0;"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span>Quest &amp; Labcorp National Scheduling Network</span>
                </div>
                <div class="partner-org-pills" style="display:inline-flex; align-items:center; gap:12px; flex-wrap:wrap; justify-content:center;">
                    <div class="partner-badge-item" title="National Drug &amp; Alcohol Screening Association" style="display:inline-flex; align-items:center; background:#FFFFFF; border:1px solid #CBD5E1; border-radius:8px; padding:7px 16px; box-shadow:0 1px 3px rgba(0,0,0,0.04); white-space:nowrap;">
                        <span class="partner-badge-name" style="font-weight:900; color:#0B2545; font-size:13px; letter-spacing:0.5px;">NDASA</span>
                        <span class="partner-badge-divider" style="color:#CBD5E1; margin:0 8px; font-weight:300;">|</span>
                        <span class="partner-badge-sub" style="font-size:11px; font-weight:700; color:#64748B; letter-spacing:0.5px;">MEMBER</span>
                    </div>
                    <div class="partner-badge-item" title="Alere Toxicology Laboratory Network" style="display:inline-flex; align-items:center; background:#FFFFFF; border:1px solid #CBD5E1; border-radius:8px; padding:7px 16px; box-shadow:0 1px 3px rgba(0,0,0,0.04); white-space:nowrap;">
                        <span class="partner-badge-name" style="font-weight:900; color:#0B2545; font-size:13px; letter-spacing:0.5px;">ALERE</span>
                        <span class="partner-badge-divider" style="color:#CBD5E1; margin:0 8px; font-weight:300;">|</span>
                        <span class="partner-badge-sub" style="font-size:11px; font-weight:700; color:#64748B; letter-spacing:0.5px;">TOXICOLOGY</span>
                    </div>
                    <div class="partner-badge-item" title="Substance Abuse Program Administrators Association" style="display:inline-flex; align-items:center; background:#FFFFFF; border:1px solid #CBD5E1; border-radius:8px; padding:7px 16px; box-shadow:0 1px 3px rgba(0,0,0,0.04); white-space:nowrap;">
                        <span class="partner-badge-name" style="font-weight:900; color:#0B2545; font-size:13px; letter-spacing:0.5px;">SAPAA</span>
                        <span class="partner-badge-divider" style="color:#CBD5E1; margin:0 8px; font-weight:300;">|</span>
                        <span class="partner-badge-sub" style="font-size:11px; font-weight:700; color:#64748B; letter-spacing:0.5px;">C/TPA ALLIANCE</span>
                    </div>
                    <div class="partner-badge-item" title="i3screen Electronic CCF Logistics" style="display:inline-flex; align-items:center; background:#FFFFFF; border:1px solid #CBD5E1; border-radius:8px; padding:7px 16px; box-shadow:0 1px 3px rgba(0,0,0,0.04); white-space:nowrap;">
                        <span class="partner-badge-name" style="font-weight:900; color:#0B2545; font-size:13px; letter-spacing:0.5px;">i3screen</span>
                        <span class="partner-badge-divider" style="color:#CBD5E1; margin:0 8px; font-weight:300;">|</span>
                        <span class="partner-badge-sub" style="font-size:11px; font-weight:700; color:#64748B; letter-spacing:0.5px;">eCCF CERTIFIED</span>
                    </div>
                </div>
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
                        <li><a href="{{ url('/services') }}" style="color:#FEF08A; font-weight:700;">★ All Services Directory</a></li>
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
                    <a href="{{ url('/services') }}" style="color:#FEF08A; font-weight:700;">Services Directory</a>
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

            <form id="expressOrderForm" action="{{ route('checkout.index') }}" method="GET">
                <input type="hidden" id="modalInputTestName" name="test_name" value="5 Panel NON-DOT Drug Test">
                <input type="hidden" id="modalInputProductId" name="product_id" value="">

                <div class="modal-form-group">
                    <label for="donorZip">Testing Zip Code (Closest Center Locator) *</label>
                    <input type="text" id="donorZip" name="zip" placeholder="Enter 5-digit zip code" required maxlength="5" pattern="[0-9]{5}">
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
                    <label for="donorEmail">Email (For Confidential Results) *</label>
                    <input type="email" id="donorEmail" name="email" placeholder="donor@example.com" required>
                    <small style="font-size:11.5px; color:#64748B;">Confidential results &amp; electronic donor pass sent here within 24-48 hours.</small>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="modal-form-group">
                        <label for="modalDob">Date of Birth *</label>
                        <input type="date" id="modalDob" name="dob" required>
                    </div>
                    <div class="modal-form-group">
                        <label for="donorPhone">Phone Number *</label>
                        <input type="tel" id="donorPhone" name="phone" placeholder="(555) 000-0000" required>
                    </div>
                </div>

                <div class="modal-form-group">
                    <label for="testingReason">1. What is the reason for testing? *</label>
                    <select id="testingReason" name="test_reason" onchange="handleModalReasonChange(this.value)" required>
                        <option value="employment">Pre-Employment / Workplace</option>
                        <option value="dot">DOT Regulated (FMCSA / FAA / USCG / FTA / PHMSA / FRA)</option>
                        <option value="court">Court Ordered / Probation / Legal</option>
                        <option value="personal">Personal / Family Testing</option>
                    </select>
                </div>

                <!-- Conditional DOT Agency -->
                <div class="modal-form-group" id="modalDotAgencyGroup" style="display:none;">
                    <label for="modalDotAgency">DOT Regulated Agency *</label>
                    <select id="modalDotAgency" name="dot_agency" onchange="handleModalDotAgencyChange(this.value)">
                        <option value="FMCSA">FMCSA (Federal Motor Carrier Safety Administration)</option>
                        <option value="FAA">FAA (Federal Aviation Administration)</option>
                        <option value="USCG">USCG (United States Coast Guard)</option>
                        <option value="FTA">FTA (Federal Transit Administration)</option>
                        <option value="PHMSA">PHMSA (Pipeline &amp; Hazardous Materials)</option>
                        <option value="FRA">FRA (Federal Railroad Administration)</option>
                    </select>
                </div>

                <!-- Non-DOT ID -->
                <div class="modal-form-group" id="modalNonDotIdGroup">
                    <label for="modalNonDotId">At least last 6 of SSN or Employee ID *</label>
                    <input type="text" id="modalNonDotId" name="donor_id_number" placeholder="Enter last 6 of SSN or Employee ID">
                </div>

                <!-- DOT FMCSA ID -->
                <div id="modalFmcsaGroup" style="display:none; grid-template-columns:1fr 1fr; gap:12px;">
                    <div class="modal-form-group">
                        <label for="modalCdlNumber">CDL Number *</label>
                        <input type="text" id="modalCdlNumber" name="cdl_number" placeholder="Commercial Driver License #">
                    </div>
                    <div class="modal-form-group">
                        <label for="modalCdlState">State of Issuance *</label>
                        <select id="modalCdlState" name="cdl_state">
                            <option value="">Select State</option>
                            <option value="AL">AL</option><option value="AK">AK</option><option value="AZ">AZ</option><option value="AR">AR</option><option value="CA">CA</option><option value="CO">CO</option><option value="CT">CT</option><option value="DE">DE</option><option value="FL">FL</option><option value="GA">GA</option><option value="HI">HI</option><option value="ID">ID</option><option value="IL">IL</option><option value="IN">IN</option><option value="IA">IA</option><option value="KS">KS</option><option value="KY">KY</option><option value="LA">LA</option><option value="ME">ME</option><option value="MD">MD</option><option value="MA">MA</option><option value="MI">MI</option><option value="MN">MN</option><option value="MS">MS</option><option value="MO">MO</option><option value="MT">MT</option><option value="NE">NE</option><option value="NV">NV</option><option value="NH">NH</option><option value="NJ">NJ</option><option value="NM">NM</option><option value="NY">NY</option><option value="NC">NC</option><option value="ND">ND</option><option value="OH">OH</option><option value="OK">OK</option><option value="OR">OR</option><option value="PA">PA</option><option value="RI">RI</option><option value="SC">SC</option><option value="SD">SD</option><option value="TN">TN</option><option value="TX">TX</option><option value="UT">UT</option><option value="VT">VT</option><option value="VA">VA</option><option value="WA">WA</option><option value="WV">WV</option><option value="WI">WI</option><option value="WY">WY</option>
                        </select>
                    </div>
                </div>

                <!-- DOT Other ID -->
                <div class="modal-form-group" id="modalDotOtherGroup" style="display:none;">
                    <label for="modalDotOtherId">Full Social Security Number or Employee ID *</label>
                    <input type="text" id="modalDotOtherId" placeholder="Full 9-digit SSN or Employee ID" oninput="document.getElementById('modalNonDotId').value = this.value">
                </div>

                <p style="font-size:12px; color:var(--color-text-muted); margin-bottom:16px;">
                    🔒 <strong>Secure Electronic Registration:</strong> Pre-registration is required. Testing centers do not accept payments on-site. You must receive an electronic registration form/donor pass prior to proceeding to the testing center.
                </p>

                <div style="display:flex; justify-content:flex-end; gap:10px;">
                    <button type="button" class="btn btn-outline-navy btn-sm" onclick="closeOrderModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" style="background:#C1121F; color:#fff;">
                        Register / Order Now →
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
