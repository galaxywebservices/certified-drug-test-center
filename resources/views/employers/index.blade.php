@extends('layouts.main')

@section('title', 'Corporate Drug Testing & Employer Workplace Screening | Certified Drug Test Centers')
@section('meta_description', 'Nationwide corporate drug testing programs, DOT consortium random testing management, mobile on-site collections, and volume pricing across 7,382+ Quest & Labcorp facilities.')

@section('content')
<div class="employer-portal-page">

    <!-- Hero Section -->
    <section class="employer-hero">
        <div class="container">
            <div class="employer-hero-grid">
                <div class="employer-hero-content">
                    <div class="employer-pill-badge">
                        <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"></path></svg>
                        <span>Enterprise Workplace Compliance & DOT Programs</span>
                    </div>
                    <h1 class="employer-hero-title">
                        Corporate Drug Testing & Nationwide Employer Solutions
                    </h1>
                    <p class="employer-hero-lead">
                        Streamline your company's pre-employment screening, DOT random consortium pools, and on-site mobile testing with automated donor passes, consolidated billing, and preferred corporate volume pricing across <strong>7,382+ certified Quest & Labcorp facilities</strong>.
                    </p>

                    <div class="employer-hero-metrics">
                        <div class="metric-item">
                            <span class="metric-num">7,382+</span>
                            <span class="metric-lbl">Collection Facilities</span>
                        </div>
                        <div class="metric-divider"></div>
                        <div class="metric-item">
                            <span class="metric-num">24-48 Hr</span>
                            <span class="metric-lbl">Negative Turnaround</span>
                        </div>
                        <div class="metric-divider"></div>
                        <div class="metric-item">
                            <span class="metric-num">Up to 35%</span>
                            <span class="metric-lbl">Corporate Volume Savings</span>
                        </div>
                    </div>

                    <div class="employer-hero-actions">
                        <a href="#corporate-register" class="btn btn-primary" style="padding:14px 28px; font-size:16px;">
                            Setup Corporate Account &rarr;
                        </a>
                        <a href="{{ route('employers.portal') }}" class="btn btn-outline" style="background:#0B2545; color:#fff; border-color:#0B2545; padding:14px 24px; font-size:15px; font-weight:700;">
                            🏢 Corporate Portal Login
                        </a>
                        <a href="#volume-calculator" class="btn btn-outline" style="background:#fff; color:#0B2545; border-color:#CBD5E1; padding:14px 24px; font-size:15px; font-weight:700;">
                            Calculate Volume Savings
                        </a>
                    </div>
                </div>

                <div class="employer-hero-card">
                    <div class="account-perks-box">
                        <div class="perks-header">
                            <span style="font-size:12px; font-weight:800; letter-spacing:1px; text-transform:uppercase; color:#C1121F;">Corporate Account Privileges</span>
                            <h3 style="color:#0B2545; font-size:20px; font-weight:800; margin:6px 0 0;">Dedicated Business Support</h3>
                        </div>
                        <ul class="perks-list">
                            <li>
                                <div class="perk-icon">✓</div>
                                <div>
                                    <strong>Instant Digital Donor Pass Dispatch</strong>
                                    <p>Automated SMS and email passes sent straight to your job applicants with mapped directions.</p>
                                </div>
                            </li>
                            <li>
                                <div class="perk-icon">✓</div>
                                <div>
                                    <strong>Consolidated Net-30 Invoicing</strong>
                                    <p>Monthly itemized billing eliminating individual employee credit card expense reports.</p>
                                </div>
                            </li>
                            <li>
                                <div class="perk-icon">✓</div>
                                <div>
                                    <strong>Full DOT 49 CFR Part 40 Compliance</strong>
                                    <p>Random pool generation, MIS reporting, and FMCSA Clearinghouse integration.</p>
                                </div>
                            </li>
                            <li>
                                <div class="perk-icon">✓</div>
                                <div>
                                    <strong>Dedicated Account Manager</strong>
                                    <p>Direct priority phone & email support for emergency post-accident testing and rapid results.</p>
                                </div>
                            </li>
                        </ul>
                        <div class="perks-cta">
                            <span>Ready to speak with a corporate specialist?</span>
                            <a href="tel:18009854339" style="color:#C1121F; font-weight:800; text-decoration:none;">(800)-985-4339</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(session('corporate_success'))
    <!-- Submission Success Alert -->
    <section class="container" style="margin-top:30px;">
        <div class="corporate-success-card">
            <div style="font-size:42px; line-height:1; margin-bottom:12px;">🎉</div>
            <h2 style="color:#065F46; font-size:24px; font-weight:800; margin-bottom:8px;">
                Corporate Account Request Received!
            </h2>
            <p style="color:#047857; font-size:16px; max-width:680px; margin:0 auto 16px;">
                Thank you, <strong>{{ session('company_name') }}</strong>. Your corporate testing program intake has been assigned Reference Code:
            </p>
            <div style="display:inline-block; background:#fff; border:2px dashed #059669; padding:10px 24px; border-radius:8px; font-family:monospace; font-size:22px; font-weight:900; color:#065F46; margin-bottom:16px;">
                {{ session('reference_code') }}
            </div>
            <p style="color:#065F46; font-size:14px; margin-bottom:0;">
                A Senior Corporate Account Manager is reviewing your requirements and will reach out within <strong>1 business hour</strong> to finalize account setup and dispatch any requested donor passes.
            </p>
        </div>
    </section>
    @endif

    <!-- 4 Pillars of Workplace Compliance -->
    <section class="employer-solutions-section">
        <div class="container">
            <div class="section-header-center">
                <span class="subheading-tag">End-to-End Enterprise Services</span>
                <h2 class="section-title">The 4 Pillars of Corporate Drug Testing</h2>
                <p class="section-desc">
                    Whether you are onboarding 10 candidates a week or managing a nationwide fleet of commercial drivers, our platform guarantees bulletproof legal defensibility.
                </p>
            </div>

            <div class="solutions-grid">
                <div class="solution-card">
                    <div class="solution-icon-wrap" style="background:#EFF6FF; color:#1E40AF;">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="solution-card-title">Pre-Employment Screening</h3>
                    <p class="solution-card-desc">
                        Accelerate hiring cycles with instant electronic donor pass distribution. Candidates complete their screen at the nearest Quest or Labcorp site with 24-48 hr negative turnaround.
                    </p>
                    <ul class="solution-card-list">
                        <li>5, 10, 12-Panel Urine & Hair testing</li>
                        <li>Automated candidate reminders via SMS</li>
                        <li>Direct HR portal status tracking</li>
                    </ul>
                </div>

                <div class="solution-card">
                    <div class="solution-icon-wrap" style="background:#FEF3C7; color:#92400E;">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="solution-card-title">DOT Consortium & Random Pools</h3>
                    <p class="solution-card-desc">
                        Full compliance with federal agency mandates (FMCSA, FAA, FRA, FTA, PHMSA, USCG). Computerized quarterly random draws with certified chain of custody.
                    </p>
                    <ul class="solution-card-list">
                        <li>Annual MIS compliance audit reports</li>
                        <li>FMCSA Clearinghouse query management</li>
                        <li>Supervisor reasonable suspicion training</li>
                    </ul>
                </div>

                <div class="solution-card">
                    <div class="solution-icon-wrap" style="background:#FEE2E2; color:#991B1B;">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <h3 class="solution-card-title">Post-Accident & Emergency Dispatch</h3>
                    <p class="solution-card-desc">
                        24/7/365 emergency collection dispatch following on-the-job incidents or reasonable suspicion determinations. Rapid protocol minimizes legal liability.
                    </p>
                    <ul class="solution-card-list">
                        <li>Immediate collection center authorization</li>
                        <li>Breath alcohol & drug testing paired</li>
                        <li>Medical Review Officer (MRO) expedited review</li>
                    </ul>
                </div>

                <div class="solution-card">
                    <div class="solution-icon-wrap" style="background:#F3E8FF; color:#6B21A8;">
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h3 class="solution-card-title">On-Site Mobile Collections</h3>
                    <p class="solution-card-desc">
                        Eliminate lost work hours and travel time. Certified phlebotomists and collection specialists arrive at your corporate office, job site, or warehouse for batch testing.
                    </p>
                    <ul class="solution-card-list">
                        <li>Tested in batches of 5 to 500+ employees</li>
                        <li>Turnkey chain of custody documentation</li>
                        <li>Shift-based scheduling (Days, Nights, Weekends)</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Corporate Volume Rate Calculator -->
    <section class="calculator-section" id="volume-calculator">
        <div class="container">
            <div class="calculator-container">
                <div class="calculator-header">
                    <span style="display:inline-block; background:#EFF6FF; color:#1E40AF; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:800; letter-spacing:1px; text-transform:uppercase; margin-bottom:8px;">Interactive Volume Tool</span>
                    <h2 style="color:#0B2545; font-size:28px; font-weight:800; margin-bottom:8px;">Corporate Rate & Savings Calculator</h2>
                    <p style="color:#64748B; font-size:15px; margin:0;">
                        Estimate your company's discounted corporate testing tier based on expected monthly volume.
                    </p>
                </div>

                <div class="calculator-grid">
                    <!-- Controls Column -->
                    <div class="calc-controls">
                        <div class="calc-field-group">
                            <label class="calc-label">1. Select Standard Test Panel</label>
                            <select id="calcPanel" class="form-control" style="font-weight:700; height:48px; border-radius:8px;">
                                <option value="89.99" data-slug="5-panel-nondot" data-name="5-Panel Standard Urine">5-Panel Non-DOT Urine ($89.99 retail)</option>
                                <option value="109.99" data-slug="10-panel" data-name="10-Panel Comprehensive Urine">10-Panel Comprehensive Urine ($109.99 retail)</option>
                                <option value="99.99" data-slug="5-panel-dot" data-name="5-Panel DOT Drug Screen">5-Panel DOT Drug Screen ($99.99 retail)</option>
                                <option value="139.99" data-slug="5-panel-hair" data-name="5-Panel Hair Follicle">5-Panel Hair Follicle ($139.99 retail)</option>
                            </select>
                        </div>

                        <div class="calc-field-group">
                            <label class="calc-label" style="display:flex; justify-content:space-between;">
                                <span>2. Expected Monthly Test Volume</span>
                                <span id="volumeDisplay" style="color:#C1121F; font-weight:800;">25 Tests / mo</span>
                            </label>
                            <input type="range" id="calcVolume" min="3" max="150" value="25" step="1" style="width:100%; accent-color:#0B2545; cursor:pointer;">
                            <div style="display:flex; justify-content:space-between; font-size:12px; color:#94A3B8; margin-top:4px;">
                                <span>3 tests</span>
                                <span>25 tests</span>
                                <span>50 tests</span>
                                <span>100 tests</span>
                                <span>150+ tests</span>
                            </div>
                        </div>

                        <div class="calc-field-group">
                            <label class="calc-label">Discount Tier Level</label>
                            <div id="tierBadge" class="tier-badge-pill">
                                Tier 2 Corporate Account (20% Savings)
                            </div>
                        </div>
                    </div>

                    <!-- Output Results Column -->
                    <div class="calc-results-card">
                        <span style="font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:1px; color:#CBD5E1;">Your Projected Corporate Rate</span>
                        <div style="display:flex; align-items:baseline; gap:8px; margin:8px 0 16px;">
                            <span id="ratePerTest" style="font-size:38px; font-weight:900; color:#fff;">$71.99</span>
                            <span style="color:#94A3B8; font-size:15px;">/ test</span>
                            <span id="retailStrike" style="color:#EF4444; text-decoration:line-through; font-size:16px; margin-left:8px;">$89.99</span>
                        </div>

                        <div class="calc-stats-grid">
                            <div class="calc-stat-box">
                                <span class="calc-stat-title">Estimated Monthly Total</span>
                                <span id="monthlyTotal" class="calc-stat-val">$1,799.75</span>
                            </div>
                            <div class="calc-stat-box highlight">
                                <span class="calc-stat-title">Annual Corporate Savings</span>
                                <span id="annualSavings" class="calc-stat-val" style="color:#34D399;">$5,400.00 / yr</span>
                            </div>
                        </div>

                        <p style="font-size:12.5px; color:#94A3B8; margin:16px 0;">
                            * Includes electronic chain of custody, collection fee, SAMHSA laboratory analysis, and MRO review. Net-30 invoicing available.
                        </p>

                        <button type="button" class="btn btn-primary" onclick="applyRateToForm()" style="width:100%; padding:14px; font-size:15px; font-weight:800;">
                            Lock In This Corporate Tier &rarr;
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Corporate Account Registration & Candidate Intake Form -->
    <section class="corporate-intake-section" id="corporate-register">
        <div class="container">
            <div class="intake-form-wrapper">
                <div class="intake-form-header">
                    <span style="display:inline-block; background:#EFF6FF; color:#1E40AF; padding:4px 12px; border-radius:20px; font-size:12px; font-weight:800; letter-spacing:1px; text-transform:uppercase; margin-bottom:8px;">Fast-Track Registration</span>
                    <h2 style="color:#0B2545; font-size:28px; font-weight:800; margin-bottom:8px;">Corporate Account Setup & Candidate Intake</h2>
                    <p style="color:#64748B; font-size:15px; margin:0;">
                        Submit your company details below. Your dedicated account representative will configure your dashboard and dispatch donor passes immediately.
                    </p>
                </div>

                @if($errors->any())
                <div style="background:#FEF2F2; border:1px solid #FCA5A5; color:#991B1B; padding:16px; border-radius:8px; margin:20px 28px 0;">
                    <strong style="display:block; margin-bottom:6px;">Please review the form for the following errors:</strong>
                    <ul style="margin:0; padding-left:20px; font-size:14px;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('employers.submit') }}" method="POST" id="corporateForm" class="intake-form">
                    @csrf

                    <!-- Section 1: Company Profile -->
                    <div class="form-section-block">
                        <div class="section-badge-num">1</div>
                        <div class="section-block-content">
                            <h3 class="section-block-title">Company & Administrator Profile</h3>
                            <div class="form-row-2">
                                <div class="form-group">
                                    <label class="required-lbl">Company / Business Legal Name</label>
                                    <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" placeholder="e.g. Apex Logistics LLC" required>
                                </div>
                                <div class="form-group">
                                    <label>Industry</label>
                                    <select name="industry" class="form-control">
                                        <option value="">Select Industry...</option>
                                        <option value="Transportation & Logistics" {{ old('industry') == 'Transportation & Logistics' ? 'selected' : '' }}>Transportation & Logistics (Trucking / Delivery)</option>
                                        <option value="Construction & Contracting" {{ old('industry') == 'Construction & Contracting' ? 'selected' : '' }}>Construction & Contracting</option>
                                        <option value="Healthcare & Staffing" {{ old('industry') == 'Healthcare & Staffing' ? 'selected' : '' }}>Healthcare & Medical Staffing</option>
                                        <option value="Manufacturing & Warehousing" {{ old('industry') == 'Manufacturing & Warehousing' ? 'selected' : '' }}>Manufacturing & Warehousing</option>
                                        <option value="Retail & Hospitality" {{ old('industry') == 'Retail & Hospitality' ? 'selected' : '' }}>Retail & Hospitality</option>
                                        <option value="Government & Defense" {{ old('industry') == 'Government & Defense' ? 'selected' : '' }}>Government & Defense Contractor</option>
                                        <option value="Other Corporate Commercial" {{ old('industry') == 'Other Corporate Commercial' ? 'selected' : '' }}>Other Commercial Business</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row-2">
                                <div class="form-group">
                                    <label class="required-lbl">Authorized Contact Name</label>
                                    <input type="text" name="contact_name" class="form-control" value="{{ old('contact_name') }}" placeholder="e.g. Sarah Jenkins" required>
                                </div>
                                <div class="form-group">
                                    <label>Job Title / Role</label>
                                    <input type="text" name="job_title" class="form-control" value="{{ old('job_title') }}" placeholder="e.g. HR Director / Safety Manager / DER">
                                </div>
                            </div>

                            <div class="form-row-2">
                                <div class="form-group">
                                    <label class="required-lbl">Corporate Email (Work Address)</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="e.g. sarah.j@company.com" required>
                                </div>
                                <div class="form-group">
                                    <label class="required-lbl">Direct Phone Number</label>
                                    <input type="tel" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="e.g. (555) 234-5678" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Testing Scope & Requirements -->
                    <div class="form-section-block">
                        <div class="section-badge-num">2</div>
                        <div class="section-block-content">
                            <h3 class="section-block-title">Program Specifications & Billing Preference</h3>
                            
                            <div class="form-row-2">
                                <div class="form-group">
                                    <label class="required-lbl">Department of Transportation (DOT) Regulated?</label>
                                    <select name="dot_regulated" class="form-control" required>
                                        <option value="no" {{ old('dot_regulated') == 'no' ? 'selected' : '' }}>No — Standard Commercial Workplace</option>
                                        <option value="yes" {{ old('dot_regulated') == 'yes' ? 'selected' : '' }}>Yes — DOT Regulated (FMCSA / FAA / FTA / PHMSA / USCG)</option>
                                        <option value="both" {{ old('dot_regulated') == 'both' ? 'selected' : '' }}>Mixed Workforce (Both DOT Drivers & Non-DOT Staff)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Estimated Monthly Testing Volume</label>
                                    <select name="monthly_volume" id="formVolume" class="form-control">
                                        <option value="1-5 tests/mo">1 - 5 tests / month (Occasional)</option>
                                        <option value="6-20 tests/mo">6 - 20 tests / month (Growing Business)</option>
                                        <option value="21-50 tests/mo" selected>21 - 50 tests / month (Tier 2 Corporate)</option>
                                        <option value="51-100 tests/mo">51 - 100 tests / month (Tier 3 Enterprise)</option>
                                        <option value="100+ tests/mo">100+ tests / month (National Enterprise Custom)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" style="margin-top:14px;">
                                <label style="font-weight:700; margin-bottom:8px; display:block;">Select Programs of Interest:</label>
                                <div class="programs-checkbox-grid">
                                    <label class="checkbox-pill">
                                        <input type="checkbox" name="programs[]" value="Pre-Employment Screening" checked>
                                        <span>Pre-Employment Screening</span>
                                    </label>
                                    <label class="checkbox-pill">
                                        <input type="checkbox" name="programs[]" value="DOT Random Consortium" checked>
                                        <span>DOT Random Consortium</span>
                                    </label>
                                    <label class="checkbox-pill">
                                        <input type="checkbox" name="programs[]" value="Post-Accident Dispatch">
                                        <span>24/7 Post-Accident Rapid Response</span>
                                    </label>
                                    <label class="checkbox-pill">
                                        <input type="checkbox" name="programs[]" value="Mobile On-Site Testing">
                                        <span>Mobile / On-Site Job Collections</span>
                                    </label>
                                    <label class="checkbox-pill">
                                        <input type="checkbox" name="programs[]" value="Background Checks & MVR">
                                        <span>Background Checks & Driver MVR</span>
                                    </label>
                                    <label class="checkbox-pill">
                                        <input type="checkbox" name="programs[]" value="Return-to-Duty & SAP">
                                        <span>Return-to-Duty / SAP Monitoring</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-row-2" style="margin-top:16px;">
                                <div class="form-group">
                                    <label>Preferred Billing Method</label>
                                    <select name="billing_preference" class="form-control">
                                        <option value="Net-30 Monthly Invoicing">Consolidated Net-30 Invoicing (Recommended)</option>
                                        <option value="Corporate Credit Card on File">Corporate Credit Card on File (Per Test)</option>
                                        <option value="Direct Purchase Order (PO)">Corporate Purchase Order (PO)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Additional Notes or Instructions</label>
                                    <input type="text" name="notes" class="form-control" value="{{ old('notes') }}" placeholder="e.g. Need immediate testing for 3 drivers in Atlanta, GA">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Optional Multi-Candidate Roster (Bulk Scheduling) -->
                    <div class="form-section-block">
                        <div class="section-badge-num">3</div>
                        <div class="section-block-content">
                            <div style="display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:12px;">
                                <div>
                                    <h3 class="section-block-title">Initial Candidate Roster (Optional)</h3>
                                    <p style="color:#64748B; font-size:13.5px; margin:0 0 14px;">
                                        Have active job applicants ready to be scheduled today? Enter them below to generate electronic donor passes automatically upon account setup.
                                    </p>
                                </div>
                                <button type="button" class="btn btn-outline btn-sm" onclick="addCandidateRow()" style="color:#0B2545; border-color:#0B2545; font-weight:700;">
                                    + Add Candidate
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="candidate-roster-table" id="rosterTable">
                                    <thead>
                                        <tr>
                                            <th>Candidate Full Name</th>
                                            <th>Candidate Email</th>
                                            <th>Candidate Phone</th>
                                            <th>Test Panel Required</th>
                                            <th style="width:110px;">Preferred ZIP</th>
                                            <th style="width:50px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="rosterBody">
                                        <tr>
                                            <td>
                                                <input type="text" name="candidates[0][name]" class="form-control form-control-sm" placeholder="e.g. John Doe">
                                            </td>
                                            <td>
                                                <input type="email" name="candidates[0][email]" class="form-control form-control-sm" placeholder="johndoe@email.com">
                                            </td>
                                            <td>
                                                <input type="tel" name="candidates[0][phone]" class="form-control form-control-sm" placeholder="(555) 123-4567">
                                            </td>
                                            <td>
                                                <select name="candidates[0][test_panel]" class="form-control form-control-sm">
                                                    <option value="5-Panel Urine">5-Panel Non-DOT Urine</option>
                                                    <option value="10-Panel Urine">10-Panel Comprehensive</option>
                                                    <option value="5-Panel DOT">5-Panel DOT FMCSA</option>
                                                    <option value="Hair Follicle">Hair Follicle Drug Screen</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="candidates[0][zip]" class="form-control form-control-sm" placeholder="ZIP code">
                                            </td>
                                            <td style="text-align:center;">
                                                <button type="button" class="remove-row-btn" onclick="removeCandidateRow(this)" title="Remove Candidate">&times;</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Footer -->
                    <div class="intake-form-footer">
                        <div style="font-size:13px; color:#64748B;">
                            🔒 Encrypted & confidential. Zero obligation. No setup fees for qualified corporate accounts.
                        </div>
                        <button type="submit" class="btn btn-primary" style="padding:16px 36px; font-size:16px; font-weight:800;">
                            Submit Corporate Account Application &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- DOT Agency Compliance Grid -->
    <section class="dot-compliance-bar">
        <div class="container">
            <div style="text-align:center; max-width:700px; margin:0 auto 30px;">
                <span class="subheading-tag">Regulatory Coverage</span>
                <h3 style="color:#0B2545; font-size:24px; font-weight:800;">Department of Transportation (DOT) Agency Compliance</h3>
                <p style="color:#64748B; font-size:14px; margin:6px 0 0;">
                    We satisfy 100% of 49 CFR Part 40 testing, collection, and MRO requirements across all operating administrations:
                </p>
            </div>
            <div class="dot-agencies-grid">
                <div class="dot-agency-card">
                    <strong>FMCSA</strong>
                    <span>Commercial Truck & Bus Drivers</span>
                </div>
                <div class="dot-agency-card">
                    <strong>FAA</strong>
                    <span>Aviation Pilots & Maintenance</span>
                </div>
                <div class="dot-agency-card">
                    <strong>FRA</strong>
                    <span>Railroad Operations Staff</span>
                </div>
                <div class="dot-agency-card">
                    <strong>FTA</strong>
                    <span>Public Transit Operators</span>
                </div>
                <div class="dot-agency-card">
                    <strong>PHMSA</strong>
                    <span>Pipeline & Hazmat Handlers</span>
                </div>
                <div class="dot-agency-card">
                    <strong>USCG</strong>
                    <span>Commercial Maritime & Vessels</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Corporate FAQs -->
    <section class="employer-faqs-section">
        <div class="container">
            <div class="section-header-center">
                <span class="subheading-tag">Frequently Asked Questions</span>
                <h2 class="section-title">Corporate Account & Testing FAQs</h2>
            </div>

            <div class="employer-faqs-grid">
                @foreach($faqs as $faq)
                <div class="employer-faq-item">
                    <h4 class="employer-faq-q">
                        <svg width="18" height="18" fill="none" stroke="#C1121F" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $faq['question'] }}
                    </h4>
                    <p class="employer-faq-a">{{ $faq['answer'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

</div>

<!-- Styles for Employer Portal -->
<style>
.employer-portal-page {
    background: #F8FAFC;
}
.employer-hero {
    background: linear-gradient(135deg, #0B2545 0%, #133E68 100%);
    color: #fff;
    padding: 60px 0;
}
.employer-hero-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 40px;
    align-items: center;
}
.employer-pill-badge {
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
    margin-bottom: 16px;
}
.employer-hero-title {
    font-size: 40px;
    font-weight: 900;
    line-height: 1.15;
    color: #fff;
    margin-bottom: 16px;
}
.employer-hero-lead {
    font-size: 17px;
    line-height: 1.6;
    color: #CBD5E1;
    margin-bottom: 24px;
}
.employer-hero-metrics {
    display: flex;
    align-items: center;
    gap: 20px;
    background: rgba(11, 37, 69, 0.6);
    border: 1px solid rgba(255,255,255,0.12);
    padding: 16px 24px;
    border-radius: 12px;
    margin-bottom: 28px;
}
.metric-item {
    text-align: center;
}
.metric-num {
    display: block;
    font-size: 24px;
    font-weight: 900;
    color: #fff;
}
.metric-lbl {
    font-size: 12px;
    color: #94A3B8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.metric-divider {
    width: 1px;
    height: 36px;
    background: rgba(255,255,255,0.15);
}
.employer-hero-actions {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
}
.account-perks-box {
    background: #fff;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.25);
    border: 1px solid #E2E8F0;
}
.perks-list {
    list-style: none;
    padding: 0;
    margin: 20px 0;
}
.perks-list li {
    display: flex;
    gap: 12px;
    margin-bottom: 16px;
}
.perk-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #EFF6FF;
    color: #1E40AF;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 13px;
    flex-shrink: 0;
    margin-top: 2px;
}
.perks-list strong {
    display: block;
    color: #0B2545;
    font-size: 14.5px;
    margin-bottom: 2px;
}
.perks-list p {
    font-size: 12.5px;
    color: #64748B;
    margin: 0;
    line-height: 1.4;
}
.perks-cta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #E2E8F0;
    padding-top: 16px;
    font-size: 13.5px;
    color: #475569;
}

/* Success Card */
.corporate-success-card {
    background: #ECFDF5;
    border: 2px solid #A7F3D0;
    border-radius: 16px;
    padding: 36px;
    text-align: center;
    box-shadow: 0 10px 25px rgba(5,150,105,0.1);
}

/* Solutions Grid */
.employer-solutions-section {
    padding: 70px 0;
}
.section-header-center {
    text-align: center;
    max-width: 760px;
    margin: 0 auto 48px;
}
.subheading-tag {
    display: inline-block;
    color: #C1121F;
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
}
.section-title {
    color: #0B2545;
    font-size: 32px;
    font-weight: 900;
    margin-bottom: 12px;
}
.section-desc {
    color: #64748B;
    font-size: 16px;
    line-height: 1.6;
}
.solutions-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 24px;
}
.solution-card {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 28px 24px;
    transition: transform 0.2s, box-shadow 0.2s;
}
.solution-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(11,37,69,0.08);
}
.solution-icon-wrap {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
}
.solution-card-title {
    color: #0B2545;
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 10px;
}
.solution-card-desc {
    font-size: 13.5px;
    color: #64748B;
    line-height: 1.5;
    margin-bottom: 16px;
}
.solution-card-list {
    list-style: none;
    padding: 0;
    margin: 0;
    border-top: 1px solid #F1F5F9;
    padding-top: 14px;
}
.solution-card-list li {
    font-size: 12.5px;
    color: #334155;
    margin-bottom: 6px;
    position: relative;
    padding-left: 16px;
}
.solution-card-list li::before {
    content: "•";
    color: #C1121F;
    font-weight: 900;
    position: absolute;
    left: 0;
}

/* Calculator */
.calculator-section {
    padding: 60px 0;
    background: #F1F5F9;
}
.calculator-container {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}
.calculator-header {
    text-align: center;
    margin-bottom: 36px;
}
.calculator-grid {
    display: grid;
    grid-template-columns: 1.15fr 0.85fr;
    gap: 36px;
    align-items: center;
}
.calc-field-group {
    margin-bottom: 24px;
}
.calc-label {
    display: block;
    font-size: 14px;
    font-weight: 700;
    color: #0B2545;
    margin-bottom: 8px;
}
.tier-badge-pill {
    background: #EFF6FF;
    border: 1px solid #BFDBFE;
    color: #1E40AF;
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 700;
}
.calc-results-card {
    background: linear-gradient(135deg, #0B2545 0%, #153E6B 100%);
    border-radius: 12px;
    padding: 30px;
    color: #fff;
}
.calc-stats-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.calc-stat-box {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 8px;
    padding: 12px;
}
.calc-stat-box.highlight {
    background: rgba(5,150,105,0.2);
    border-color: rgba(5,150,105,0.4);
}
.calc-stat-title {
    display: block;
    font-size: 11px;
    text-transform: uppercase;
    color: #94A3B8;
    margin-bottom: 4px;
}
.calc-stat-val {
    font-size: 18px;
    font-weight: 800;
    color: #fff;
}

/* Intake Form */
.corporate-intake-section {
    padding: 70px 0;
}
.intake-form-wrapper {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}
.intake-form-header {
    background: #F8FAFC;
    padding: 32px 40px;
    border-bottom: 1px solid #E2E8F0;
}
.intake-form {
    padding: 40px;
}
.form-section-block {
    display: flex;
    gap: 20px;
    margin-bottom: 36px;
    padding-bottom: 32px;
    border-bottom: 1px solid #F1F5F9;
}
.section-badge-num {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #0B2545;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 16px;
    flex-shrink: 0;
}
.section-block-content {
    flex: 1;
}
.section-block-title {
    font-size: 19px;
    font-weight: 800;
    color: #0B2545;
    margin-bottom: 18px;
}
.form-group {
    margin-bottom: 18px;
}
.form-group label,
.form-label,
.required-lbl {
    display: block !important;
    font-size: 13.5px;
    font-weight: 700;
    color: #0B2545;
    margin-bottom: 7px;
    line-height: 1.3;
}
.required-lbl::after {
    content: " *";
    color: #C1121F;
    font-weight: 800;
}
.form-control {
    display: block !important;
    width: 100% !important;
    height: 46px;
    padding: 10px 14px;
    border: 1px solid #CBD5E1;
    border-radius: 8px;
    font-size: 14.5px;
    color: #1E293B;
    background-color: #FFFFFF;
    box-sizing: border-box !important;
    transition: border-color 0.2s, box-shadow 0.2s;
    outline: none;
}
.form-control:focus {
    border-color: #0B2545;
    box-shadow: 0 0 0 3px rgba(11, 37, 69, 0.1);
    background-color: #fff;
}
.form-control::placeholder {
    color: #94A3B8;
}
select.form-control {
    appearance: auto;
    -webkit-appearance: auto;
    cursor: pointer;
    background-color: #fff;
}
.form-control-sm {
    height: 38px !important;
    padding: 6px 10px !important;
    font-size: 13px !important;
    border-radius: 6px !important;
}
.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 6px;
}
.programs-checkbox-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}
.checkbox-pill {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    padding: 12px 14px;
    border-radius: 8px;
    font-size: 13.5px;
    font-weight: 600;
    color: #1E293B;
    cursor: pointer;
    transition: background 0.15s, border-color 0.15s;
}
.checkbox-pill:hover {
    background: #EFF6FF;
    border-color: #BFDBFE;
}
.checkbox-pill input {
    accent-color: #0B2545;
    width: 16px;
    height: 16px;
}

/* Candidate Table */
.candidate-roster-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}
.candidate-roster-table th {
    background: #F1F5F9;
    padding: 11px 12px;
    font-size: 12px;
    font-weight: 800;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: 1px solid #E2E8F0;
}
.candidate-roster-table td {
    padding: 8px 10px;
    border: 1px solid #E2E8F0;
    vertical-align: middle;
    background: #fff;
}
.candidate-roster-table td .form-control {
    width: 100% !important;
    box-sizing: border-box !important;
}
.remove-row-btn {
    background: #FEE2E2;
    color: #991B1B;
    border: none;
    width: 28px;
    height: 28px;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    font-weight: bold;
}
.remove-row-btn:hover {
    background: #FCA5A5;
}
.intake-form-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    padding-top: 20px;
    border-top: 1px solid #E2E8F0;
}

/* DOT Agencies */
.dot-compliance-bar {
    padding: 50px 0;
    background: #fff;
    border-top: 1px solid #E2E8F0;
    border-bottom: 1px solid #E2E8F0;
}
.dot-agencies-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 16px;
}
.dot-agency-card {
    background: #F8FAFC;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    padding: 16px 12px;
    text-align: center;
}
.dot-agency-card strong {
    display: block;
    color: #0B2545;
    font-size: 16px;
    font-weight: 900;
    margin-bottom: 4px;
}
.dot-agency-card span {
    font-size: 11.5px;
    color: #64748B;
    line-height: 1.3;
    display: block;
}

/* FAQs */
.employer-faqs-section {
    padding: 70px 0;
}
.employer-faqs-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    max-width: 1000px;
    margin: 0 auto;
}
.employer-faq-item {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 12px;
    padding: 24px;
}
.employer-faq-q {
    font-size: 16px;
    font-weight: 800;
    color: #0B2545;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 10px;
    line-height: 1.4;
}
.employer-faq-a {
    font-size: 14px;
    color: #475569;
    line-height: 1.6;
    margin: 0;
    padding-left: 28px;
}

@media (max-width: 991px) {
    .employer-hero-grid,
    .calculator-grid {
        grid-template-columns: 1fr;
    }
    .solutions-grid {
        grid-template-columns: 1fr 1fr;
    }
    .dot-agencies-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    .employer-faqs-grid {
        grid-template-columns: 1fr;
    }
    .programs-checkbox-grid {
        grid-template-columns: 1fr 1fr;
    }
}
@media (max-width: 640px) {
    .solutions-grid {
        grid-template-columns: 1fr;
    }
    .dot-agencies-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .form-row-2 {
        grid-template-columns: 1fr;
    }
    .programs-checkbox-grid {
        grid-template-columns: 1fr;
    }
    .employer-hero-metrics {
        flex-direction: column;
        gap: 12px;
    }
    .metric-divider {
        display: none;
    }
}
</style>

<!-- Calculator & Dynamic Table Script -->
<script>
let candidateCount = 1;

function updateCalculator() {
    const retailPrice = parseFloat(document.getElementById('calcPanel').value);
    const volume = parseInt(document.getElementById('calcVolume').value);
    
    document.getElementById('volumeDisplay').innerText = volume + ' Tests / mo';

    // Volume discount brackets
    let discountPct = 0.10; // Default 10%
    let tierText = "Tier 1 Corporate Account (10% Savings)";

    if (volume >= 100) {
        discountPct = 0.35;
        tierText = "Enterprise Custom Tier (35% Savings)";
    } else if (volume >= 50) {
        discountPct = 0.28;
        tierText = "Tier 3 National Fleet (28% Savings)";
    } else if (volume >= 20) {
        discountPct = 0.20;
        tierText = "Tier 2 Corporate Account (20% Savings)";
    } else if (volume >= 10) {
        discountPct = 0.15;
        tierText = "Tier 1 Growth Account (15% Savings)";
    }

    const discountedPrice = retailPrice * (1 - discountPct);
    const monthlyTotal = discountedPrice * volume;
    const monthlyRetail = retailPrice * volume;
    const annualSavings = (monthlyRetail - monthlyTotal) * 12;

    document.getElementById('tierBadge').innerText = tierText;
    document.getElementById('ratePerTest').innerText = '$' + discountedPrice.toFixed(2);
    document.getElementById('retailStrike').innerText = '$' + retailPrice.toFixed(2);
    document.getElementById('monthlyTotal').innerText = '$' + monthlyTotal.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    document.getElementById('annualSavings').innerText = '$' + annualSavings.toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' / yr';
}

function applyRateToForm() {
    const volume = parseInt(document.getElementById('calcVolume').value);
    const select = document.getElementById('formVolume');
    
    if (volume >= 100) select.value = '100+ tests/mo';
    else if (volume >= 50) select.value = '51-100 tests/mo';
    else if (volume >= 20) select.value = '21-50 tests/mo';
    else if (volume >= 6) select.value = '6-20 tests/mo';
    else select.value = '1-5 tests/mo';

    const formEl = document.getElementById('corporate-register');
    if (formEl) {
        formEl.scrollIntoView({ behavior: 'smooth' });
    }
}

function addCandidateRow() {
    if (candidateCount >= 8) {
        alert('You can enter up to 8 initial candidates in this quick intake. Additional candidates can be uploaded in bulk via CSV once your portal is active.');
        return;
    }
    const tbody = document.getElementById('rosterBody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input type="text" name="candidates[${candidateCount}][name]" class="form-control form-control-sm" placeholder="Candidate Full Name"></td>
        <td><input type="email" name="candidates[${candidateCount}][email]" class="form-control form-control-sm" placeholder="candidate@email.com"></td>
        <td><input type="tel" name="candidates[${candidateCount}][phone]" class="form-control form-control-sm" placeholder="(555) 000-0000"></td>
        <td>
            <select name="candidates[${candidateCount}][test_panel]" class="form-control form-control-sm">
                <option value="5-Panel Urine">5-Panel Non-DOT Urine</option>
                <option value="10-Panel Urine">10-Panel Comprehensive</option>
                <option value="5-Panel DOT">5-Panel DOT FMCSA</option>
                <option value="Hair Follicle">Hair Follicle Drug Screen</option>
            </select>
        </td>
        <td><input type="text" name="candidates[${candidateCount}][zip]" class="form-control form-control-sm" placeholder="ZIP code"></td>
        <td style="text-align:center;">
            <button type="button" class="remove-row-btn" onclick="removeCandidateRow(this)" title="Remove Candidate">&times;</button>
        </td>
    `;
    tbody.appendChild(tr);
    candidateCount++;
}

function removeCandidateRow(btn) {
    const tr = btn.closest('tr');
    if (document.querySelectorAll('#rosterBody tr').length > 1) {
        tr.remove();
    } else {
        tr.querySelectorAll('input').forEach(inp => inp.value = '');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('calcPanel').addEventListener('change', updateCalculator);
    document.getElementById('calcVolume').addEventListener('input', updateCalculator);
    updateCalculator();
});
</script>
@endsection
