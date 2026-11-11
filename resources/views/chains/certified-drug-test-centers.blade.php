@extends('layouts.main')

@section('content')
<style>
.cms-hero-bar {
    background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
    color: #fff;
    padding: 40px 0;
    border-bottom: 3px solid #C1121F;
}
.cms-hero-bar .breadcrumbs {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #94A3B8;
    margin-bottom: 12px;
}
.cms-hero-bar .breadcrumbs a {
    color: #CBD5E1;
    text-decoration: none;
}
.cms-hero-bar .breadcrumbs a:hover {
    color: #fff;
    text-decoration: underline;
}

.cdtc{--navy:#0b3d6e;--navy-dk:#072a4d;--blue:#1565c0;--teal:#0f8b7d;--teal-lt:#e6f5f3;--ink:#1b2430;--muted:#5b6675;--line:#dde3ea;--soft:#f4f7fa;--accent:#e8532b;--accent-dk:#c7411d;--ok:#1b8a3a;--r:12px;--shadow:0 4px 18px rgba(11,61,110,.08);
  color:var(--ink);background:#fff;line-height:1.6;font-size:17px;overflow-x:hidden}
.cdtc *,.cdtc *::before,.cdtc *::after{box-sizing:border-box}
.cdtc img{max-width:100%;height:auto}
.cdtc a{color:var(--blue)}
.cdtc a:focus-visible,.cdtc button:focus-visible,.cdtc input:focus-visible,.cdtc summary:focus-visible{outline:3px solid var(--accent);outline-offset:2px}
.cdtc h1,.cdtc h2,.cdtc h3{line-height:1.25;color:var(--navy-dk);margin:0 0 .5em;overflow-wrap:break-word}
.cdtc h1{font-size:clamp(1.75rem,4.5vw,2.9rem)}
.cdtc h2{font-size:clamp(1.4rem,3.2vw,2.1rem)}
.cdtc h3{font-size:1.15rem}
.cdtc .h-sm{font-size:1.3rem}
.cdtc p{margin:0 0 1em}
.cdtc .wrap{max-width:1180px;margin:0 auto;padding:0 16px}
.cdtc .center{text-align:center}
.cdtc .center .lead{margin-left:auto;margin-right:auto}
.cdtc .eyebrow{display:inline-block;font-size:.8rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--teal);margin-bottom:.4em}
.cdtc .btn{display:inline-block;padding:14px 24px;border-radius:999px;font-weight:700;text-decoration:none;border:0;cursor:pointer;font-size:1rem;text-align:center;line-height:1.2}
.cdtc .btn-primary{background:var(--accent);color:#fff}
.cdtc .btn-primary:hover{background:var(--accent-dk)}
.cdtc .btn-ghost{background:#fff;color:var(--navy);border:2px solid var(--navy)}
.cdtc section{padding:56px 0}
.cdtc .soft{background:var(--soft)}
.cdtc .lead{font-size:1.08rem;color:var(--muted);max-width:780px}

/* breadcrumb */
.cdtc .crumbs{font-size:.85rem;color:var(--muted);padding-top:12px}
.cdtc .crumbs ol{list-style:none;margin:0;padding:0;display:flex;flex-wrap:wrap;gap:6px}
.cdtc .crumbs li+li::before{content:"\203A ";margin-right:6px}
.cdtc .crumbs a{color:var(--muted)}

/* hero */
.cdtc .hero{background:linear-gradient(160deg,#eef4fb 0%,#fff 60%);padding:16px 0 56px}
.cdtc .hero-grid{display:grid;grid-template-columns:minmax(0,1.25fr) minmax(0,1fr);gap:40px;align-items:start;margin-top:20px}
.cdtc ul.checks{list-style:none;padding:0;margin:18px 0 24px;display:grid;grid-template-columns:1fr 1fr;gap:8px 16px}
.cdtc .checks li{padding-left:28px;position:relative;font-weight:600}
.cdtc .checks li::before{content:"\2713 ";position:absolute;left:0;top:3px;color:#fff;background:var(--ok);width:20px;height:20px;border-radius:50%;font-size:.75rem;display:flex;align-items:center;justify-content:center}
.cdtc .cta-row{display:flex;flex-wrap:wrap;gap:12px}
.cdtc .finder{background:#fff;border:1px solid var(--line);border-radius:var(--r);box-shadow:var(--shadow);padding:24px}
.cdtc .finder h2{font-size:1.3rem}
.cdtc .finder label{display:block;font-weight:700;margin-bottom:6px}
.cdtc .finder .row{display:flex;gap:8px}
.cdtc .finder input{flex:1;min-width:0;padding:14px;font-size:16px;border:1px solid #b9c4d0;border-radius:10px}
.cdtc .finder small{display:block;color:var(--muted);margin-top:10px}
.cdtc .rating{display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-top:16px;font-size:.92rem}
.cdtc .stars{color:#f5a623;letter-spacing:2px}

/* quick answer + facts */
.cdtc .quick-answer{background:var(--teal-lt);border-left:5px solid var(--teal);border-radius:var(--r);padding:22px 24px}
.cdtc .quick-answer h2{font-size:1.3rem}
.cdtc .quick-answer p{margin:0}
.cdtc .facts{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:16px;margin-top:24px}
.cdtc .fact{background:#fff;border:1px solid var(--line);border-radius:var(--r);padding:18px;text-align:center}
.cdtc .fact strong{display:block;font-size:1.6rem;color:var(--navy)}
.cdtc .fact span{font-size:.92rem;color:var(--muted)}

/* steps / cards / columns */
.cdtc .steps{list-style:none;padding:0;margin:28px 0 0;display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:18px;counter-reset:s}
.cdtc .steps li{background:#fff;border:1px solid var(--line);border-radius:var(--r);padding:22px;counter-increment:s}
.cdtc .steps li::before{content:"Step " counter(s);font-size:.9rem;font-weight:800;letter-spacing:.06em;text-transform:uppercase;color:#fff;background:var(--teal);display:inline-block;padding:4px 12px;border-radius:999px;margin-bottom:10px}
.cdtc .steps p{margin:0}
.cdtc .cards{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px;margin-top:28px}
.cdtc .card{background:#fff;border:1px solid var(--line);border-radius:var(--r);padding:22px;display:flex;flex-direction:column}
.cdtc .card p{color:var(--muted);flex:1}
.cdtc .card a.more{font-weight:700;text-decoration:none}
.cdtc .two-col{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:32px;align-items:start}
.cdtc ul.tick{padding-left:0;list-style:none}
.cdtc ul.tick li{padding-left:26px;position:relative;margin-bottom:8px}
.cdtc ul.tick li::before{content:"\2713 ";position:absolute;left:0;color:var(--ok);font-weight:800}

/* tables */
.cdtc .table-wrap{margin-top:24px;border:1px solid var(--line);border-radius:var(--r);background:#fff;overflow:hidden}
.cdtc table{border-collapse:collapse;width:100%;font-size:.95rem}
.cdtc caption{text-align:left;padding:14px 16px;font-weight:700;color:var(--navy-dk)}
.cdtc th,.cdtc td{padding:12px 14px;border-bottom:1px solid var(--line);text-align:left;vertical-align:top}
.cdtc thead th{background:var(--navy);color:#fff}
.cdtc tbody tr:nth-child(even){background:#fafbfd}
.cdtc td.price{font-weight:800;color:var(--navy);white-space:nowrap}
.cdtc td.y{color:var(--ok);font-weight:700}
.cdtc td.n{color:#9aa4b1}
.cdtc .note{font-size:.88rem;color:var(--muted);margin-top:10px}

/* states */
.cdtc .states{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:8px;margin-top:24px;list-style:none;padding:0}
.cdtc .states a{display:block;background:#fff;border:1px solid var(--line);border-radius:10px;padding:10px 12px;text-decoration:none;color:var(--ink);font-weight:600;font-size:.95rem}
.cdtc .states a:hover{border-color:var(--blue);color:var(--blue)}
.cdtc .states span{display:block;font-weight:400;font-size:.8rem;color:var(--muted)}

/* trust, glossary, faq */
.cdtc .trust{display:flex;flex-wrap:wrap;gap:10px;justify-content:center;margin-top:20px}
.cdtc .trust span{background:#fff;border:1px solid var(--line);border-radius:999px;padding:8px 16px;font-weight:700;font-size:.88rem;color:var(--navy)}
.cdtc dl.gloss{display:grid;grid-template-columns:minmax(0,1fr) minmax(0,1fr);gap:16px 32px;margin:24px 0 0}
.cdtc dl.gloss div{background:#fff;border:1px solid var(--line);border-radius:var(--r);padding:16px 18px}
.cdtc dl.gloss dt{font-weight:800;color:var(--navy)}
.cdtc dl.gloss dd{margin:4px 0 0;color:var(--muted)}
.cdtc .faq details{background:#fff;border:1px solid var(--line);border-radius:var(--r);margin-bottom:10px}
.cdtc .faq summary{cursor:pointer;padding:18px 48px 18px 20px;font-weight:700;list-style:none;position:relative}
.cdtc .faq summary::-webkit-details-marker{display:none}
.cdtc .faq summary::after{content:"+";position:absolute;right:20px;top:14px;font-size:1.5rem;color:var(--teal)}
.cdtc .faq details[open] summary::after{content:"\2013 "}
.cdtc .faq summary h3{display:inline;font-size:1.05rem;color:var(--ink);margin:0}
.cdtc .faq-answer{padding:0 20px 18px;color:#36414f}
.cdtc .faq-answer p{margin:0}
.cdtc .sources-section{padding:44px 0;background:#F8FAFC;border-top:1px solid var(--line);border-bottom:1px solid var(--line)}
.cdtc .sources-card{background:#FFFFFF;border:1px solid #E2E8F0;border-radius:12px;padding:32px 28px;box-shadow:0 2px 10px rgba(11,37,69,0.03)}
.cdtc .sources-badge{display:inline-flex;align-items:center;gap:6px;background:#F0FDF4;color:#166534;font-size:11px;font-weight:800;padding:4px 10px;border-radius:9999px;border:1px solid #BBF7D0;margin-bottom:10px;text-transform:uppercase;letter-spacing:0.3px}
.cdtc .sources-title{font-size:1.45rem;font-weight:800;color:var(--navy);margin:0 0 4px}
.cdtc .sources-subtitle{font-size:0.95rem;color:var(--muted);margin:0 0 22px}
.cdtc .sources-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:22px}
@media (max-width:768px){.cdtc .sources-grid{grid-template-columns:1fr}}
.cdtc .source-item{display:flex;align-items:center;gap:14px;background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;padding:16px;text-decoration:none;color:inherit;transition:all 0.2s ease}
.cdtc .source-item:hover{transform:translateY(-2px);border-color:var(--navy);box-shadow:0 6px 16px rgba(11,37,69,0.06);background:#FFFFFF}
.cdtc .source-icon{font-size:24px;flex-shrink:0}
.cdtc .source-info{flex:1}
.cdtc .source-info strong{display:block;font-size:0.95rem;color:var(--navy);margin-bottom:2px}
.cdtc .source-info span{display:block;font-size:0.82rem;color:#64748B;line-height:1.35}
.cdtc .source-arrow{font-size:16px;color:var(--teal);font-weight:800;margin-left:6px;flex-shrink:0}
.cdtc .sources-footer{border-top:1px solid #F1F5F9;padding-top:16px;margin-top:6px}
.cdtc .sources-audit{display:flex;gap:12px;align-items:flex-start;font-size:0.86rem;color:#475569;line-height:1.55}
.cdtc .sources-audit svg{flex-shrink:0;color:#16A34A;margin-top:3px}
.cdtc .final{background:var(--navy);text-align:center}
.cdtc .final h2{color:#fff}
.cdtc .final p{color:#cfdbe8}
.cdtc .final .cta-row{justify-content:center}
.cdtc .final .btn-ghost{background:transparent;color:#fff;border-color:#fff}

/* ===== Tablet ===== */
@media (max-width:960px){
  .cdtc .hero-grid,.cdtc .two-col{grid-template-columns:minmax(0,1fr);gap:28px}
  .cdtc .steps,.cdtc .cards,.cdtc .facts{grid-template-columns:repeat(2,minmax(0,1fr))}
  .cdtc .states{grid-template-columns:repeat(3,minmax(0,1fr))}
}

/* ===== Phone: everything stacks to one column ===== */
@media (max-width:640px){
  .cdtc{font-size:16px}
  .cdtc section{padding:16px 0 !important}
  .cdtc .hero{padding-bottom:18px !important}
  .cdtc ul.checks,.cdtc .steps,.cdtc .cards,.cdtc dl.gloss{grid-template-columns:minmax(0,1fr)}
  .cdtc .facts{gap:8px !important;margin-top:10px !important}
  .cdtc .steps{gap:10px !important;margin-top:12px !important}
  .cdtc .cards{gap:10px !important;margin-top:12px !important}
  .cdtc .table-wrap{margin-top:10px !important}
  .cdtc .sources-section{padding:16px 0 !important}
  .cdtc .fact{padding:12px 10px}
  .cdtc .fact strong{font-size:1.3rem}
  .cdtc .states{grid-template-columns:repeat(2,minmax(0,1fr))}
  .cdtc .cta-row .btn{flex:1 1 100%}
  .cdtc .finder{padding:16px}
  .cdtc .finder .row{flex-direction:column}
  .cdtc .finder .row .btn{width:100%}
  .cdtc .quick-answer{padding:18px}

  /* tables become stacked cards */
  .cdtc .table-wrap{border:0;background:transparent;overflow:visible}
  .cdtc table,.cdtc tbody,.cdtc tr,.cdtc th,.cdtc td{display:block;width:100%}
  .cdtc caption{display:block;padding:0 0 10px}
  .cdtc thead{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0 0 0 0);white-space:nowrap}
  .cdtc tbody tr,.cdtc tbody tr:nth-child(even){background:#fff;border:1px solid var(--line);border-radius:var(--r);margin-bottom:12px;padding:6px 0;box-shadow:var(--shadow)}
  .cdtc tbody th[scope="row"]{font-size:1.05rem;color:var(--navy-dk);border-bottom:1px solid var(--line);padding:10px 14px}
  .cdtc tbody th[scope="row"]::before{display:none}
  .cdtc tbody td{display:flex;justify-content:space-between;gap:12px;border-bottom:1px dashed var(--line);padding:8px 14px;text-align:right}
  .cdtc tbody td:last-child{border-bottom:0}
  .cdtc tbody td::before{content:attr(data-label);font-weight:700;color:var(--muted);text-align:left;flex:0 0 42%}
}
/* Floating mobile action bar */
.cdtc .sticky-call{display:none}
@media (max-width:700px){
  .cdtc .sticky-call{display:flex;position:fixed;bottom:0;left:0;right:0;z-index:9999;box-shadow:0 -4px 14px rgba(0,0,0,.15);padding-bottom:env(safe-area-inset-bottom);background:var(--navy)}
  .cdtc .sticky-call a{flex:1;text-align:center;padding:15px 8px;font-weight:800;font-size:1rem;text-decoration:none;color:#fff}
  .cdtc .sticky-call a:first-child{background:var(--navy)}
  .cdtc .sticky-call a:last-child{background:var(--accent)}
  .cdtc{padding-bottom:56px}
}
/* Hero bottom row: centered checkmarks + buttons */
.cdtc .hero-grid{align-items:center}
.cdtc .hero-bottom{margin-top:36px;padding-top:32px;border-top:1px solid var(--line)}
.cdtc ul.checks.checks-3{display:grid;grid-template-columns:repeat(3,auto);justify-content:center;gap:16px 64px;margin:0 auto}
.cdtc .checks-3 li{font-size:1.05rem;line-height:1.35}
.cdtc .hero-cta{display:flex;justify-content:center;gap:20px;max-width:760px;margin:32px auto 0}
.cdtc .hero-cta .btn{flex:1 1 0;min-width:0;min-height:62px;padding:16px 24px;font-size:1.15rem;display:flex;align-items:center;justify-content:center;border:2px solid transparent;white-space:nowrap;box-shadow:var(--shadow)}
.cdtc .hero-cta .btn-ghost{border-color:var(--navy)}
@media (max-width:960px){.cdtc ul.checks.checks-3{grid-template-columns:repeat(2,auto);gap:14px 40px}}
@media (max-width:640px){
  .cdtc .hero-bottom{margin-top:20px;padding-top:16px}
  .cdtc ul.checks.checks-3{grid-template-columns:minmax(0,1fr);justify-content:start}
  .cdtc .hero-cta{flex-direction:column;gap:10px;margin-top:16px}
  .cdtc .hero-cta .btn{flex:none;width:100%;min-height:56px;font-size:1.1rem}
}
</style>

<!-- Top CMS Bar matching sample structure -->
<div class="cms-hero-bar">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Breadcrumb" style="display:flex; gap:8px; font-size:13px; color:#94A3B8; margin-bottom:12px;">
            <a href="{{ url('/') }}" style="color:#CBD5E1; text-decoration:none;">Home</a>
            <span>&rsaquo;</span>
            <span style="color:#fff;">Certified Drug Test Centers</span>
        </nav>

        <h1 style="font-size:32px; font-weight:800; color:#fff; line-height:1.2; margin:0;">
            Certified Drug Test Centers
        </h1>
    </div>
</div>

<div class="cdtc">
<!-- ===== HERO ===== -->
  <div class="hero">
    <div class="wrap">
      <nav class="crumbs" aria-label="Breadcrumb">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li aria-current="page">Drug Testing Centers Nationwide</li>
        </ol>
      </nav>
      <div class="hero-grid">
        <div>
          <span class="eyebrow">{!! $chainSettings['hero_eyebrow'] ?? 'Nationwide · All 50 States' !!}</span>
          <h1>{{ $chainSettings['hero_title'] ?? 'Certified Drug Test Centers Near You' }}</h1>
          <p class="lead">{!! $chainSettings['hero_lead'] ?? '<strong>Certified Drug Test Centers</strong> are located in all cities and in most cases within minutes of your home or office. Order a drug or alcohol test online or call and receive an electronic donor pass via email or text immediately. Same-day testing available for employment, DOT, probation and personal purposes at more than 20,000 certified drug testing centers — including Quest Diagnostics, Labcorp and affiliated locations. Negative results are typically available within <strong>24–48 hours</strong>.' !!}</p>
        </div><!-- /left column -->

        <aside class="finder" aria-labelledby="finder-h">
          <h2 id="finder-h">Find a drug testing center near you</h2>
          <form action="{{ url('/locations') }}" method="get" role="search">
            <label for="zip">Enter your ZIP code</label>
            <div class="row">
              <input id="zip" name="zip" type="text" inputmode="numeric" pattern="[0-9]{5}" maxlength="5" autocomplete="postal-code" placeholder="e.g. 32771" required>
              <button class="btn btn-primary" type="submit">Search</button>
            </div>
            <small>Select and order your test at a nearby certified drug test center. Pre-registration is required, testing centers do not accept payment on site.</small>
          </form>
          <div class="rating" aria-label="Customer rating">
            <span class="stars" aria-hidden="true">&#x2605;&#x2605;&#x2605;&#x2605;&#x2605;</span>
            <a href="{{ url('/reviews') }}">4.9 out of 5 from 4,800+ verified reviews</a>
          </div>
        </aside>
      </div><!-- /hero-grid -->

      <!-- Full-width row: centered checkmarks + buttons under paragraph and ZIP box -->
      <div class="hero-bottom">
        <ul class="checks checks-3">
          @foreach($chainSettings['hero_checks'] ?? [
            '20,000+ Quest & Labcorp sites',
            'SAMHSA-certified laboratories',
            'Physician MRO review included',
            'DOT-compliant & legally defensible',
            'Order Today, Test Today',
            'No hidden fees at the testing site',
          ] as $check)
          <li>{{ $check }}</li>
          @endforeach
        </ul>
        <div class="hero-cta">
          <a class="btn btn-primary" href="{{ url('/checkout') }}">Order a Test Online</a>
          <a class="btn btn-ghost" href="tel:+18009854339">Call (800) 985-4339</a>
        </div>
      </div>
    </div>
  </div>

  <!-- ===== QUICK ANSWER / KEY FACTS (AEO) ===== -->
  <section aria-labelledby="qa-h">
    <div class="wrap">
      <div class="quick-answer">
        <h2 id="qa-h">{{ $chainSettings['quick_answer_title'] ?? 'Quick answer: how to get a drug or alcohol test near you today' }}</h2>
        <p>{!! $chainSettings['quick_answer_text'] ?? 'To get a drug or alcohol test near you, order the test online or by phone and within minutes receive your electronic donor pass by email and text, then walk in with a photo ID to the nearest certified collection site. Certified Drug Test Centers schedules same-day urine, hair follicle, saliva, breath alcohol, EtG and DOT drug tests at 20,000+ drug testing centers in all 50 states, with prices from $89.99 and results in 24–48 hours for most negative urine tests.' !!}</p>
      </div>
      <div class="facts">
        <div class="fact"><strong>{{ $chainSettings['fact_sites'] ?? '20,000+' }}</strong><span>{{ $chainSettings['fact_sites_label'] ?? 'certified collection sites' }}</span></div>
        <div class="fact"><strong>{{ $chainSettings['fact_states'] ?? '50' }}</strong><span>{{ $chainSettings['fact_states_label'] ?? 'states covered' }}</span></div>
        <div class="fact"><strong>{{ $chainSettings['fact_results'] ?? '24–48 hrs' }}</strong><span>{{ $chainSettings['fact_results_label'] ?? 'typical negative results' }}</span></div>
        <div class="fact"><strong>{{ $chainSettings['fact_price'] ?? '$89.99' }}</strong><span>{{ $chainSettings['fact_price_label'] ?? 'starting price, all-inclusive' }}</span></div>
      </div>
    </div>
  </section>



  <!-- ===== HOW IT WORKS ===== -->
  <section class="soft" id="how-it-works" aria-labelledby="how-h">
    <div class="wrap">
      <span class="eyebrow">How it works</span>
      <h2 id="how-h">How to schedule a drug test in 4 easy steps</h2>
      <p class="lead">If you're searching for drug testing near me, the process is simple. Ordering takes just minutes, most people get a same-day drug test at a location near them, after receiveing the donor/registration form via email or text</p>
      <ol class="steps">
        <li><h3>Choose your test &amp; register</h3><p>Select your test online or call (800) 985-4339. Enter the donor's details and ZIP code to pick the closest site. You're registered within minutes.</p></li>
        <li><h3>Get your donor pass instantly</h3><p>Your electronic donor registration pass &#x2014; with the site address, hours and instructions &#x2014; arrives by email and text right away.</p></li>
        <li><h3>Walk in to the collection site</h3><p>Show your pass and a government-issued photo ID. No appointment needed at most sites, and nothing to pay on site.</p></li>
        <li><h3>Receive confidential results</h3><p>Negative results are typically emailed in 24&#x2013;48 hours. Non-negative screens are lab-confirmed and reviewed by an MRO first.</p></li>
      </ol>
    </div>
  </section>

  <!-- ===== PRICING ===== -->
  <section id="pricing" aria-labelledby="price-h">
    <div class="wrap">
      <span class="eyebrow">Tests &amp; pricing</span>
      <h2 id="price-h">How much does a drug test cost?</h2>
      <p class="lead">A standard 5-panel urine drug test costs <strong>$89.99</strong> and a DOT 5-panel costs <strong>$99.99</strong>. Every price below includes the specimen collection, SAMHSA-certified laboratory analysis and Medical Review Officer (MRO) review &#x2014; there are no collection fees or lab fees at the testing site. Our Certified Drug Testing Centers are affordable and convenient for certified, lab-based drug tests near you. We also offer instant/rapid results testing for those needing same-day results.</p>
      <div class="table-wrap">
        <table>
          <caption>Drug and alcohol test prices, specimen type and turnaround</caption>
          <thead>
            <tr><th scope="col">Test</th><th scope="col">Price</th><th scope="col">Specimen</th><th scope="col">Detection window</th><th scope="col">Results</th><th scope="col">Best for</th></tr>
          </thead>
          <tbody>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/product/5-panel-nondot') }}">5 Panel Non-DOT Urine</a></th><td class="price" data-label="Price">$89.99</td><td data-label="Specimen">Urine</td><td data-label="Detection window">~1&#x2013;3 days*</td><td data-label="Results">1&#x2013;2 business days</td><td data-label="Best for">Pre-employment, personal</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/product/5-panel-dot') }}">5 Panel DOT Drug Test</a></th><td class="price" data-label="Price">$99.99</td><td data-label="Specimen">Urine (Federal CCF)</td><td data-label="Detection window">~1&#x2013;3 days*</td><td data-label="Results">24&#x2013;48 hours</td><td data-label="Best for">FMCSA, FAA, FRA, FTA, PHMSA, USCG</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/product/5-panel-exp-opiates') }}">5 Panel + Expanded Opiates</a></th><td class="price" data-label="Price">$99.99</td><td data-label="Specimen">Urine</td><td data-label="Detection window">~1&#x2013;3 days*</td><td data-label="Results">1&#x2013;2 business days</td><td data-label="Best for">Detecting prescription painkillers</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/product/10-panel') }}">10 Panel Urine</a></th><td class="price" data-label="Price">$109.99</td><td data-label="Specimen">Urine</td><td data-label="Detection window">~1&#x2013;3 days*</td><td data-label="Results">1&#x2013;2 business days</td><td data-label="Best for">Employers, healthcare</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/product/10-panel-exp-opiates') }}">10 Panel + Expanded Opiates</a></th><td class="price" data-label="Price">$119.99</td><td data-label="Specimen">Urine</td><td data-label="Detection window">~1&#x2013;3 days*</td><td data-label="Results">1&#x2013;2 business days</td><td data-label="Best for">Healthcare, probation, safety-sensitive</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/product/12-panel-comprehensive') }}">12 Panel Comprehensive</a></th><td class="price" data-label="Price">$139.99</td><td data-label="Specimen">Urine</td><td data-label="Detection window">~1&#x2013;3 days*</td><td data-label="Results">24&#x2013;48 hours</td><td data-label="Best for">Maximum drug coverage</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/category/hair') }}">Hair Follicle 5 Panel</a></th><td class="price" data-label="Price">$169.99</td><td data-label="Specimen">Hair (1.5 in.)</td><td data-label="Detection window">~90 days</td><td data-label="Results">2&#x2013;3 business days</td><td data-label="Best for">Long-term use history</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/category/hair') }}">Hair Follicle 10 Panel</a></th><td class="price" data-label="Price">$249.99</td><td data-label="Specimen">Hair</td><td data-label="Detection window">~90 days</td><td data-label="Results">2&#x2013;4 business days</td><td data-label="Best for">Comprehensive 90-day screen</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/category/oral-fluid-testing') }}">6 Panel Oral Fluid (Saliva)</a></th><td class="price" data-label="Price">$119.99</td><td data-label="Specimen">Saliva swab</td><td data-label="Detection window">~24&#x2013;48 hours</td><td data-label="Results">24&#x2013;48 hours</td><td data-label="Best for">Recent use, observed collection</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/product/dot-breath-alcohol') }}">DOT Breath Alcohol Test</a></th><td class="price" data-label="Price">$89.99</td><td data-label="Specimen">Breath (EBT)</td><td data-label="Detection window">Current impairment</td><td data-label="Results">Immediate</td><td data-label="Best for">DOT, post-accident, workplace</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/product/etg-alcohol') }}">EtG Alcohol Test (80-Hour)</a></th><td class="price" data-label="Price">$89.99</td><td data-label="Specimen">Urine</td><td data-label="Detection window">Up to ~80 hours</td><td data-label="Results">1&#x2013;2 business days</td><td data-label="Best for">Court, probation, sobriety programs</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/product/dot-physical') }}">DOT Physical Exam</a></th><td class="price" data-label="Price">$159.99</td><td data-label="Specimen">In-clinic exam</td><td data-label="Detection window">&#x2014;</td><td data-label="Results">Same-day medical card</td><td data-label="Best for">CDL drivers (NRCME examiner)</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/product/1-year-consortium-membership-dot-drug-test') }}">DOT Random Consortium</a></th><td class="price" data-label="Price">$99.99</td><td data-label="Specimen">Multi Year Enrollment Available</td><td data-label="Detection window">&#x2014;</td><td data-label="Results">Instant certificate</td><td data-label="Best for">Owner-operators, small fleets</td></tr>
            <tr><th scope="row" data-label="Test"><a href="{{ url('/category/dna-testing') }}">Legal DNA Paternity (AABB)</a></th><td class="price" data-label="Price">$499.99</td><td data-label="Specimen">Cheek swab</td><td data-label="Detection window">&#x2014;</td><td data-label="Results">2&#x2013;3 business days</td><td data-label="Best for">Court, USCIS, child support</td></tr>
          </tbody>
        </table>
      </div>
      <p class="note">*Urine detection windows vary by substance, dose, frequency of use and metabolism. Heavy, chronic marijuana use can be detected for 30 days or more. Prices shown are online prices as of November 2026.</p>
    </div>
  </section>

  <!-- ===== WHICH TEST DO I NEED ===== -->
  <section class="soft" id="which-test" aria-labelledby="which-h">
    <div class="wrap">
      <span class="eyebrow">Choose the right test</span>
      <h2 id="which-h">Which drug test do I need?</h2>
      <p class="lead">The right test depends on why you're being tested &#x2014; a pre-employment drug test for a new job, a DOT drug test for your CDL, or a court-ordered drug test for probation. If an employer, agency or court gave you specific instructions, order exactly what they requested. Otherwise, use this guide or try the <a href="{{ url('/find-my-test') }}">guided test selector</a>.</p>
      <div class="cards">
        <article class="card"><h3>Pre-employment &amp; workplace</h3><p>For a pre-employment drug test, most private employers request a 5-panel or 10-panel urine drug screen. Healthcare and safety-sensitive roles often require a 10-panel with expanded opiates.</p><a class="more" href="{{ url('/category/urine') }}">Urine drug tests &#x2192;</a></article>
        <article class="card"><h3>DOT-regulated jobs</h3><p>CDL drivers, pilots, transit, rail, pipeline and maritime workers need a DOT 5-panel urine test collected on a Federal CCF under 49 CFR Part 40.</p><a class="more" href="{{ url('/category/dot') }}">DOT testing services &#x2192;</a></article>
        <article class="card"><h3>Court, probation &amp; legal</h3><p>For a court-ordered or probation drug test, courts typically order chain-of-custody urine panels, EtG alcohol tests (up to ~80 hours) or 90-day hair tests. Confirm the exact test before ordering.</p><a class="more" href="{{ url('/category/alcohol') }}">Alcohol &amp; EtG tests &#x2192;</a></article>
        <article class="card"><h3>Personal &amp; family</h3><p>Anyone can order a confidential test without a doctor's order. Results go only to the email you provide at registration.</p><a class="more" href="{{ url('/find-my-test') }}">Find my test &#x2192;</a></article>
        <article class="card"><h3>Long-term history</h3><p>A hair follicle test shows a pattern of use over roughly the past 90 days and is difficult to cheat or dilute.</p><a class="more" href="{{ url('/category/hair') }}">Hair follicle tests &#x2192;</a></article>
        <article class="card"><h3>Employers &amp; fleets</h3><p>Corporate accounts, random testing programs, DOT consortium enrollment, Clearinghouse support and on-site mobile collections.</p><a class="more" href="{{ url('/employers') }}">Employer services &#x2192;</a></article>
      </div>
    </div>
  </section>

  <!-- ===== PANEL MATRIX ===== -->
  <section id="panels" aria-labelledby="panel-h">
    <div class="wrap">
      <span class="eyebrow">Panel comparison</span>
      <h2 id="panel-h">What's the difference between a 5, 10 and 12 panel drug test?</h2>
      <p class="lead">A <strong>5-panel</strong> test screens for amphetamines, cocaine, marijuana (THC), opiates and PCP. A <strong>10-panel</strong> adds barbiturates, benzodiazepines, methadone, methaqualone and propoxyphene. A <strong>12-panel</strong> adds tramadol, meperidine and expanded opiates such as oxycodone and hydrocodone.</p>
      <div class="table-wrap">
        <table>
          <caption>Substances detected by panel</caption>
          <thead><tr><th scope="col">Drug / metabolite</th><th scope="col">Class</th><th scope="col">5 Panel</th><th scope="col">10 Panel</th><th scope="col">12 Panel</th></tr></thead>
          <tbody>
            <tr><th scope="row" data-label="Drug / metabolite">Amphetamines / Methamphetamine</th><td data-label="Class">Stimulant</td><td class="y" data-label="5 Panel">&#x2713;</td><td class="y" data-label="10 Panel">&#x2713;</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
            <tr><th scope="row" data-label="Drug / metabolite">Cocaine metabolites</th><td data-label="Class">Stimulant</td><td class="y" data-label="5 Panel">&#x2713;</td><td class="y" data-label="10 Panel">&#x2713;</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
            <tr><th scope="row" data-label="Drug / metabolite">Marijuana (THC)</th><td data-label="Class">Cannabinoid</td><td class="y" data-label="5 Panel">&#x2713;</td><td class="y" data-label="10 Panel">&#x2713;</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
            <tr><th scope="row" data-label="Drug / metabolite">Opiates (codeine, morphine, heroin)</th><td data-label="Class">Opiate</td><td class="y" data-label="5 Panel">&#x2713;</td><td class="y" data-label="10 Panel">&#x2713;</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
            <tr><th scope="row" data-label="Drug / metabolite">Phencyclidine (PCP)</th><td data-label="Class">Hallucinogen</td><td class="y" data-label="5 Panel">&#x2713;</td><td class="y" data-label="10 Panel">&#x2713;</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
            <tr><th scope="row" data-label="Drug / metabolite">Barbiturates</th><td data-label="Class">Sedative</td><td class="n" data-label="5 Panel">&#x2014;</td><td class="y" data-label="10 Panel">&#x2713;</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
            <tr><th scope="row" data-label="Drug / metabolite">Benzodiazepines (Xanax, Valium)</th><td data-label="Class">Sedative</td><td class="n" data-label="5 Panel">&#x2014;</td><td class="y" data-label="10 Panel">&#x2713;</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
            <tr><th scope="row" data-label="Drug / metabolite">Methadone</th><td data-label="Class">Opioid</td><td class="n" data-label="5 Panel">&#x2014;</td><td class="y" data-label="10 Panel">&#x2713;</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
            <tr><th scope="row" data-label="Drug / metabolite">Methaqualone</th><td data-label="Class">Hypnotic</td><td class="n" data-label="5 Panel">&#x2014;</td><td class="y" data-label="10 Panel">&#x2713;</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
            <tr><th scope="row" data-label="Drug / metabolite">Propoxyphene</th><td data-label="Class">Opioid</td><td class="n" data-label="5 Panel">&#x2014;</td><td class="y" data-label="10 Panel">&#x2713;</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
            <tr><th scope="row" data-label="Drug / metabolite">Tramadol (Ultram)</th><td data-label="Class">Opioid analgesic</td><td class="n" data-label="5 Panel">&#x2014;</td><td class="n" data-label="10 Panel">&#x2014;</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
            <tr><th scope="row" data-label="Drug / metabolite">Meperidine (Demerol)</th><td data-label="Class">Opioid analgesic</td><td class="n" data-label="5 Panel">&#x2014;</td><td class="n" data-label="10 Panel">&#x2014;</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
            <tr><th scope="row" data-label="Drug / metabolite">Expanded opiates (oxycodone, hydrocodone)</th><td data-label="Class">Semi-synthetic opiate</td><td class="n" data-label="5 Panel">Add-on</td><td class="n" data-label="10 Panel">Add-on</td><td class="y" data-label="12 Panel">&#x2713;</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ===== DETECTION WINDOWS ===== -->
  <section class="soft" id="detection" aria-labelledby="det-h">
    <div class="wrap">
      <span class="eyebrow">Detection windows</span>
      <h2 id="det-h">How long do drugs stay in your system?</h2>
      <p class="lead">Urine tests typically detect most drugs used in the past <strong>1&#x2013;3 days</strong>, hair tests cover about the past <strong>90 days</strong>, and saliva tests detect use from roughly the past <strong>24&#x2013;48 hours</strong>. These are general estimates; actual windows depend on the substance, dose, frequency of use, body composition and metabolism.</p>
      <div class="table-wrap">
        <table>
          <caption>Approximate detection windows by specimen type</caption>
          <thead><tr><th scope="col">Substance</th><th scope="col">Urine</th><th scope="col">Saliva</th><th scope="col">Hair</th></tr></thead>
          <tbody>
            <tr><th scope="row" data-label="Substance">Marijuana (THC) &#x2014; occasional use</th><td data-label="Urine">1&#x2013;3 days</td><td data-label="Saliva">Up to ~24 hours</td><td data-label="Hair">Up to 90 days</td></tr>
            <tr><th scope="row" data-label="Substance">Marijuana (THC) &#x2014; heavy daily use</th><td data-label="Urine">30+ days</td><td data-label="Saliva">Up to ~72 hours</td><td data-label="Hair">Up to 90 days</td></tr>
            <tr><th scope="row" data-label="Substance">Cocaine</th><td data-label="Urine">2&#x2013;4 days</td><td data-label="Saliva">1&#x2013;2 days</td><td data-label="Hair">Up to 90 days</td></tr>
            <tr><th scope="row" data-label="Substance">Amphetamines / Methamphetamine</th><td data-label="Urine">1&#x2013;3 days</td><td data-label="Saliva">1&#x2013;2 days</td><td data-label="Hair">Up to 90 days</td></tr>
            <tr><th scope="row" data-label="Substance">Opiates (heroin, morphine, codeine)</th><td data-label="Urine">1&#x2013;3 days</td><td data-label="Saliva">1&#x2013;2 days</td><td data-label="Hair">Up to 90 days</td></tr>
            <tr><th scope="row" data-label="Substance">Oxycodone / Hydrocodone</th><td data-label="Urine">1&#x2013;3 days</td><td data-label="Saliva">1&#x2013;2 days</td><td data-label="Hair">Up to 90 days</td></tr>
            <tr><th scope="row" data-label="Substance">Benzodiazepines</th><td data-label="Urine">3&#x2013;7 days (longer for long-acting)</td><td data-label="Saliva">1&#x2013;2 days</td><td data-label="Hair">Up to 90 days</td></tr>
            <tr><th scope="row" data-label="Substance">PCP</th><td data-label="Urine">3&#x2013;8 days</td><td data-label="Saliva">1&#x2013;2 days</td><td data-label="Hair">Up to 90 days</td></tr>
            <tr><th scope="row" data-label="Substance">Alcohol (breath)</th><td colspan="3" data-label="Detection window">Measures current blood alcohol concentration &#x2014; typically detectable for up to ~12&#x2013;24 hours</td></tr>
            <tr><th scope="row" data-label="Substance">Alcohol (EtG urine)</th><td colspan="3" data-label="Detection window">Up to ~80 hours after drinking</td></tr>
          </tbody>
        </table>
      </div>
      <p class="note">Detection windows are approximate and provided for general education only; they are not a guarantee of any test outcome.</p>
    </div>
  </section>

  <!-- ===== DOT ===== -->
  <section id="dot" aria-labelledby="dot-h">
    <div class="wrap two-col">
      <div>
        <span class="eyebrow">DOT compliance</span>
        <h2 id="dot-h">DOT drug and alcohol testing nationwide</h2>
        <p>DOT drug testing is federally mandated testing for safety-sensitive transportation employees under <strong>49 CFR Part 40</strong>. A DOT test must be collected on a Federal Custody and Control Form (CCF), analyzed by an HHS/SAMHSA-certified laboratory, and verified by a Medical Review Officer.</p>
        <p>The DOT 5-panel urine test screens for marijuana metabolites, cocaine metabolites, amphetamines (amphetamine, methamphetamine, MDMA, MDA), opioids (codeine, morphine, 6-acetylmorphine, hydrocodone, hydromorphone, oxycodone, oxymorphone) and PCP.</p>
        <p>Whether you need a DOT drug test near you for a new CDL job or a random selection, we support all six DOT agencies: <strong>FMCSA</strong> (trucking), <strong>FAA</strong> (aviation), <strong>FRA</strong> (rail), <strong>FTA</strong> (transit), <strong>PHMSA</strong> (pipeline) and <strong>USCG</strong> (maritime).</p><p>DOT oral fluid drug testing is now authorized; inquire if now available at a certified drug testing center</p>
        <a class="btn btn-primary" href="{{ url('/category/dot') }}">View DOT services</a>
      </div>
      <div>
        <h3>DOT tests and services we provide</h3>
        <ul class="tick">
          <li>Pre-employment, random, post-accident, reasonable suspicion, return-to-duty and follow-up testing</li>
          <li><a href="{{ url('/product/5-panel-dot') }}">DOT 5-panel urine drug test</a> &#x2014; $99.99</li>
          <li><a href="{{ url('/product/5-panel-dot') }}">DOT 5-panel oral fluid drug test</a> &#x2014; $99.99</li>
          <li><a href="{{ url('/product/dot-breath-alcohol') }}">DOT breath alcohol test</a> by certified BATs &#x2014; $89.99</li>
          <li><a href="{{ url('/product/dot-physical') }}">DOT physical exam</a> by NRCME-certified examiners &#x2014; $159.99</li>
          <li><a href="{{ url('/product/1-year-consortium-membership-dot-drug-test') }}">DOT random testing consortium</a>&#x2014; $99.99/yr</li>
          <li><a href="{{ url('/product/5-panel-return-to-duty') }}">DOT Return to Duty(RTD)</a> testing&#x2014; $119.99</li>
          <li><a href="{{ url('/product/fmcsa-clearinghouse-accucheck') }}">FMCSA RTD Drug Test & Drug &amp; Alcohol Clearinghouse</a> Clear Step 5</a>&#x2014; $299.99</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===== EMPLOYERS + MOBILE ===== -->
  <section class="soft" id="employers" aria-labelledby="emp-h">
    <div class="wrap two-col">
      <div>
        <span class="eyebrow">{{ $chainSettings['onsite_eyebrow'] ?? 'For employers' }}</span>
        <h2 id="emp-h">{{ $chainSettings['onsite_title'] ?? 'Employer drug testing programs & on-site mobile testing' }}</h2>
        <p>{!! $chainSettings['onsite_lead'] ?? 'Businesses of every size use Certified Drug Test Centers for employee drug screening and compliant, nationwide drug-free workplace programs from one account — whether you hire one employee a year or manage a multi-state fleet.' !!}</p>
        <ul class="tick">
          @foreach($chainSettings['onsite_checks'] ?? [
            'Corporate accounts with volume pricing and an online results portal',
            'Pre-employment, random, post-accident and reasonable-suspicion testing',
            'On-site mobile collections for employees at job sites, warehouses and offices',
            'DOT consortium/TPA services and MIS reporting assistance',
            'Background checks and motor vehicle records (MVR)',
          ] as $check)
          <li>{{ $check }}</li>
          @endforeach
        </ul>
        <div class="cta-row">
          <a class="btn btn-primary" href="{{ url('/employers') }}">Open an employer account</a>
          <a class="btn btn-ghost" href="{{ url('/category/on-site-mobile') }}">Request mobile testing</a>
        </div>
      </div>
      <div>
        <h3>Why certified testing matters</h3>
        <p>An instant cup test bought online can't be used to make a defensible hiring or compliance decision. Lab-based testing through a certified collection site gives you:</p>
        <ul class="tick">
          <li><strong>Chain of custody</strong> &#x2014; every specimen is sealed, labeled and tracked from collection to result</li>
          <li><strong>SAMHSA-certified labs</strong> &#x2014; the same federal standard required for DOT testing</li>
          <li><strong>Confirmation testing</strong> &#x2014; non-negative screens are confirmed by GC/MS or LC/MS</li>
          <li><strong>MRO review</strong> &#x2014; a licensed physician checks for valid prescriptions before reporting</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- ===== STATES ===== -->
  <section id="locations" aria-labelledby="loc-h">
    <div class="wrap">
      <span class="eyebrow">{{ $chainSettings['directory_eyebrow'] ?? 'National directory' }}</span>
      <h2 id="loc-h">{{ $chainSettings['directory_title'] ?? 'Find drug and alcohol testing centers by State' }}</h2>
      <p class="lead">{!! $chainSettings['directory_lead'] ?? 'Certified Drug Test Centers has collection sites in all 50 states, from major metro areas to rural communities. Choose your state to see drug testing locations by city, including Quest Diagnostics and Labcorp drug test sites, or <a href="'.url('/locations').'">search by ZIP code</a>. Walk-ins are accepted at most sites once you\'ve registered.' !!}</p>
            <ul class="states">
        @foreach($states as $st)
        <li><a href="{{ $st['url'] }}">{{ $st['name'] }}<span>{{ $st['centers'] }}</span></a></li>
        @endforeach
      </ul>
    </div>
  </section>

  <!-- ===== TRUST ===== -->
  <section class="soft" aria-labelledby="trust-h">
    <div class="wrap center">
      <h2 id="trust-h">Accredited labs, certified collectors, verified results</h2>
      <p class="lead">All testing is performed through SAMHSA-certified and CAP-accredited laboratories in the Quest Diagnostics and Labcorp national network, with every non-negative result reviewed by an independent, licensed Medical Review Officer.</p>
      <div class="trust">
        <span>SAMHSA-certified labs</span><span>CAP-accredited</span><span>MRO-verified</span><span>DOT 49 CFR Part 40</span><span>AABB DNA</span><span>NDASA member</span><span>eCCF certified</span>
      </div>
    </div>
  </section>

  <!-- ===== GLOSSARY (AEO definitions) ===== -->
  <section id="glossary" aria-labelledby="gl-h">
    <div class="wrap">
      <span class="eyebrow">Drug testing glossary</span>
      <h2 id="gl-h">Drug testing terms explained</h2>
      <dl class="gloss">
        <div><dt>Certified drug test center</dt><dd>A specimen collection site staffed by trained collectors who follow chain-of-custody procedures and send specimens to a certified laboratory for analysis.</dd></div>
        <div><dt>Donor pass (registration pass)</dt><dd>The electronic authorization you receive after ordering. It tells the collection site which test to perform and must be shown at check-in.</dd></div>
        <div><dt>SAMHSA-certified laboratory</dt><dd>A lab certified by the U.S. Department of Health and Human Services through SAMHSA's National Laboratory Certification Program. DOT tests must use these labs.</dd></div>
        <div><dt>Medical Review Officer (MRO)</dt><dd>A licensed physician who reviews lab results and interviews the donor about legitimate prescriptions before a non-negative result is reported.</dd></div>
        <div><dt>Chain of custody</dt><dd>The documented, unbroken record of who handled a specimen from collection to result, which makes results legally defensible.</dd></div>
        <div><dt>Custody and Control Form (CCF)</dt><dd>The form used to document a specimen's chain of custody. DOT tests require the federal CCF; electronic versions are called eCCFs.</dd></div>
        <div><dt>Panel</dt><dd>The number of drug classes a test screens for &#x2014; for example, a 5-panel screens for five drug classes and a 10-panel for ten.</dd></div>
        <div><dt>Non-negative result</dt><dd>An initial screen that detected a substance above the cutoff. It is confirmed by GC/MS or LC/MS and reviewed by an MRO before any final result is reported.</dd></div>
        <div><dt>EtG test</dt><dd>A urine test for ethyl glucuronide, a breakdown product of alcohol, which can detect drinking up to about 80 hours afterward.</dd></div>
        <div><dt>DOT consortium / TPA</dt><dd>A third-party administrator that manages a random testing pool so owner-operators and small fleets can meet DOT random testing rules.</dd></div>
      </dl>
    </div>
  </section>

  <!-- ===== FAQ ===== -->
  <section class="soft faq" id="faq" aria-labelledby="faq-h">
    <div class="wrap">
      <span class="eyebrow">FAQ</span>
      <h2 id="faq-h">Drug testing frequently asked questions</h2>

      @foreach($chainSettings['faqs'] ?? [] as $faq)
      <details {{ $loop->first ? 'open' : '' }}><summary><h3>{{ $faq['question'] }}</h3></summary>
        <div class="faq-answer"><p>{!! $faq['answer'] !!}</p></div></details>
      @endforeach
    </div>
  </section>

  <!-- ===== SOURCES / E-E-A-T ===== -->
  <section id="sources" class="sources-section" aria-labelledby="src-h">
    <div class="wrap">
      <div class="sources-card">
        <div class="sources-header">
          <span class="sources-badge">
            <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
            Official Regulatory Authorities
          </span>
          <h2 id="src-h" class="sources-title">References &amp; regulatory sources</h2>
          <p class="sources-subtitle">Federal standards, approved laboratory listings, and statutory compliance guidelines</p>
        </div>

        <div class="sources-grid">
          <a href="https://www.transportation.gov/odapc/part40" rel="noopener" target="_blank" class="source-item">
            <div class="source-icon">🏛️</div>
            <div class="source-info">
              <strong>U.S. DOT — 49 CFR Part 40</strong>
              <span>Procedures for Transportation Workplace Drug and Alcohol Testing Programs</span>
            </div>
            <div class="source-arrow">&nearr;</div>
          </a>

          <a href="https://www.samhsa.gov/workplace/drug-testing/certified-lab-list" rel="noopener" target="_blank" class="source-item">
            <div class="source-icon">🔬</div>
            <div class="source-info">
              <strong>SAMHSA — HHS-Certified Laboratories List</strong>
              <span>Substance Abuse &amp; Mental Health Services Administration certified labs</span>
            </div>
            <div class="source-arrow">&nearr;</div>
          </a>

          <a href="https://clearinghouse.fmcsa.dot.gov/" rel="noopener" target="_blank" class="source-item">
            <div class="source-icon">🚛</div>
            <div class="source-info">
              <strong>FMCSA — Drug &amp; Alcohol Clearinghouse</strong>
              <span>Federal Motor Carrier Safety Administration official driver registry</span>
            </div>
            <div class="source-arrow">&nearr;</div>
          </a>

          <a href="https://www.transportation.gov/odapc" rel="noopener" target="_blank" class="source-item">
            <div class="source-icon">⚖️</div>
            <div class="source-info">
              <strong>U.S. DOT Office of Drug &amp; Alcohol Policy &amp; Compliance (ODAPC)</strong>
              <span>Federal regulatory guidance, interpretations, and safety protocols</span>
            </div>
            <div class="source-arrow">&nearr;</div>
          </a>
        </div>

        <div class="sources-footer">
          <div class="sources-audit">
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
            <div>
              <strong>Compliance Audit &amp; Clinical Accuracy:</strong> Written by the Certified Drug Test Centers compliance team. Last reviewed and updated: <time datetime="2026-11-03">November 3, 2026</time>. Information on this page is for general education and is not medical or legal advice.
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===== FINAL CTA ===== -->
  <section class="final" aria-labelledby="final-h">
    <div class="wrap">
      <h2 id="final-h">Get tested today at a certified center near you</h2>
      <p>Order within minutes, get your donor pass instantly, and walk in at any of 20,000+ sites nationwide.</p>
      <div class="cta-row" style="display:flex; justify-content:center; gap:14px; flex-wrap:wrap; margin-top:20px;">
        <a class="btn btn-primary" href="{{ url('/checkout') }}" style="background:#C1121F; color:#fff; border-color:#C1121F; padding:12px 26px; font-weight:700;">Schedule My Test</a>
        <a class="btn btn-ghost" href="tel:+18009854339" style="border:2px solid #fff; color:#fff; padding:12px 26px; font-weight:700; text-decoration:none;">📞 Call (800) 985-4339</a>
      </div>
    </div>
  </section>

  <nav class="sticky-call" aria-label="Quick actions">
    <a href="tel:+18009854339">&#128222; Call Now</a>
    <a href="{{ url('/checkout') }}">Order Test Online</a>
  </nav>
</div>

<!-- Structured Data (JSON-LD) for 100% SEO Dominance -->
@if(!empty($schemaGraph))
<script type="application/ld+json">
{!! json_encode($schemaGraph, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
@endif
@endsection
