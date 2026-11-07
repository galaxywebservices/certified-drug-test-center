@extends('layouts.main')

@section('content')
<!-- Top CMS Bar matching sample structure -->
<div class="cms-hero-bar">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Breadcrumb" style="display:flex; gap:8px; font-size:13px; color:#94A3B8; margin-bottom:12px;">
            <a href="{ url('/') }" style="color:#CBD5E1; text-decoration:none;">Home</a>
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
          <span class="eyebrow">Nationwide &#xB7; All 50 States</span>
          <h1>Certified Drug Test Centers Near You</h1>
          <p class="lead"><strong>Certified Drug Test Centers</strong> are located in all cities and in most cases within minutes of your home or office. Order a drug or alcohol test online or call and receive an electronic donor pass via email or text immediately. Same-day testing available for employment, DOT, probation and personal purposes at more than 20,000 certified drug testing centers &#x2014; including Quest Diagnostics, Labcorp and affiliated locations. Negative results are typically available within <strong>24&#x2013;48 hours</strong>.</p>
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
          <li>20,000+ Quest &amp; Labcorp sites</li>
          <li>SAMHSA-certified laboratories</li>
          <li>Physician MRO review included</li>
          <li>DOT-compliant &amp; legally defensible</li>
          <li>Order Today, Test Today</li>
          <li>No hidden fees at the testing site</li>
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
        <h2 id="qa-h">Quick answer: how to get a drug or alcohol test near you today</h2>
        <p>To get a drug or alcohol test near you, order the test online or by phone and within minutes receive your electronic donor pass by email and text, then walk in with a photo ID to the nearest certified collection site. Certified Drug Test Centers schedules same-day urine, hair follicle, saliva, breath alcohol, EtG and DOT drug tests at 20,000+ drug testing centers in all 50 states, with prices from $89.99 and results in 24&#x2013;48 hours for most negative urine tests.</p>
      </div>
      <div class="facts">
        <div class="fact"><strong>20,000+</strong><span>certified collection sites</span></div>
        <div class="fact"><strong>50</strong><span>states covered</span></div>
        <div class="fact"><strong>24&#x2013;48 hrs</strong><span>typical negative results</span></div>
        <div class="fact"><strong>$89.99</strong><span>starting price, all-inclusive</span></div>
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
        <span class="eyebrow">For employers</span>
        <h2 id="emp-h">Employer drug testing programs &amp; on-site mobile testing</h2>
        <p>Businesses of every size use Certified Drug Test Centers for employee drug screening and compliant, nationwide drug-free workplace programs from one account &#x2014; whether you hire one employee a year or manage a multi-state fleet.</p>
        <ul class="tick">
          <li>Corporate accounts with volume pricing and an online results portal</li>
          <li>Pre-employment, random, post-accident and reasonable-suspicion testing</li>
          <li>On-site mobile collections for 1 to 500+ employees at job sites, warehouses and offices</li>
          <li>DOT consortium/TPA services and MIS reporting assistance</li>
          <li>Background checks and motor vehicle records (MVR)</li>
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
      <span class="eyebrow">National directory</span>
      <h2 id="loc-h">Find drug testing centers by state</h2>
      <p class="lead">Certified Drug Test Centers has collection sites in all 50 states, from major metro areas to rural communities. Choose your state to see drug testing locations by city, including Quest Diagnostics and Labcorp drug test sites, or <a href="{{ url('/locations') }}">search by ZIP code</a>. Walk-ins are accepted at most sites once you've registered.</p>
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

      <details open><summary><h3>Where can I get a drug test near me?</h3></summary>
        <div class="faq-answer"><p>Certified Drug Test Centers schedules drug and alcohol tests at more than 20,000 certified collection sites in all 50 states, including Quest Diagnostics and Labcorp patient service centers. Enter your ZIP code online or call (800) 985-4339 to find the closest site, register within minutes, and walk in the same day.</p></div></details>

      <details><summary><h3>How much does a drug test cost?</h3></summary>
        <div class="faq-answer"><p>A 5-panel urine drug test costs $89.99, a 10-panel costs $109.99, a 12-panel costs $139.99, a DOT 5-panel costs $99.99, and a 5-panel hair follicle test costs $169.99. Prices include the collection, laboratory analysis and Medical Review Officer (MRO) review, with no fees paid at the testing site.</p></div></details>

      <details><summary><h3>Can I get a same-day drug test?</h3></summary>
        <div class="faq-answer"><p>Yes. Most people order and test on the same day. Once you register online or by phone, your electronic donor pass arrives within minutes, and you can walk in to a nearby certified drug testing center that day during its collection hours. No appointment is needed at most locations.</p></div></details>

      <details><summary><h3>Where can I get a pre-employment drug test near me?</h3></summary>
        <div class="faq-answer"><p>You can get a pre-employment drug test at any of 20,000+ certified collection sites nationwide, including Quest Diagnostics and Labcorp locations. Order the panel your employer requested (usually a 5-panel or 10-panel urine test), get your donor pass within minutes, and walk in with a photo ID.</p></div></details>

      <details><summary><h3>Can I get a drug test at Quest Diagnostics or Labcorp?</h3></summary>
        <div class="faq-answer"><p>Yes. Certified Drug Test Centers schedules drug tests at Quest Diagnostics and Labcorp patient service centers across the country. Quest and Labcorp sites require pre-registration and do not take payment on site, so you order through us first and receive a donor pass to bring with you.</p></div></details>

      <details><summary><h3>Where can I get a DOT drug test near me?</h3></summary>
        <div class="faq-answer"><p>DOT drug tests are available at certified collection sites in all 50 states. Order the DOT 5-panel drug test ($99.99), choose the closest site by ZIP code, and bring your donor pass, photo ID and CDL or employee ID. Collections follow 49 CFR Part 40 using a Federal Custody and Control Form.</p></div></details>

      <details><summary><h3>Can I get a drug test at urgent care?</h3></summary>
        <div class="faq-answer"><p>Some urgent care clinics offer drug testing, but prices, panels and lab standards vary and many add office-visit fees. Ordering through Certified Drug Test Centers gives you upfront all-inclusive pricing, a SAMHSA-certified lab and MRO review at a certified collection site near you.</p></div></details>

      <details><summary><h3>What is the most affordable way to get a drug test?</h3></summary>
        <div class="faq-answer"><p>Ordering online is usually the most affordable way to get a certified drug test. A 5-panel urine drug test costs $89.99 all-inclusive &#x2014; collection, SAMHSA-certified lab analysis and MRO review &#x2014; with no extra fees at the testing site.</p></div></details>

      <details><summary><h3>Can I walk in for a drug test without an appointment?</h3></summary>
        <div class="faq-answer"><p>Yes. Most collection sites accept walk-ins, but you must register and pay before you go. After you order, you receive an electronic donor pass that you show at the site along with a photo ID. Testing sites do not accept payment on site.</p></div></details>

      <details><summary><h3>How long do drug test results take?</h3></summary>
        <div class="faq-answer"><p>Negative urine results are typically available within 24&#x2013;48 hours of collection. Hair tests take 2&#x2013;4 business days. If an initial screen is non-negative, the sample is confirmed by GC/MS or LC/MS and reviewed by a Medical Review Officer, which can add 24&#x2013;72 hours. Breath alcohol results are immediate.</p></div></details>

      <details><summary><h3>What is the difference between a 5-panel and a 10-panel drug test?</h3></summary>
        <div class="faq-answer"><p>A 5-panel drug test screens for amphetamines (including methamphetamine), cocaine, marijuana (THC), opiates and PCP. A 10-panel test screens for those five plus barbiturates, benzodiazepines, methadone, methaqualone and propoxyphene. A 12-panel adds tramadol, meperidine and expanded opiates such as oxycodone and hydrocodone.</p></div></details>

      <details><summary><h3>What does a DOT drug test check for?</h3></summary>
        <div class="faq-answer"><p>A DOT drug test under 49 CFR Part 40 screens urine for five drug classes: marijuana metabolites, cocaine metabolites, amphetamines (amphetamine, methamphetamine, MDMA, MDA), opioids (codeine, morphine, 6-acetylmorphine/heroin, hydrocodone, hydromorphone, oxycodone, oxymorphone) and phencyclidine (PCP). It must use a Federal Custody and Control Form, a SAMHSA/HHS-certified laboratory and MRO review.</p></div></details>

      <details><summary><h3>How far back does a drug test go?</h3></summary>
        <div class="faq-answer"><p>A urine test usually detects drug use from the past 1&#x2013;3 days for most substances, and up to 30 days or more for heavy, chronic marijuana use. A hair follicle test covers about the past 90 days. A saliva (oral fluid) test detects use from roughly the past 24&#x2013;48 hours. An EtG urine alcohol test detects drinking up to about 80 hours prior.</p></div></details>

      <details><summary><h3>What do I need to bring to my drug test?</h3></summary>
        <div class="faq-answer"><p>Bring your electronic donor pass (on your phone or printed) and a valid government-issued photo ID such as a driver's license or passport. For DOT tests, also have your CDL or employee ID number. Do not drink excessive fluids beforehand, as a diluted sample may require a retest.</p></div></details>

      <details><summary><h3>Are your drug test results legally defensible?</h3></summary>
        <div class="faq-answer"><p>Yes. Specimens are collected under strict chain-of-custody procedures and analyzed by SAMHSA-certified laboratories. Non-negative results are confirmed by GC/MS or LC/MS and reviewed by an independent, licensed Medical Review Officer, making results suitable for employment, DOT compliance and court purposes.</p></div></details>

      <details><summary><h3>Do you offer drug testing for court or probation?</h3></summary>
        <div class="faq-answer"><p>Yes. Court-ordered and probation testing is available with chain-of-custody documentation, including urine panels, EtG alcohol tests that detect drinking up to about 80 hours prior, and 90-day hair follicle tests. Always confirm the exact test your court or probation officer requires before ordering.</p></div></details>

      <details><summary><h3>Can I order a drug test for myself or a family member?</h3></summary>
        <div class="faq-answer"><p>Yes. Individuals can order personal or family drug tests online without an employer or doctor's order. Results are confidential and sent only to the email provided at registration.</p></div></details>

      <details><summary><h3>Do you offer on-site mobile drug testing for employers?</h3></summary>
        <div class="faq-answer"><p>Yes. Certified collectors can travel to job sites, offices, warehouses and construction projects nationwide to test from 1 to 500+ employees, including post-accident and reasonable-suspicion testing. Employers can also open a corporate account for volume pricing and an online results portal.</p></div></details>

      <details><summary><h3>What is a Medical Review Officer (MRO)?</h3></summary>
        <div class="faq-answer"><p>A Medical Review Officer is a licensed physician trained to review laboratory drug test results. Before a non-negative result is reported, the MRO contacts the donor to check for legitimate medical explanations, such as a valid prescription. Every test ordered through Certified Drug Test Centers includes MRO review.</p></div></details>

      <details><summary><h3>Do you test in Spanish?</h3></summary>
        <div class="faq-answer"><p>Yes. Our scheduling team speaks Spanish. Call (800) 985-4339 for help ordering a test in Spanish.</p></div></details>
    </div>
  </section>

  <!-- ===== SOURCES / E-E-A-T ===== -->
  <section id="sources" aria-labelledby="src-h">
    <div class="wrap">
      <h2 id="src-h" class="h-sm">References &amp; regulatory sources</h2>
      <ul class="sources">
        <li><a href="https://www.transportation.gov/odapc/part40" rel="noopener" target="_blank">U.S. DOT &#x2014; 49 CFR Part 40: Procedures for Transportation Workplace Drug and Alcohol Testing Programs</a></li>
        <li><a href="https://www.samhsa.gov/workplace/drug-testing/certified-lab-list" rel="noopener" target="_blank">SAMHSA &#x2014; HHS-Certified Laboratories List</a></li>
        <li><a href="https://clearinghouse.fmcsa.dot.gov/" rel="noopener" target="_blank">FMCSA &#x2014; Drug &amp; Alcohol Clearinghouse</a></li>
        <li><a href="https://www.transportation.gov/odapc" rel="noopener" target="_blank">U.S. DOT Office of Drug &amp; Alcohol Policy &amp; Compliance (ODAPC)</a></li>
      </ul>
      <p class="updated">Written by the Certified Drug Test Centers compliance team. Last reviewed and updated: <time datetime="2026-11-03">November 3, 2026</time>. Information on this page is for general education and is not medical or legal advice.</p>
    </div>
  </section>

  <!-- ===== FINAL CTA ===== -->
  <section class="final" aria-labelledby="final-h">
    <div class="wrap">
      <h2 id="final-h">Get tested today at a certified center near you</h2>
      <p>Order within minutes, get your donor pass instantly, and walk in at any of 20,000+ sites nationwide.</p>
      <div class="cta-row">
        <a class="btn btn-primary" href="{{ url('/checkout') }}">Schedule My Test</a>
        <a class="btn btn-ghost" href="tel:+18009854339">Call (800) 985-4339</a>
      </div>
    </div>
  </section>
<nav class="sticky-call" aria-label="Quick actions">
  <a href="tel:+18009854339">&#128222; Call Now</a>
  <a href="{{ url('/checkout') }}">Order Test Online</a>
</nav>
</div>
</div>

<!-- Structured Data (JSON-LD) for 100% SEO Dominance -->
@if(!empty($schemaGraph))
<script type="application/ld+json">
{!! json_encode($schemaGraph, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
</script>
@endif
@endsection
