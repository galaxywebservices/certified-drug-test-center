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
                {!! (!empty($homeSettings['hero_badge']) && !str_contains($homeSettings['hero_badge'], 'Express Online Drug')) ? $homeSettings['hero_badge'] : 'Nationwide - All States - All CITIES' !!}
                <span style="color:#C1121F;">★</span>
            </div>

            <h1>
                {!! $homeSettings['hero_title'] ?? 'Accredited Drug Testing Made <span class="highlight-red">Fast, Simple &amp; Confidential</span>' !!}
            </h1>

            <p>
                {{ $homeSettings['hero_subtitle'] ?? 'Get your electronic donor pass in 2 minutes. Walk in today at over 20,000 Quest Diagnostics and Labcorp certified collection sites nationwide. No doctor order or appointment necessary.' }}
            </p>

            <ul class="hero-split-checklist">
                @foreach($homeSettings['hero_bullets'] ?? [
                    '20,000+ Quest & Labcorp Sites',
                    'SAMHSA Certified Laboratories',
                    'Physician MRO Verification',
                    'Court & DOT Legally Defensible'
                ] as $bullet)
                <li>
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    {{ $bullet }}
                </li>
                @endforeach
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

        <!-- Right Side: Express Online Order -->
        <div class="hero-split-right">
            <div class="quick-estimator-card">
                <div class="estimator-header">
                    <h3>
                        <svg width="22" height="22" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V4a2 2 0 00-2-2H6zm1 2a1 1 0 000 2h6a1 1 0 100-2H7zm6 7a1 1 0 011 1v3a1 1 0 11-2 0v-3a1 1 0 011-1zm-3 3a1 1 0 100 2h.01a1 1 0 100-2H10zm-4 1a1 1 0 011-1h.01a1 1 0 110 2H7a1 1 0 01-1-1zm1-4a1 1 0 100 2h.01a1 1 0 100-2H7zm2 1a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zm4-4a1 1 0 100 2h.01a1 1 0 100-2H13zM9 9a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1zM7 8a1 1 0 100 2h.01a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                        @php
                            $estHeading = $homeSettings['estimator_title'] ?? 'Express Online Order';
                            if (str_contains($estHeading, 'Selector') || str_contains($estHeading, 'Estimator') || $estHeading === 'Online Test Order' || $estHeading === 'Express Online Scheduling') {
                                $estHeading = 'Express Online Order';
                            }
                        @endphp
                        {{ $estHeading }}
                    </h3>
                    <p>{{ $homeSettings['estimator_subtitle'] ?? 'Select your testing criteria to instantly view pricing and schedule online' }}</p>
                </div>

                <div class="estimator-field">
                    <label class="estimator-label" for="estReason">1. Reason for Testing</label>
                    <select id="estReason" class="estimator-select" onchange="handleEstimatorReasonChange(this.value)">
                        <option value="Pre-Employment">Pre-Employment</option>
                        <option value="Random">Random</option>
                        <option value="Reasonable Suspicion">Reasonable Suspicion</option>
                        <option value="Post-Accident">Post-Accident</option>
                        <option value="Follow-Up">Follow-Up</option>
                        <option value="Return to Duty">Return to Duty</option>
                    </select>
                </div>

                <div class="estimator-field">
                    <label class="estimator-label" for="estMethod">2. Select your Testing Method</label>
                    <select id="estMethod" class="estimator-select" onchange="handleEstimatorMethodChange(this.value)">
                        <option value="urine">Urine Tests</option>
                        <option value="dot">DOT Tests/Services</option>
                        <option value="hair">Hair Tests</option>
                        <option value="alcohol">Alcohol/EtG Tests</option>
                        <option value="oral">Oral Fluid Tests</option>
                        <option value="occupational">Occupational Tests (OCC Health)</option>
                        <option value="clinical">Clinical Tests</option>
                        <option value="dna">DNA Tests</option>
                    </select>
                </div>

                <div class="estimator-field" id="estDotAgencyGroup" style="display:none;">
                    <label class="estimator-label" for="estDotAgency">DOT Regulated Agency / Mode</label>
                    <select id="estDotAgency" class="estimator-select" onchange="handleEstimatorAgencyChange(this.value)">
                        <option value="FMCSA">FMCSA (Federal Motor Carrier Safety Administration)</option>
                        <option value="FAA">FAA (Federal Aviation Administration)</option>
                        <option value="USCG">USCG (United States Coast Guard)</option>
                        <option value="FTA">FTA (Federal Transit Administration)</option>
                        <option value="PHMSA">PHMSA (Pipeline &amp; Hazardous Materials Safety)</option>
                        <option value="FRA">FRA (Federal Railroad Administration)</option>
                    </select>
                </div>

                <div class="estimator-field">
                    <label class="estimator-label" for="estSpecimen">3. Select Specimen or Test Panel</label>
                    <select id="estSpecimen" class="estimator-select" onchange="updateEstimatorDisplay()">
                        <option value="5-panel-non-dot" data-name="5 Panel Non-DOT Urine Test (Basic)" data-price="89.99" data-turnaround="24-48 hours">5 Panel Non-DOT Urine Test (Basic)</option>
                        <option value="10-panel" data-name="10 Panel Comprehensive Urine Test" data-price="109.99" data-turnaround="24-48 hours">10 Panel Comprehensive Urine Test</option>
                        <option value="12-panel-comprehensive" data-name="12 Panel Maximum Coverage Urine Test" data-price="139.99" data-turnaround="24-48 hours">12 Panel Maximum Coverage Urine Test</option>
                        <option value="5-panel-expanded-opiates" data-name="5 Panel + Expanded Opiates Urine Test" data-price="99.99" data-turnaround="24-48 hours">5 Panel + Expanded Opiates Urine Test</option>
                        <option value="10-panel-expanded-opiates" data-name="10 Panel + Expanded Opiates Urine Test" data-price="119.99" data-turnaround="24-48 hours">10 Panel + Expanded Opiates Urine Test</option>
                    </select>
                </div>

                <div class="estimator-price-display">
                    <div style="font-size:15px; font-weight:800; color:var(--color-primary); line-height:1.2;" id="estPanelName">
                        5 Panel Non-DOT Urine Test (Basic)
                    </div>
                    <div class="estimator-price-val" id="estPriceVal">$89.99</div>
                    <div class="estimator-features-preview" id="estTurnaround" style="font-size:12.5px; color:#166534; font-weight:600; margin-top:4px;">
                        Includes: Laboratory Analysis, MRO/Physician Verified, Results 24-48 hours
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-lg" style="width:100%; margin-top:16px; background:#C1121F; color:#fff;" onclick="handleEstimatorOrder()">
                    @php
                        $estBtnText = $homeSettings['estimator_button'] ?? 'Schedule Online Now';
                        if (str_contains($estBtnText, 'Register & Obtain')) {
                            $estBtnText = 'Schedule Online Now';
                        }
                    @endphp
                    {{ $estBtnText }}
                </button>
            </div>
        </div>
    </div>
</section>

<script>
// Bulletproof Estimator Logic (inlined to guarantee execution without cache interference)
(function() {
    function initEstimatorDefense() {
        var rSelect = document.getElementById('estReason');
        var mSelect = document.getElementById('estMethod');
        var sSelect = document.getElementById('estSpecimen');
        var dotAgencyGroup = document.getElementById('estDotAgencyGroup');

        if (!rSelect || !mSelect) return;

        var lastValidReason = rSelect.value || 'Pre-Employment';

        // Override setter of rSelect.value to block setting invalid/blank values like 'dot'
        try {
            var proto = HTMLSelectElement.prototype;
            var originalValSetter = Object.getOwnPropertyDescriptor(proto, 'value').set;
            var originalValGetter = Object.getOwnPropertyDescriptor(proto, 'value').get;

            Object.defineProperty(rSelect, 'value', {
                get: function() {
                    return originalValGetter.call(this);
                },
                set: function(val) {
                    if (val === 'dot' || !val) {
                        return; // Ignore invalid values that would clear or blank out the dropdown
                    }
                    originalValSetter.call(this, val);
                    if (this.selectedIndex >= 0 && this.value) {
                        lastValidReason = this.value;
                    }
                },
                configurable: true
            });
        } catch(e) {}

        rSelect.addEventListener('change', function() {
            if (this.value && this.value !== 'dot') {
                lastValidReason = this.value;
            }
        });

        function ensureReasonValid() {
            if (!rSelect.value || rSelect.selectedIndex < 0) {
                try {
                    var proto = HTMLSelectElement.prototype;
                    var originalValSetter = Object.getOwnPropertyDescriptor(proto, 'value').set;
                    originalValSetter.call(rSelect, lastValidReason || 'Pre-Employment');
                } catch(e) {
                    rSelect.value = lastValidReason || 'Pre-Employment';
                }
            }
        }

        window.handleEstimatorReasonChange = function(reason) {
            if (reason && reason !== 'dot') {
                lastValidReason = reason;
            }
            ensureReasonValid();
        };

        window.handleEstimatorMethodChange = function(method) {
            ensureReasonValid();

            if (dotAgencyGroup) {
                dotAgencyGroup.style.display = (method === 'dot') ? 'block' : 'none';
            }

            var panels = {
                urine: [
                    { value: '5-panel-non-dot', name: '5 Panel Non-DOT Urine Test (Basic)', price: '89.99', turnaround: '24-48 hours' },
                    { value: '10-panel', name: '10 Panel Comprehensive Urine Test', price: '109.99', turnaround: '24-48 hours' },
                    { value: '12-panel-comprehensive', name: '12 Panel Maximum Coverage Urine Test', price: '139.99', turnaround: '24-48 hours' },
                    { value: '5-panel-expanded-opiates', name: '5 Panel + Expanded Opiates Urine Test', price: '99.99', turnaround: '24-48 hours' },
                    { value: '10-panel-expanded-opiates', name: '10 Panel + Expanded Opiates Urine Test', price: '119.99', turnaround: '24-48 hours' }
                ],
                dot: [
                    { value: '5-panel-dot', name: '5 Panel DOT Federal Urine Screen', price: '99.99', turnaround: '24-48 hours' },
                    { value: 'dot-breath-alcohol', name: 'Breath Alcohol Test (BAT / EBT)', price: '89.99', turnaround: 'Instant Reading' },
                    { value: '5-panel-dot-breath-alcohol', name: '5 Panel DOT & Breath Alcohol Combo', price: '169.99', turnaround: 'Same-Day / 24-48 hrs' },
                    { value: 'dot-physical', name: 'DOT Physical Exam (NRCME Doctor)', price: '159.99', turnaround: 'Same-Day Card' },
                    { value: 'dot-drug-test-physical', name: 'DOT Drug Test & Physical Exam Combo', price: '239.99', turnaround: 'Complete DOT Clearance' },
                    { value: '5-panel-return-to-duty', name: '5 Panel Return to Duty (RTD) Test', price: '99.99', turnaround: 'Directly Observed / 24-48 hrs' },
                    { value: 'dot-uscg-drug-test', name: 'DOT USCG Merchant Mariner Drug Test', price: '99.99', turnaround: 'Coast Guard Form 719P' },
                    { value: '1-year-enrollment', name: '1-Year DOT Consortium Enrollment', price: '99.99', turnaround: 'Instant Certificate' },
                    { value: '1-year-consortium-membership-dot-drug-test', name: '1-Year Consortium + DOT Drug Test', price: '249.99', turnaround: 'Instant Certificate & Pass' },
                    { value: 'fmcsa-clearinghouse-accucheck', name: 'FMCSA Clearinghouse Services', price: '199.99', turnaround: 'Full Query & Violation Support' }
                ],
                hair: [
                    { value: 'hair-follicle-5-panel', name: 'Hair Follicle 5-Panel (90-Day History)', price: '169.99', turnaround: '2-3 Business Days' },
                    { value: 'hair-follicle-10-panel', name: 'Hair Follicle 10-Panel Comprehensive', price: '249.99', turnaround: '2-3 Business Days' },
                    { value: 'hair-follicle-etg', name: 'Hair Follicle Alcohol EtG (3-Month History)', price: '199.99', turnaround: '3-5 Business Days' }
                ],
                alcohol: [
                    { value: 'dot-breath-alcohol', name: 'Breath Alcohol Test (BAT / EBT)', price: '89.99', turnaround: 'Instant Reading' },
                    { value: 'etg-urine-alcohol', name: '80-Hour EtG Urine Alcohol Test', price: '89.99', turnaround: '24-48 hours' },
                    { value: 'hair-follicle-etg', name: 'Hair Follicle Alcohol EtG (90-Day)', price: '199.99', turnaround: '3-5 Business Days' }
                ],
                oral: [
                    { value: 'oral-fluid-6-panel', name: 'Oral Fluid 6-Panel Saliva Drug Test', price: '109.99', turnaround: '24-48 hours' },
                    { value: 'oral-fluid-10-panel', name: 'Oral Fluid 10-Panel Saliva Drug Test', price: '129.99', turnaround: '24-48 hours' }
                ],
                occupational: [
                    { value: 'fit-for-duty', name: 'Fit-For-Duty Medical Examination', price: '179.99', turnaround: 'Comprehensive Report' },
                    { value: 'tb-skin-test', name: 'TB Skin Test (Mantoux PPD)', price: '79.99', turnaround: '48-72 Hour Read' },
                    { value: 'respirator-clearance', name: 'OSHA Respirator Clearance Exam', price: '99.99', turnaround: 'Same-Day Clearance' }
                ],
                clinical: [
                    { value: 'comprehensive-health-profile', name: 'Comprehensive Health Profile (CBC & CMP)', price: '99.99', turnaround: '24-48 hours' },
                    { value: 'heavy-metals-blood-panel', name: 'Heavy Metals Comprehensive Blood Panel', price: '149.99', turnaround: '2-3 Business Days' },
                    { value: 'hepatitis-b-c-panel', name: 'Hepatitis B & C Antibody Blood Panel', price: '89.99', turnaround: '24-48 hours' }
                ],
                dna: [
                    { value: 'legal-paternity-dna-test', name: 'Legal Paternity DNA Test (Court Admissible)', price: '289.99', turnaround: '2-3 Business Days' },
                    { value: 'non-invasive-prenatal-paternity-nipp', name: 'Non-Invasive Prenatal Paternity (NIPP)', price: '999.00', turnaround: '5-7 Business Days' },
                    { value: 'informational-paternity-kit', name: 'Informational At-Home Paternity Kit', price: '179.99', turnaround: '3-5 Business Days' }
                ]
            };

            if (sSelect) {
                var methodPanels = panels[method] || panels['urine'];
                sSelect.innerHTML = '';
                methodPanels.forEach(function(p) {
                    var opt = document.createElement('option');
                    opt.value = p.value;
                    opt.setAttribute('data-name', p.name);
                    opt.setAttribute('data-price', p.price);
                    opt.setAttribute('data-turnaround', p.turnaround);
                    opt.textContent = p.name;
                    sSelect.appendChild(opt);
                });
            }

            if (typeof updateEstimatorDisplay === 'function') {
                updateEstimatorDisplay();
            }

            ensureReasonValid();
        };

        setInterval(ensureReasonValid, 150);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initEstimatorDefense);
    } else {
        initEstimatorDefense();
    }
    window.addEventListener('load', initEstimatorDefense);
})();
</script>

<!-- Interactive Substance Lookup Tool -->
<section class="section section-light" id="substance-checker" aria-labelledby="substanceToolTitle">
    <div class="container container-narrow">
        <div class="substance-checker-box">
            <div style="text-align:center; margin-bottom:20px;">
                <span class="section-eyebrow">{{ $homeSettings['substance_eyebrow'] ?? 'Smart Drug Screening Tool' }}</span>
                <h2 style="font-family:var(--font-heading); font-size:24px; font-weight:800; color:var(--color-primary);" id="substanceToolTitle">
                    {{ $homeSettings['substance_title'] ?? 'Looking For A Specific Drug Or Medication?' }}
                </h2>
                <p style="font-size:14px; color:var(--color-text-muted);">
                    {{ $homeSettings['substance_subtitle'] ?? 'Type a drug name, medication, or substance below to find which testing panel detects it.' }}
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

<!-- Horizontal 4-Step Express Timeline -->
<style>
    /* Section & Card Spacing - Desktop */
    .hero-split {
        padding: 36px 0 24px !important;
    }
    #substance-checker.section {
        padding: 20px 0 24px !important;
    }
    .substance-checker-box {
        margin-bottom: 0 !important;
    }

    /* Section & Card Spacing - Mobile (Completely eliminates large voids) */
    @media (max-width: 768px) {
        .section {
            padding: 16px 0 !important;
        }
        .hero-split {
            padding: 16px 0 8px !important;
        }
        .hero-split-grid {
            gap: 12px !important;
        }
        .quick-estimator-card {
            padding: 14px 14px !important;
        }
        #substance-checker.section {
            padding: 4px 0 6px !important;
        }
        .substance-checker-box {
            padding: 14px 14px 10px !important;
            margin-bottom: 0 !important;
        }
        .section-header {
            margin: 0 auto 12px !important;
        }
        .section-eyebrow {
            font-size: 11px !important;
            margin-bottom: 4px !important;
        }
        .section-title {
            font-size: 22px !important;
            margin-bottom: 6px !important;
            line-height: 1.22 !important;
        }
        .section-desc {
            font-size: 13.5px !important;
            line-height: 1.4 !important;
        }
    }

    .process-grid-4-wrap {
        display: grid !important;
        grid-template-columns: repeat(4, 1fr) !important;
        gap: 20px !important;
        margin-top: 30px !important;
    }
    .process-card-step {
        background: #FFFFFF !important;
        border: 1px solid #E2E8F0 !important;
        border-top: 3px solid #E2E8F0 !important;
        border-radius: 12px !important;
        padding: 26px 20px !important;
        text-align: left !important;
        height: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease !important;
        box-shadow: 0 2px 8px rgba(11,37,69,0.04) !important;
    }
    .process-card-step:hover {
        transform: translateY(-4px) !important;
        border-color: #0B2545 !important;
        border-top-color: #C1121F !important;
        box-shadow: 0 8px 20px rgba(11,37,69,0.08) !important;
    }
    .process-step-num {
        font-family: var(--font-heading, 'Montserrat', sans-serif) !important;
        font-size: 30px !important;
        font-weight: 800 !important;
        color: #C1121F !important;
        margin-bottom: 10px !important;
        line-height: 1 !important;
    }
    .process-card-step h3 {
        font-family: var(--font-heading, 'Montserrat', sans-serif) !important;
        font-size: 17px !important;
        font-weight: 800 !important;
        color: #0B2545 !important;
        margin: 0 0 8px 0 !important;
        letter-spacing: -0.2px !important;
    }
    .process-card-step p {
        font-size: 13.5px !important;
        color: #64748B !important;
        line-height: 1.5 !important;
        margin: 0 !important;
        flex-grow: 1 !important;
    }
    @media (max-width: 1024px) {
        .process-grid-4-wrap {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 16px !important;
        }
    }
    @media (max-width: 600px) {
        .process-grid-4-wrap {
            grid-template-columns: 1fr !important;
            margin-top: 10px !important;
            gap: 10px !important;
        }
        .process-card-step {
            padding: 14px 16px !important;
            border-radius: 10px !important;
        }
        .process-step-num {
            font-size: 20px !important;
            margin-bottom: 4px !important;
        }
        .process-card-step h3 {
            font-size: 15px !important;
            margin-bottom: 4px !important;
        }
        .process-card-step p {
            font-size: 13px !important;
        }
    }
</style>

<section class="section section-white" aria-label="Process Overview">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">{{ $homeSettings['timeline_eyebrow'] ?? 'Zero Waiting Time' }}</span>
            <h2 class="section-title">{{ $homeSettings['timeline_title'] ?? 'The Fastest Way To Complete A Drug Test' }}</h2>
            <p class="section-desc">{{ $homeSettings['timeline_subtitle'] ?? 'Our online scheduling system gets you tested and on with your day.' }}</p>
        </div>

        <div class="process-grid-4-wrap">
            <div class="process-card-step">
                <div class="process-step-num">Step 1</div>
                <h3>{{ $homeSettings['step1_title'] ?? 'Choose Test & Register' }}</h3>
                <p>{{ $homeSettings['step1_desc'] ?? 'Select your testing panel online. Enter donor details and zip code to locate the nearest collection facility.' }}</p>
            </div>
            <div class="process-card-step">
                <div class="process-step-num">Step 2</div>
                <h3>{{ $homeSettings['step2_title'] ?? 'Instant Donor Pass' }}</h3>
                <p>{{ $homeSettings['step2_desc'] ?? 'A registration confirmation pass with barcode and site directions is immediately sent to your email and phone.' }}</p>
            </div>
            <div class="process-card-step">
                <div class="process-step-num">Step 3</div>
                <h3>{{ $homeSettings['step3_title'] ?? 'Walk-In Collection' }}</h3>
                <p>{{ $homeSettings['step3_desc'] ?? 'Show your pass on your smartphone. The certified collection site handles testing with SAMHSA laboratory analysis.' }}</p>
            </div>
            <div class="process-card-step">
                <div class="process-step-num">Step 4</div>
                <h3>{{ $homeSettings['step4_title'] ?? 'Fast Electronic Results' }}</h3>
                <p>{{ $homeSettings['step4_desc'] ?? 'Negative Results sent out via email within 24-48 hours.' }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Full Product Grid with Filter Tabs -->
<section class="section section-light" id="products-section" aria-labelledby="allPanelsTitle">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">{{ $homeSettings['catalog_eyebrow'] ?? 'TESTS & PRICING' }}</span>
            <h2 class="section-title" id="allPanelsTitle">{{ $homeSettings['catalog_title'] ?? 'Drug & Alcohol Testing Options' }}</h2>
            <p class="section-desc">
                {{ $homeSettings['catalog_subtitle'] ?? 'Clear upfront pricing with no hidden laboratory fees or collection charges.' }}
            </p>
        </div>

        <div class="filter-tabs">
            <button type="button" class="filter-tab-btn active" data-filter="all">All Services</button>
            <button type="button" class="filter-tab-btn" data-filter="urine">Urine Panels</button>
            <button type="button" class="filter-tab-btn" data-filter="dot">DOT Regulated</button>
            <button type="button" class="filter-tab-btn" data-filter="hair">Hair Follicle</button>
            <button type="button" class="filter-tab-btn" data-filter="alcohol">Alcohol &amp; EtG</button>
            <button type="button" class="filter-tab-btn" data-filter="oral">Oral Fluid</button>
            <button type="button" class="filter-tab-btn" data-filter="occupational">Occupational (OCC Health)</button>
            <button type="button" class="filter-tab-btn" data-filter="clinical">Clinical Blood</button>
            <button type="button" class="filter-tab-btn" data-filter="dna">DNA Testing</button>
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
            <span class="section-eyebrow">{{ $homeSettings['matrix_eyebrow'] ?? 'Panel Breakdown' }}</span>
            <h2 class="section-title" id="compTableTitle">{{ $homeSettings['matrix_title'] ?? 'Side-by-Side Substance Detection Matrix' }}</h2>
            <p class="section-desc">{{ $homeSettings['matrix_subtitle'] ?? 'Quick reference table showing which drugs are screened in each panel level.' }}</p>
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
                        <td data-label="Drug / Metabolite"><strong>{{ $row['substance'] }}</strong></td>
                        <td data-label="Class">{{ $row['category'] }}</td>
                        <td style="text-align:center;" data-label="5 Panel ($89.99)">
                            @if($row['panel5'] === true)
                                <span class="check-yes">✓ Yes</span>
                            @else
                                <span class="check-no">—</span>
                            @endif
                        </td>
                        <td style="text-align:center;" data-label="10 Panel ($109.99)">
                            @if($row['panel10'] === true)
                                <span class="check-yes">✓ Yes</span>
                            @elseif($row['panel10'] === 'Add-on')
                                <span class="check-addon">Add-On</span>
                            @else
                                <span class="check-no">—</span>
                            @endif
                        </td>
                        <td style="text-align:center;" data-label="12 Panel ($139.99)">
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
            <span class="section-eyebrow">{{ $homeSettings['locations_eyebrow'] ?? 'National Directory' }}</span>
            <h2 class="section-title" id="statesDirectoryTitle">{{ $homeSettings['locations_title'] ?? 'Browse Collection Centers By State' }}</h2>
            <p class="section-desc">{{ $homeSettings['locations_subtitle'] ?? 'More than 20,000 collection sites serving every metropolitan and regional area.' }}</p>
        </div>

        <div style="background:#FEF2F2; border:1px solid #FECACA; border-radius:8px; padding:12px 18px; margin-bottom:20px; text-align:center; color:#991B1B; font-size:13.5px; font-weight:600;">
            <span style="color:#16A34A; font-weight:800;">✓ Walk-Ins Accepted Today</span> &bull; <strong style="color:#C1121F;">Pre-Registration Required:</strong> You must receive a registration form/donor pass prior to proceeding to the testing center.
        </div>

        <div class="state-search-bar">
            <input type="text" id="stateSearchInput" class="zip-input" placeholder="Search state name..." style="padding-left:16px;">
        </div>

        <div class="states-grid" id="statesGrid">
            @foreach($states as $st)
            <a href="{{ url('/locations/' . \Illuminate\Support\Str::slug($st['name'])) }}" class="state-chip" data-state="{{ $st['name'] }}">
                <span>{{ $st['name'] }} Drug Testing</span>
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
            <span class="section-eyebrow">{{ $homeSettings['faq_eyebrow'] ?? 'Help & Support' }}</span>
            <h2 class="section-title" id="faqTitle2">{{ $homeSettings['faq_title'] ?? 'Frequently Asked Questions' }}</h2>
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
