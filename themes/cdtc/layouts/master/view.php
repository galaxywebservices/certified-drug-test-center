<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? ($page->title ?? 'Certified Drug Test Center')) ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Icon Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= asset('css/site.css') ?>">

    <style>
        :root {
            --adt-navy: #0B2545;
            --adt-blue: #133E6E;
            --adt-crimson: #C1121F;
            --adt-orange: #f16001;
            --adt-dark: #0F172A;
            --adt-light: #F8FAFC;
            --adt-border: #E2E8F0;
            --adt-text: #334155;
            --adt-muted: #64748B;
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            color: var(--adt-text);
            background: #ffffff;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        /* ════════════════════════ TOPBAR ════════════════════════ */
        .site-topbar {
            background: #0B2545;
            color: #CBD5E1;
            font-size: 13px;
            padding: 8px 0;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .topbar-inner {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .topbar-badge {
            background: #C1121F;
            color: #fff;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .topbar-phone {
            color: #ffffff;
            font-weight: 700;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .topbar-phone:hover { color: #f16001; }

        /* ════════════════════════ NAVBAR ════════════════════════ */
        .site-navbar {
            background: #ffffff;
            box-shadow: 0 2px 12px rgba(11,37,69,0.06);
            border-bottom: 1px solid var(--adt-border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .navbar-inner {
            max-width: 1240px;
            margin: 0 auto;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }
        .nav-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .nav-brand img {
            height: 48px;
            width: auto;
            display: block;
        }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 24px;
            list-style: none;
        }
        .nav-link {
            font-size: 14.5px;
            font-weight: 600;
            color: var(--adt-navy);
            text-decoration: none;
            transition: color 0.2s;
        }
        .nav-link:hover { color: var(--adt-crimson); }
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .nav-phone-box {
            text-align: right;
            display: flex;
            flex-direction: column;
        }
        .nav-phone-label {
            font-size: 11px;
            text-transform: uppercase;
            color: var(--adt-muted);
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .nav-phone-num {
            font-family: 'Outfit', sans-serif;
            font-size: 16px;
            font-weight: 800;
            color: var(--adt-crimson);
            text-decoration: none;
        }
        .btn-schedule-test {
            background: var(--adt-navy);
            color: #ffffff !important;
            padding: 10px 22px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-schedule-test:hover { background: var(--adt-blue); }

        /* ════════════════════════ PAGE CONTENT ════════════════════════ */
        .pagebuilder-content-wrapper {
            max-width: 1200px;
            margin: 40px auto 60px;
            padding: 0 24px;
            min-height: 400px;
            color: #334155;
            font-size: 16px;
            line-height: 1.8;
        }
        .pagebuilder-content-wrapper p {
            margin-bottom: 18px;
            line-height: 1.8;
        }
        .pagebuilder-content-wrapper h1,
        .pagebuilder-content-wrapper h2,
        .pagebuilder-content-wrapper h3,
        .pagebuilder-content-wrapper h4,
        .pagebuilder-content-wrapper h5,
        .pagebuilder-content-wrapper h6 {
            color: #0B2545;
            font-family: 'Outfit', -apple-system, sans-serif;
            font-weight: 700;
            margin-top: 24px;
            margin-bottom: 14px;
            line-height: 1.3;
        }
        .pagebuilder-content-wrapper ul,
        .pagebuilder-content-wrapper ol {
            margin: 12px 0 24px 28px;
            padding-left: 0;
            list-style-type: disc;
        }
        .pagebuilder-content-wrapper ol {
            list-style-type: decimal;
        }
        .pagebuilder-content-wrapper li {
            margin-bottom: 8px;
            line-height: 1.6;
        }
        .pagebuilder-content-wrapper img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        /* Grid and cards for structured content */
        .pagebuilder-content-wrapper .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -12px;
            margin-right: -12px;
            margin-bottom: 24px;
        }
        .pagebuilder-content-wrapper .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 12px;
        }
        @media (max-width: 768px) {
            .pagebuilder-content-wrapper .col-md-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }
        }
        .pagebuilder-content-wrapper .border-box-blue,
        .pagebuilder-content-wrapper .border-box-blue-rounded {
            background: #F8FAFC;
            border: 1px solid #CBD5E1;
            border-radius: 10px;
            padding: 24px 28px;
            height: auto;
            min-height: auto;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            margin-bottom: 24px;
            box-sizing: border-box;
        }
        .pagebuilder-content-wrapper .col-md-6 > .border-box-blue,
        .pagebuilder-content-wrapper .col-md-6 > .border-box-blue-rounded {
            height: 100%;
        }
        .pagebuilder-content-wrapper .border-box-blue h4,
        .pagebuilder-content-wrapper .border-box-blue-rounded h4 {
            color: #0B2545;
            font-size: 19px;
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 2px solid #E2E8F0;
        }
        .pagebuilder-content-wrapper .border-box-blue ul {
            margin-left: 20px;
            margin-bottom: 0;
        }

        /* Buttons & Call-to-actions */
        .pagebuilder-content-wrapper .button,
        .pagebuilder-content-wrapper a.button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 26px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none !important;
            transition: all 0.2s ease;
            cursor: pointer;
            text-align: center;
        }
        .pagebuilder-content-wrapper .button-blue,
        .pagebuilder-content-wrapper a.button-blue {
            background: #0B2545;
            color: #ffffff !important;
            border: 2px solid #0B2545;
            box-shadow: 0 2px 4px rgba(11,37,69,0.15);
        }
        .pagebuilder-content-wrapper .button-blue:hover,
        .pagebuilder-content-wrapper a.button-blue:hover {
            background: #133E6E;
            border-color: #133E6E;
            color: #ffffff !important;
            transform: translateY(-1px);
        }
        .pagebuilder-content-wrapper .button-yellow,
        .pagebuilder-content-wrapper a.button-yellow,
        .pagebuilder-content-wrapper .button-red,
        .pagebuilder-content-wrapper a.button-red {
            background: #C1121F;
            color: #ffffff !important;
            border: 2px solid #C1121F;
            box-shadow: 0 2px 4px rgba(193,18,31,0.25);
        }
        .pagebuilder-content-wrapper .button-yellow:hover,
        .pagebuilder-content-wrapper a.button-yellow:hover,
        .pagebuilder-content-wrapper .button-red:hover,
        .pagebuilder-content-wrapper a.button-red:hover {
            background: #990f19;
            border-color: #990f19;
            color: #ffffff !important;
            transform: translateY(-1px);
        }

        /* ════════════════════════ FOOTER ════════════════════════ */
        .site-footer {
            background: #0B2545;
            color: #CBD5E1;
            padding: 60px 0 30px;
            border-top: 4px solid var(--adt-crimson);
            margin-top: 60px;
        }
        .footer-inner {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 24px;
        }
        .footer-credbar {
            text-align: center;
            padding-bottom: 40px;
            margin-bottom: 40px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .footer-credbar-title {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #94A3B8;
            font-weight: 700;
            margin-bottom: 16px;
        }
        .footer-credbar img {
            max-width: 700px;
            width: 100%;
            height: auto;
            border-radius: 6px;
        }
        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }
        @media (max-width: 900px) {
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .nav-links { display: none; }
        }
        @media (max-width: 600px) {
            .footer-grid { grid-template-columns: 1fr; }
        }
        .footer-col h4 {
            font-family: 'Outfit', sans-serif;
            color: #ffffff;
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 18px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .footer-col ul { list-style: none; }
        .footer-col li { margin-bottom: 10px; }
        .footer-col a {
            color: #94A3B8;
            font-size: 14px;
            text-decoration: none;
            transition: color 0.2s;
        }
        .footer-col a:hover { color: #ffffff; }
        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #64748B;
            flex-wrap: wrap;
            gap: 12px;
        }
        .footer-bottom a { color: #94A3B8; text-decoration: none; }
        .footer-bottom a:hover { color: #ffffff; }
    </style>
</head>
<body>

<!-- TOPBAR -->
<header class="site-topbar">
    <div class="topbar-inner">
        <div class="topbar-left">
            <span class="topbar-badge">SAMHSA Certified</span>
            <span>National Specimen Collection &amp; Laboratory Testing Network</span>
        </div>
        <div class="topbar-right">
            <span>¡Hablamos Español!</span>
            <span>•</span>
            <a href="tel:18009854339" class="topbar-phone">
                <i class="ri-phone-fill"></i>
                Call Toll-Free: (800)-985-4339
            </a>
        </div>
    </div>
</header>

<!-- NAVBAR -->
<nav class="site-navbar">
    <div class="navbar-inner">
        <a href="<?= url('/') ?>" class="nav-brand">
            <img src="<?= asset('images/logo.png') ?>" alt="Certified Drug Test Center" onerror="this.onerror=null; this.src='https://certifieddrugtestcenter.com/images/logo.png';">
        </a>
        <ul class="nav-links">
            <li><a href="<?= url('/category/urine-drug-tests') ?>" class="nav-link">Drug Tests</a></li>
            <li><a href="<?= url('/category/dot-drug-alcohol-tests') ?>" class="nav-link">DOT Testing</a></li>
            <li><a href="<?= url('/locations') ?>" class="nav-link">Locations</a></li>
            <li><a href="<?= url('/employers') ?>" class="nav-link">Employers</a></li>
            <li><a href="<?= url('/category/background-checks') ?>" class="nav-link">Background Checks</a></li>
            <li><a href="<?= url('/track-order') ?>" class="nav-link">Order Status</a></li>
            <li><a href="<?= url('/contact-us') ?>" class="nav-link">Contact</a></li>
        </ul>
        <div class="nav-actions">
            <div class="nav-phone-box">
                <span class="nav-phone-label">Toll-Free Dispatch</span>
                <a href="tel:18009854339" class="nav-phone-num">(800)-985-4339</a>
            </div>
            <a href="<?= url('/checkout') ?>" class="btn-schedule-test">
                <i class="ri-calendar-check-line"></i>
                Schedule Test
            </a>
        </div>
    </div>
</nav>

<!-- MAIN PAGEBUILDER CANVAS CONTAINER -->
<main class="pagebuilder-content-wrapper">
    <?= $body ?>
</main>

<!-- FOOTER -->
<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-credbar">
            <div class="footer-credbar-title">Certified National Specimen Collection &amp; SAMHSA Accredited Laboratory Network</div>
            <img src="<?= asset('assets/images/credbar.jpg') ?>" alt="Quest Diagnostics, Labcorp, SAMHSA, DATIA, NDASA, SAPAA Accredited" onerror="this.style.display='none';">
        </div>

        <div class="footer-grid">
            <div class="footer-col">
                <h4>Certified Drug Test Center</h4>
                <p style="font-size: 14px; color: #94A3B8; line-height: 1.7; margin-bottom: 16px;">
                    Accredited drug, alcohol, and DNA collection network partnering with Quest Diagnostics and Labcorp with over 20,000 certified walk-in facilities nationwide.
                </p>
                <p style="font-size: 14px; color: #fff;">
                    <strong>National Dispatch:</strong> (800)-985-4339
                </p>
            </div>
            <div class="footer-col">
                <h4>Testing Categories</h4>
                <ul>
                    <li><a href="<?= url('/category/urine-drug-tests') ?>">Urine Drug Tests</a></li>
                    <li><a href="<?= url('/category/dot-drug-alcohol-tests') ?>">DOT Mandated Tests</a></li>
                    <li><a href="<?= url('/category/hair-drug-tests') ?>">Hair Follicle Tests</a></li>
                    <li><a href="<?= url('/category/alcohol-tests') ?>">Alcohol Screening</a></li>
                    <li><a href="<?= url('/category/background-checks') ?>">Background Checks</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?= url('/locations') ?>">Find Testing Centers</a></li>
                    <li><a href="<?= url('/employers') ?>">Employer Corporate Accounts</a></li>
                    <li><a href="<?= url('/track-order') ?>">Track Donor Pass</a></li>
                    <li><a href="<?= url('/contact-us') ?>">Contact Support</a></li>
                    <li><a href="<?= url('/admin/login') ?>">Admin Portal</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Compliance &amp; Trust</h4>
                <ul>
                    <li><a href="<?= url('/terms-and-conditions') ?>">Terms &amp; Conditions</a></li>
                    <li><a href="<?= url('/privacy-policy') ?>">Privacy Policy</a></li>
                    <li><a href="<?= url('/sitemap.xml') ?>">XML Sitemap</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div>&copy; <?= date('Y') ?> Certified Drug Test Center. All rights reserved. Quest Diagnostics and Labcorp are registered trademarks.</div>
            <div style="display: flex; gap: 16px;">
                <a href="<?= url('/privacy-policy') ?>">Privacy</a>
                <a href="<?= url('/terms-and-conditions') ?>">Terms</a>
                <a href="<?= url('/contact-us') ?>">Contact</a>
            </div>
        </div>
    </div>
</footer>

<script>
    // Remove contenteditable on public frontend
    if (!window.location.pathname.includes('/pagebuilder') && !window.isPageBuilderEditor) {
        document.querySelectorAll('[contenteditable]').forEach(el => el.removeAttribute('contenteditable'));
    }
</script>
</body>
</html>
