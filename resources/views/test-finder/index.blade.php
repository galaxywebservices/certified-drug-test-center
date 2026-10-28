@extends('layouts.main')

@section('title', 'Guided Drug Test Finder & Medical Recommender | Certified Drug Test Centers')
@section('meta_description', 'Not sure which drug test you need? Answer 3 quick questions in our interactive guided test selector to find the exact certified test for employment, DOT, legal, or personal screening.')

@section('content')
<div class="test-finder-page">

    <!-- Hero Header -->
    <section class="test-finder-hero">
        <div class="container" style="text-align:center; max-width:820px;">
            <div class="finder-pill-badge">
                <svg width="15" height="15" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <span>30-Second Guided Selection Tool</span>
            </div>
            <h1 class="test-finder-title">Guided Drug Test Recommendation Wizard</h1>
            <p class="test-finder-lead">
                Answer 3 simple questions to determine the exact, certified laboratory drug test required for your workplace, DOT compliance, court mandate, or personal health verification.
            </p>
        </div>
    </section>

    <!-- Wizard Section -->
    <section class="wizard-section">
        <div class="container" style="max-width:960px;">

            <!-- Step Progress Indicator -->
            <div class="wizard-stepper">
                <div class="step-indicator active" id="stepIndicator1">
                    <div class="step-circle">1</div>
                    <span class="step-label">Purpose</span>
                </div>
                <div class="step-line" id="stepLine1"></div>
                <div class="step-indicator" id="stepIndicator2">
                    <div class="step-circle">2</div>
                    <span class="step-label">Time Window</span>
                </div>
                <div class="step-line" id="stepLine2"></div>
                <div class="step-indicator" id="stepIndicator3">
                    <div class="step-circle">3</div>
                    <span class="step-label">Substances</span>
                </div>
                <div class="step-line" id="stepLine3"></div>
                <div class="step-indicator" id="stepIndicator4">
                    <div class="step-circle">✓</div>
                    <span class="step-label">Match</span>
                </div>
            </div>

            <!-- Wizard Card Container -->
            <div class="wizard-card">

                <!-- STEP 1: PURPOSE -->
                <div class="wizard-step" id="step1">
                    <div class="step-header">
                        <span class="step-counter-tag">Question 1 of 3</span>
                        <h2 class="step-prompt">What is the primary purpose of this drug test?</h2>
                        <p class="step-subtitle">Select the reason for testing so we can ensure the proper regulatory standards and documentation are applied.</p>
                    </div>

                    <div class="options-grid">
                        <label class="wizard-option-card" onclick="selectPurpose('employment')">
                            <input type="radio" name="purpose" value="employment">
                            <div class="option-icon" style="background:#EFF6FF; color:#1E40AF;">💼</div>
                            <div class="option-details">
                                <strong class="option-title">Pre-Employment or Workplace</strong>
                                <p class="option-desc">Hiring, periodic corporate policy screening, or jobsite access compliance.</p>
                            </div>
                        </label>

                        <label class="wizard-option-card" onclick="selectPurpose('dot')">
                            <input type="radio" name="purpose" value="dot">
                            <div class="option-icon" style="background:#FEF3C7; color:#92400E;">🚛</div>
                            <div class="option-details">
                                <strong class="option-title">DOT Regulated Commercial Operator</strong>
                                <p class="option-desc">FMCSA truck drivers, FAA aviation, FRA rail, FTA transit, or USCG maritime mandates.</p>
                            </div>
                        </label>

                        <label class="wizard-option-card" onclick="selectPurpose('legal')">
                            <input type="radio" name="purpose" value="legal">
                            <div class="option-icon" style="background:#FEE2E2; color:#991B1B;">⚖️</div>
                            <div class="option-details">
                                <strong class="option-title">Court-Ordered, Probation or Legal</strong>
                                <p class="option-desc">Strict chain of custody with MRO review accepted for court, divorce, custody, or probation.</p>
                            </div>
                        </label>

                        <label class="wizard-option-card" onclick="selectPurpose('personal')">
                            <input type="radio" name="purpose" value="personal">
                            <div class="option-icon" style="background:#F3E8FF; color:#6B21A8;">🩺</div>
                            <div class="option-details">
                                <strong class="option-title">Personal Health or Family Peace of Mind</strong>
                                <p class="option-desc">Completely private, 100% confidential personal testing for yourself or family members.</p>
                            </div>
                        </label>
                    </div>

                    <div class="step-footer" style="justify-content:flex-end;">
                        <button type="button" class="btn btn-primary" id="btnNext1" onclick="goToStep(2)" disabled style="padding:12px 28px;">
                            Continue to Step 2 &rarr;
                        </button>
                    </div>
                </div>

                <!-- STEP 2: DETECTION WINDOW -->
                <div class="wizard-step" id="step2" style="display:none;">
                    <div class="step-header">
                        <span class="step-counter-tag">Question 2 of 3</span>
                        <h2 class="step-prompt">What detection timeframe do you need to screen?</h2>
                        <p class="step-subtitle">Different specimen collection types provide different windows of past drug and alcohol detection.</p>
                    </div>

                    <div class="options-grid">
                        <label class="wizard-option-card" onclick="selectWindow('recent')">
                            <input type="radio" name="window" value="recent">
                            <div class="option-icon" style="background:#EFF6FF; color:#1E40AF;">⏱️</div>
                            <div class="option-details">
                                <strong class="option-title">Recent Use (Past 1 to 3 Days) — Urine Specimen</strong>
                                <p class="option-desc">The industry standard. Fast 24-48 hr results, highly cost-effective, and universally recognized.</p>
                                <span class="option-pill">Most Popular</span>
                            </div>
                        </label>

                        <label class="wizard-option-card" onclick="selectWindow('historical')">
                            <input type="radio" name="window" value="historical">
                            <div class="option-icon" style="background:#ECFDF5; color:#065F46;">🗓️</div>
                            <div class="option-details">
                                <strong class="option-title">Historical Use (Up to 90 Days) — Hair Follicle</strong>
                                <p class="option-desc">Captures long-term drug usage patterns. Cannot be adulterated or washed out.</p>
                                <span class="option-pill" style="background:#ECFDF5; color:#047857;">90-Day Detection</span>
                            </div>
                        </label>

                        <label class="wizard-option-card" onclick="selectWindow('alcohol')">
                            <input type="radio" name="window" value="alcohol">
                            <div class="option-icon" style="background:#FEF3C7; color:#92400E;">🍺</div>
                            <div class="option-details">
                                <strong class="option-title">Alcohol Specific (Up to 80 Hours) — EtG Urine</strong>
                                <p class="option-desc">Tests for ethyl glucuronide (EtG) metabolite to confirm zero-tolerance alcohol compliance.</p>
                            </div>
                        </label>
                    </div>

                    <div class="step-footer">
                        <button type="button" class="btn btn-outline" onclick="goToStep(1)" style="padding:12px 24px;">
                            &larr; Back
                        </button>
                        <button type="button" class="btn btn-primary" id="btnNext2" onclick="goToStep(3)" disabled style="padding:12px 28px;">
                            Continue to Step 3 &rarr;
                        </button>
                    </div>
                </div>

                <!-- STEP 3: SUBSTANCES -->
                <div class="wizard-step" id="step3" style="display:none;">
                    <div class="step-header">
                        <span class="step-counter-tag">Question 3 of 3</span>
                        <h2 class="step-prompt">Which substances need to be included in the screen?</h2>
                        <p class="step-subtitle">Choose the depth of testing required for your specific workplace or legal criteria.</p>
                    </div>

                    <div class="options-grid">
                        <label class="wizard-option-card" onclick="selectSubstances('standard')">
                            <input type="radio" name="substances" value="standard">
                            <div class="option-icon" style="background:#EFF6FF; color:#1E40AF;">5★</div>
                            <div class="option-details">
                                <strong class="option-title">Standard 5-Panel (Core Street Drugs)</strong>
                                <p class="option-desc">Marijuana (THC), Cocaine, Basic Amphetamines/Meth, Basic Opiates, and PCP.</p>
                            </div>
                        </label>

                        <label class="wizard-option-card" onclick="selectSubstances('expanded')">
                            <input type="radio" name="substances" value="expanded">
                            <div class="option-icon" style="background:#FEF3C7; color:#92400E;">10★</div>
                            <div class="option-details">
                                <strong class="option-title">10-Panel + Expanded Opiates & Fentanyl</strong>
                                <p class="option-desc">Adds Oxycodone, Hydrocodone, Hydromorphone, Benzodiazepines, Barbiturates & Methadone.</p>
                                <span class="option-pill" style="background:#FEF2F2; color:#991B1B;">High Protection</span>
                            </div>
                        </label>

                        <label class="wizard-option-card" onclick="selectSubstances('comprehensive')">
                            <input type="radio" name="substances" value="comprehensive">
                            <div class="option-icon" style="background:#F3E8FF; color:#6B21A8;">12★</div>
                            <div class="option-details">
                                <strong class="option-title">12-Panel Comprehensive Maximum Spectrum</strong>
                                <p class="option-desc">Maximum multi-drug detection panel including Quaaludes, Propoxyphene, and expanded prescription classes.</p>
                            </div>
                        </label>

                        <label class="wizard-option-card" onclick="selectSubstances('alcohol-only')">
                            <input type="radio" name="substances" value="alcohol-only">
                            <div class="option-icon" style="background:#F1F5F9; color:#475569;">🍷</div>
                            <div class="option-details">
                                <strong class="option-title">Alcohol Only (EtG or Breath Alcohol)</strong>
                                <p class="option-desc">Isolated alcohol screen without unnecessary drug panel charges.</p>
                            </div>
                        </label>
                    </div>

                    <div class="step-footer">
                        <button type="button" class="btn btn-outline" onclick="goToStep(2)" style="padding:12px 24px;">
                            &larr; Back
                        </button>
                        <button type="button" class="btn btn-primary" id="btnNext3" onclick="calculateRecommendation()" disabled style="padding:12px 28px; background:#C1121F; border-color:#C1121F;">
                            View Recommended Test &rarr;
                        </button>
                    </div>
                </div>

                <!-- STEP 4: RECOMMENDATION RESULT -->
                <div class="wizard-step" id="stepResult" style="display:none;">
                    <div class="recommendation-header">
                        <div class="match-check-icon">✓</div>
                        <span class="match-badge">100% Legally Defensible Recommendation</span>
                        <h2 class="step-prompt" style="margin-top:8px;">We Found Your Recommended Drug Test</h2>
                        <p class="step-subtitle" id="matchSummaryText">
                            Based on your selection, this panel provides full compliance and laboratory certification.
                        </p>
                    </div>

                    <!-- Recommended Test Card -->
                    <div class="recommended-test-card" id="primaryCard">
                        <div class="rec-card-top">
                            <div>
                                <span class="rec-top-tag">Top Clinical Recommendation</span>
                                <h3 class="rec-product-title" id="recTitle">10 Panel + Exp Opiates Drug Test</h3>
                                <div class="rec-meta-pills" id="recPills">
                                    <span class="rec-pill">Urine Specimen</span>
                                    <span class="rec-pill">24-48 Hr Results</span>
                                    <span class="rec-pill">MRO Included</span>
                                </div>
                            </div>
                            <div class="rec-price-box">
                                <span class="rec-price-amount" id="recPrice">$119.99</span>
                                <span class="rec-price-note">All-Inclusive Lab Fee</span>
                            </div>
                        </div>

                        <div class="rec-body">
                            <p class="rec-desc" id="recDesc">
                                Comprehensive laboratory urine test detecting standard street drugs plus high-risk prescription opioids (Oxycodone, Hydrocodone) with licensed MRO review.
                            </p>

                            <div class="rec-features-grid">
                                <div>
                                    <strong style="font-size:12px; color:#475569; text-transform:uppercase; letter-spacing:0.5px; display:block; margin-bottom:6px;">Substances Screened:</strong>
                                    <div class="rec-substances-tags" id="recSubstances">
                                        <span>Amphetamines</span>
                                        <span>Cocaine</span>
                                        <span>THC / Marijuana</span>
                                        <span>Opiates</span>
                                        <span>PCP</span>
                                        <span>Oxycodone</span>
                                        <span>Hydrocodone</span>
                                    </div>
                                </div>
                                <div class="rec-trust-box">
                                    <div style="font-size:12.5px; color:#065F46; line-height:1.5;">
                                        ✓ <strong>Walk-Ins Welcome:</strong> Valid at all 7,382+ Quest &amp; Labcorp sites nationwide.<br>
                                        ✓ <strong>Electronic Donor Pass:</strong> Dispatched instantly to your phone &amp; email upon registration.
                                    </div>
                                </div>
                            </div>

                            <div class="rec-cta-bar">
                                <a href="#" id="recOrderBtn" class="btn btn-primary btn-lg" style="padding:16px 36px; font-size:17px; font-weight:800; text-decoration:none;">
                                    Schedule This Test Online &rarr;
                                </a>
                                <div style="display:flex; align-items:center; gap:8px; font-size:13.5px; color:#64748B;">
                                    <span>Or call to register:</span>
                                    <a href="tel:18002214291" style="color:#C1121F; font-weight:800; text-decoration:none;">(800) 221-4291</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alternative Comparison Box -->
                    <div class="alternative-card" id="altCard">
                        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
                            <div>
                                <span style="font-size:11px; font-weight:800; text-transform:uppercase; color:#64748B;">Alternative Option</span>
                                <h4 style="color:#0B2545; font-size:17px; font-weight:800; margin:4px 0;" id="altTitle">5 Panel Hair Follicle Drug Test</h4>
                                <p style="font-size:13px; color:#64748B; margin:0;" id="altDesc">Need historical 90-day detection? Consider hair follicle analysis.</p>
                            </div>
                            <div style="display:flex; align-items:center; gap:16px;">
                                <span style="font-size:22px; font-weight:800; color:#0B2545;" id="altPrice">$139.99</span>
                                <a href="#" id="altOrderBtn" class="btn btn-outline btn-sm" style="font-weight:700; color:#0B2545; border-color:#0B2545;">
                                    View Alternative &rarr;
                                </a>
                            </div>
                        </div>
                    </div>

                    <div style="text-align:center; margin-top:28px;">
                        <button type="button" class="btn btn-outline" onclick="resetWizard()" style="padding:10px 20px; font-size:13.5px;">
                            ↺ Start Over With New Criteria
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FAQs Section -->
    <section class="finder-faqs-section">
        <div class="container" style="max-width:880px;">
            <div style="text-align:center; margin-bottom:36px;">
                <span style="color:#C1121F; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:1px;">Help &amp; Guidance</span>
                <h3 style="color:#0B2545; font-size:24px; font-weight:800; margin:6px 0 0;">Frequently Asked Questions About Test Selection</h3>
            </div>

            <div class="faqs-list">
                @foreach($faqs as $faq)
                <div class="faq-item-card">
                    <h4 style="color:#0B2545; font-size:16px; font-weight:800; margin-bottom:8px; display:flex; gap:8px;">
                        <span style="color:#C1121F;">Q:</span> {{ $faq['question'] }}
                    </h4>
                    <p style="color:#475569; font-size:14px; line-height:1.6; margin:0; padding-left:22px;">
                        {{ $faq['answer'] }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

</div>

<!-- Styles for Test Finder -->
<style>
.test-finder-page {
    background: #F8FAFC;
    padding-bottom: 60px;
}
.test-finder-hero {
    background: linear-gradient(135deg, #0B2545 0%, #153E6B 100%);
    color: #fff;
    padding: 50px 0;
}
.finder-pill-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.12);
    border: 1px solid rgba(255,255,255,0.2);
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 700;
    color: #93C5FD;
    margin-bottom: 14px;
}
.test-finder-title {
    font-size: 36px;
    font-weight: 900;
    color: #fff;
    margin-bottom: 12px;
}
.test-finder-lead {
    font-size: 16.5px;
    color: #CBD5E1;
    line-height: 1.6;
    margin: 0;
}

/* Stepper */
.wizard-section {
    margin-top: -30px;
    padding-bottom: 40px;
}
.wizard-stepper {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 50px;
    padding: 12px 28px;
    max-width: 600px;
    margin: 0 auto 30px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}
.step-indicator {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #94A3B8;
}
.step-indicator.active {
    color: #0B2545;
    font-weight: 800;
}
.step-indicator.active .step-circle {
    background: #0B2545;
    color: #fff;
}
.step-circle {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #E2E8F0;
    color: #64748B;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 800;
}
.step-label {
    font-size: 13px;
}
.step-line {
    flex: 1;
    height: 2px;
    background: #E2E8F0;
    margin: 0 12px;
}

/* Card */
.wizard-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.04);
}
.step-header {
    text-align: center;
    margin-bottom: 30px;
}
.step-counter-tag {
    font-size: 12px;
    font-weight: 800;
    color: #C1121F;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.step-prompt {
    font-size: 26px;
    font-weight: 900;
    color: #0B2545;
    margin: 6px 0 8px;
}
.step-subtitle {
    font-size: 15px;
    color: #64748B;
    margin: 0;
}

/* Options Grid */
.options-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 32px;
}
.wizard-option-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: #F8FAFC;
    border: 2px solid #E2E8F0;
    border-radius: 12px;
    padding: 20px;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
}
.wizard-option-card:hover {
    border-color: #93C5FD;
    background: #F0F7FF;
    transform: translateY(-2px);
}
.wizard-option-card.selected {
    border-color: #0B2545;
    background: #EFF6FF;
    box-shadow: 0 4px 12px rgba(11,37,69,0.08);
}
.wizard-option-card input[type="radio"] {
    position: absolute;
    opacity: 0;
}
.option-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 900;
    flex-shrink: 0;
}
.option-details {
    flex: 1;
}
.option-title {
    display: block;
    color: #0B2545;
    font-size: 15.5px;
    margin-bottom: 4px;
}
.option-desc {
    font-size: 13px;
    color: #64748B;
    margin: 0 0 6px;
    line-height: 1.4;
}
.option-pill {
    display: inline-block;
    background: #DBEAFE;
    color: #1E40AF;
    font-size: 11px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 4px;
}

.step-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #F1F5F9;
    padding-top: 24px;
}

/* Recommendation Results */
.recommendation-header {
    text-align: center;
    margin-bottom: 28px;
}
.match-check-icon {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: #ECFDF5;
    color: #059669;
    font-size: 28px;
    font-weight: 900;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    border: 2px solid #A7F3D0;
}
.match-badge {
    background: #EFF6FF;
    color: #1E40AF;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 4px 12px;
    border-radius: 20px;
}

.recommended-test-card {
    background: #fff;
    border: 2px solid #0B2545;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(11,37,69,0.08);
    margin-bottom: 24px;
}
.rec-card-top {
    background: #0B2545;
    color: #fff;
    padding: 24px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.rec-top-tag {
    font-size: 11.5px;
    color: #F59E0B;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: block;
    margin-bottom: 4px;
}
.rec-product-title {
    font-size: 24px;
    font-weight: 900;
    color: #fff;
    margin: 0 0 8px;
}
.rec-meta-pills {
    display: flex;
    gap: 8px;
}
.rec-pill {
    background: rgba(255,255,255,0.15);
    padding: 3px 10px;
    border-radius: 4px;
    font-size: 12px;
    color: #E2E8F0;
}
.rec-price-box {
    text-align: right;
}
.rec-price-amount {
    font-size: 34px;
    font-weight: 900;
    color: #fff;
    display: block;
}
.rec-price-note {
    font-size: 12px;
    color: #94A3B8;
}
.rec-body {
    padding: 28px;
}
.rec-desc {
    font-size: 15px;
    color: #475569;
    line-height: 1.6;
    margin-bottom: 20px;
}
.rec-features-grid {
    display: grid;
    grid-template-columns: 1.2fr 0.8fr;
    gap: 20px;
    margin-bottom: 24px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 18px;
}
.rec-substances-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}
.rec-substances-tags span {
    background: #fff;
    border: 1px solid #CBD5E1;
    color: #0B2545;
    padding: 3px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 600;
}
.rec-cta-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    border-top: 1px solid #F1F5F9;
    padding-top: 20px;
}

.alternative-card {
    background: #F8FAFC;
    border: 1px solid #CBD5E1;
    border-radius: 10px;
    padding: 18px 24px;
}

.finder-faqs-section {
    padding: 50px 0;
}
.faq-item-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 18px 20px;
    margin-bottom: 14px;
}

@media (max-width: 768px) {
    .options-grid {
        grid-template-columns: 1fr;
    }
    .rec-card-top {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    .rec-features-grid {
        grid-template-columns: 1fr;
    }
    .rec-cta-bar {
        flex-direction: column;
        align-items: stretch;
    }
    .wizard-card {
        padding: 24px 18px;
    }
}
</style>

<!-- Wizard Logic -->
<script>
const wizardState = {
    purpose: null,
    window: null,
    substances: null
};

// Database product catalogue data
const productData = {
    '5-panel-nondot': {
        title: '5 Panel NON-DOT Drug Test',
        slug: '5-panel-nondot',
        price: '$89.99',
        specimen: 'Urine Specimen',
        turnaround: '24-48 Hr Results',
        desc: 'The baseline pre-employment drug test mandated by thousands of corporate employers nationwide. Analyzes the 5 primary illicit substances with SAMHSA laboratory precision.',
        substances: ['Amphetamines (Adderall/Meth)', 'Cocaine', 'Marijuana (THC)', 'Opiates (Codeine/Morphine)', 'PCP (Phencyclidine)']
    },
    '5-panel-exp-opiates': {
        title: '5 Panel + Expanded Opiates Drug Test',
        slug: '5-panel-exp-opiates',
        price: '$99.99',
        specimen: 'Urine Specimen',
        turnaround: '24-48 Hr Results',
        desc: 'Standard 5-panel screen upgraded to include semi-synthetic prescription painkillers like Oxycodone and Hydrocodone.',
        substances: ['Amphetamines', 'Cocaine', 'THC / Marijuana', 'Opiates', 'PCP', 'Oxycodone', 'Hydrocodone', 'Hydromorphone']
    },
    '10-panel': {
        title: '10 Panel Drug Test',
        slug: '10-panel',
        price: '$109.99',
        specimen: 'Urine Specimen',
        turnaround: '24-48 Hr Results',
        desc: 'The corporate and legal standard. Screens for both street drugs and prescription tranquilizers, sedatives, and painkillers.',
        substances: ['Amphetamines', 'Cocaine', 'THC', 'Opiates', 'PCP', 'Barbiturates', 'Benzodiazepines', 'Methadone', 'Methaqualone', 'Propoxyphene']
    },
    '10-panel-exp-opiates': {
        title: '10 Panel + Exp Opiates Drug Test',
        slug: '10-panel-exp-opiates',
        price: '$119.99',
        specimen: 'Urine Specimen',
        turnaround: '24-48 Hr Results',
        desc: 'Comprehensive 10-panel profile expanded to test for prescription opioids, OxyContin, Vicodin, and heavy analgesics with MRO review.',
        substances: ['Amphetamines', 'Cocaine', 'THC', 'Opiates', 'PCP', 'Barbiturates', 'Benzodiazepines', 'Methadone', 'Oxycodone', 'Hydrocodone', 'Hydromorphone', 'Oxymorphone']
    },
    '12-panel-comprehensive': {
        title: '12 Panel Comprehensive Drug Test',
        slug: '12-panel-comprehensive',
        price: '$139.99',
        specimen: 'Urine Specimen',
        turnaround: '24-48 Hr Results',
        desc: 'Maximum spectrum workplace and judicial testing panel covering virtually every commercially screenable controlled substance.',
        substances: ['Amphetamines', 'Cocaine', 'THC', 'Opiates', 'PCP', 'Barbiturates', 'Benzodiazepines', 'Methadone', 'Quaaludes', 'Propoxyphene', 'Oxycodone', 'MDMA/Ecstasy']
    },
    '5-panel-dot': {
        title: '5 Panel DOT Drug Screen',
        slug: '5-panel-dot',
        price: '$99.99',
        specimen: 'DOT Urine Specimen',
        turnaround: '24-48 Hr Results',
        desc: '100% compliant with 49 CFR Part 40 federal mandates for FMCSA, FAA, FRA, FTA, PHMSA, and USCG regulated commercial drivers and operators.',
        substances: ['THC (Marijuana)', 'Cocaine Metabolites', 'Amphetamines / Meth', 'Opioids (Codeine, Morphine, 6-AM, Hydrocodone, Hydromorphone, Oxycodone)', 'PCP']
    },
    'dot-breath-alcohol': {
        title: 'DOT Breath Alcohol Test (BAT)',
        slug: 'dot-breath-alcohol',
        price: '$89.99',
        specimen: 'Evidential Breath Testing (EBT)',
        turnaround: 'Immediate On-Site Reading',
        desc: 'Federal DOT breath alcohol screen performed by certified Breath Alcohol Technicians (BAT) using NHTSA-approved evidential devices.',
        substances: ['Breath Alcohol Concentration (BrAC) with 15-minute confirmation']
    },
    '5-panel-hair': {
        title: '5 Panel Hair Follicle Drug Test',
        slug: '5-panel-hair',
        price: '$139.99',
        specimen: 'Hair Follicle',
        turnaround: '3-5 Business Days',
        desc: 'Captures historical drug ingestion patterns over the preceding 90 days. Unaffected by detox shampoos, rapid hydration, or short-term abstinence.',
        substances: ['Amphetamines (Meth/Ecstasy)', 'Cocaine', 'Marijuana (THC)', 'Opiates (Codeine, Morphine, 6-MAM)', 'PCP']
    },
    'etg-alcohol': {
        title: 'EtG 80-Hour Alcohol Urine Test',
        slug: 'etg-alcohol',
        price: '$89.99',
        specimen: 'Urine (EtG Metabolite)',
        turnaround: '24-48 Hr Results',
        desc: 'Monitors ethyl glucuronide (EtG) to detect alcohol consumption up to 80 hours after ingestion. Ideal for zero-tolerance probation and monitoring.',
        substances: ['Ethyl Glucuronide (EtG) up to 80 hours post-consumption']
    }
};

function selectPurpose(val) {
    wizardState.purpose = val;
    highlightCards('purpose', val);
    document.getElementById('btnNext1').disabled = false;
}

function selectWindow(val) {
    wizardState.window = val;
    highlightCards('window', val);
    document.getElementById('btnNext2').disabled = false;
}

function selectSubstances(val) {
    wizardState.substances = val;
    highlightCards('substances', val);
    document.getElementById('btnNext3').disabled = false;
}

function highlightCards(name, val) {
    document.querySelectorAll(`input[name="${name}"]`).forEach(inp => {
        const card = inp.closest('.wizard-option-card');
        if (inp.value === val) {
            inp.checked = true;
            card.classList.add('selected');
        } else {
            card.classList.remove('selected');
        }
    });
}

function goToStep(stepNum) {
    document.querySelectorAll('.wizard-step').forEach(s => s.style.display = 'none');
    document.getElementById('step' + stepNum).style.display = 'block';

    // Update stepper
    for (let i = 1; i <= 3; i++) {
        const el = document.getElementById('stepIndicator' + i);
        if (i < stepNum) {
            el.className = 'step-indicator active';
            el.querySelector('.step-circle').innerHTML = '✓';
        } else if (i === stepNum) {
            el.className = 'step-indicator active';
            el.querySelector('.step-circle').innerHTML = i;
        } else {
            el.className = 'step-indicator';
            el.querySelector('.step-circle').innerHTML = i;
        }
    }
}

function calculateRecommendation() {
    let recKey = '10-panel-exp-opiates';
    let altKey = '5-panel-hair';
    let summary = '';

    // Logic Tree
    if (wizardState.purpose === 'dot') {
        if (wizardState.window === 'alcohol' || wizardState.substances === 'alcohol-only') {
            recKey = 'dot-breath-alcohol';
            altKey = '5-panel-dot';
            summary = 'For DOT-mandated breath alcohol compliance under 49 CFR Part 40 rules.';
        } else {
            recKey = '5-panel-dot';
            altKey = 'dot-breath-alcohol';
            summary = 'Federal 49 CFR Part 40 mandated 5-panel DOT screen for commercial transportation compliance.';
        }
    } else if (wizardState.window === 'historical') {
        recKey = '5-panel-hair';
        altKey = '10-panel-exp-opiates';
        summary = 'Captures historical drug use patterns across a 90-day window via hair follicle analysis.';
    } else if (wizardState.window === 'alcohol' || wizardState.substances === 'alcohol-only') {
        recKey = 'etg-alcohol';
        altKey = '10-panel';
        summary = 'Detects ethyl glucuronide (EtG) metabolite to confirm zero-tolerance alcohol compliance up to 80 hours.';
    } else if (wizardState.substances === 'standard') {
        recKey = '5-panel-nondot';
        altKey = '10-panel';
        summary = 'Cost-effective baseline 5-panel pre-employment and workplace test covering the 5 primary illicit substances.';
    } else if (wizardState.substances === 'comprehensive') {
        recKey = '12-panel-comprehensive';
        altKey = '10-panel-exp-opiates';
        summary = 'Maximum spectrum screening panel for complete judicial, safety-sensitive, or executive testing.';
    } else {
        recKey = '10-panel-exp-opiates';
        altKey = '5-panel-hair';
        summary = 'Recommended comprehensive screen covering illicit street drugs plus prescription pain medications and opioids with MRO review.';
    }

    const rec = productData[recKey];
    const alt = productData[altKey];

    // Populate recommendation card
    document.getElementById('recTitle').innerText = rec.title;
    document.getElementById('recPrice').innerText = rec.price;
    document.getElementById('recDesc').innerText = rec.desc;
    document.getElementById('matchSummaryText').innerText = summary;
    document.getElementById('recOrderBtn').href = '/checkout/' + rec.slug;

    // Pills
    const pillsWrap = document.getElementById('recPills');
    pillsWrap.innerHTML = `
        <span class="rec-pill">${rec.specimen}</span>
        <span class="rec-pill">${rec.turnaround}</span>
        <span class="rec-pill">Quest / Labcorp</span>
    `;

    // Substances
    const subWrap = document.getElementById('recSubstances');
    subWrap.innerHTML = rec.substances.map(s => `<span>${s}</span>`).join('');

    // Alternative
    document.getElementById('altTitle').innerText = alt.title;
    document.getElementById('altPrice').innerText = alt.price;
    document.getElementById('altDesc').innerText = alt.desc;
    document.getElementById('altOrderBtn').href = '/product/' + alt.slug;

    // Show result
    document.querySelectorAll('.wizard-step').forEach(s => s.style.display = 'none');
    document.getElementById('stepResult').style.display = 'block';

    // Stepper to all active
    for (let i = 1; i <= 4; i++) {
        const el = document.getElementById('stepIndicator' + i);
        el.className = 'step-indicator active';
    }

    document.getElementById('stepResult').scrollIntoView({ behavior: 'smooth' });
}

function resetWizard() {
    wizardState.purpose = null;
    wizardState.window = null;
    wizardState.substances = null;

    document.querySelectorAll('.wizard-option-card').forEach(c => c.classList.remove('selected'));
    document.querySelectorAll('input[type="radio"]').forEach(i => i.checked = false);

    document.getElementById('btnNext1').disabled = true;
    document.getElementById('btnNext2').disabled = true;
    document.getElementById('btnNext3').disabled = true;

    goToStep(1);
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>
@endsection
