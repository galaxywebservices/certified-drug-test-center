@extends('layouts.main')

@section('content')
<style>
    .contact-hero-bar {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        padding: 44px 0;
        border-bottom: 3px solid #C1121F;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr;
        gap: 40px;
        padding: 48px 0 70px;
    }

    @media (max-width: 992px) {
        .contact-grid {
            grid-template-columns: 1fr;
            gap: 32px;
        }
    }

    .contact-card {
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 36px;
        box-shadow: 0 4px 14px rgba(11, 37, 69, 0.04);
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        display: block;
        font-size: 13.5px;
        font-weight: 700;
        color: #0B2545;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #CBD5E1;
        border-radius: 6px;
        font-size: 14.5px;
        color: #1E293B;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #0B2545;
        outline: none;
        box-shadow: 0 0 0 3px rgba(11, 37, 69, 0.1);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    @media (max-width: 576px) {
        .form-row { grid-template-columns: 1fr; }
    }

    .info-card {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 10px;
        padding: 24px;
        margin-bottom: 20px;
    }

    .info-item {
        display: flex;
        gap: 14px;
        margin-bottom: 18px;
    }

    .info-item:last-child {
        margin-bottom: 0;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #EFF6FF;
        color: #0B2545;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .trust-box {
        background: linear-gradient(135deg, #0B2545 0%, #133E6E 100%);
        color: #fff;
        border-radius: 10px;
        padding: 26px;
        text-align: center;
    }
</style>

<!-- Hero Bar -->
<div class="contact-hero-bar">
    <div class="container">
        <nav class="breadcrumbs" aria-label="Breadcrumb" style="display:flex; gap:8px; font-size:13px; color:#94A3B8; margin-bottom:12px;">
            <a href="{{ url('/') }}" style="color:#CBD5E1; text-decoration:none;">Home</a>
            <span>&rsaquo;</span>
            <span style="color:#fff;">Contact Us</span>
        </nav>
        <h1 style="font-size:32px; font-weight:800; color:#fff; line-height:1.2; margin:0 0 8px;">
            Contact Certified Drug Test Centers
        </h1>
        <p style="font-size:16px; color:#CBD5E1; margin:0; max-width:640px;">
            Speak with our nationwide testing specialists for employer accounts, background screening quotes, or test scheduling questions.
        </p>
    </div>
</div>

<div class="container">
    <div class="contact-grid">
        <!-- Left Column: Inquiry Form -->
        <div>
            <div class="contact-card">
                <h2 style="font-size:22px; font-weight:800; color:#0B2545; margin:0 0 6px;">Send Us an Inquiry</h2>
                <p style="font-size:14px; color:#64748B; margin:0 0 24px;">Fill out the form below and an account representative will respond promptly.</p>

                @if(session('success'))
                    <div style="background:#ECFDF5; border:1px solid #A7F3D0; color:#065F46; border-radius:8px; padding:16px 20px; margin-bottom:24px; font-size:14.5px;">
                        <strong>✓ Success!</strong> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div style="background:#FEF2F2; border:1px solid #FECACA; color:#991B1B; border-radius:8px; padding:16px 20px; margin-bottom:24px; font-size:14px;">
                        <strong style="display:block; margin-bottom:6px;">Please correct the errors below:</strong>
                        <ul style="margin:0 0 0 18px; padding:0;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="name">Your Full Name <span style="color:#C1121F;">*</span></label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" placeholder="John Doe" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="email">Work or Personal Email <span style="color:#C1121F;">*</span></label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="john@example.com" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" placeholder="(800) 221-4291">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="company">Company / Organization</label>
                            <input type="text" id="company" name="company" class="form-control" value="{{ old('company') }}" placeholder="Acme Logistics, Inc.">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="service_type">Service Needed <span style="color:#C1121F;">*</span></label>
                        <select id="service_type" name="service_type" class="form-control" required>
                            <option value="drug-testing" {{ old('service_type') === 'drug-testing' ? 'selected' : '' }}>Drug &amp; Alcohol Testing (Urine, Hair, Breath, Saliva)</option>
                            <option value="background-checks" {{ old('service_type') === 'background-checks' ? 'selected' : '' }}>Background Screening &amp; MVR Driving Records</option>
                            <option value="dot-compliance" {{ old('service_type') === 'dot-compliance' ? 'selected' : '' }}>DOT Random Consortium &amp; FMCSA Compliance</option>
                            <option value="mobile-testing" {{ old('service_type') === 'mobile-testing' ? 'selected' : '' }}>On-Site &amp; Mobile Testing (We Come to You)</option>
                            <option value="general" {{ old('service_type') === 'general' ? 'selected' : '' }}>General Question / Custom Corporate Account</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">How Can We Help You? <span style="color:#C1121F;">*</span></label>
                        <textarea id="message" name="message" class="form-control" rows="5" placeholder="Please describe the number of employees, test types, or specific questions..." required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width:100%; font-size:16px; padding:14px; font-weight:700;">
                        Send Inquiry &amp; Request Consultation &rarr;
                    </button>
                </form>
            </div>
        </div>

        <!-- Right Column: Direct Contact & Info -->
        <div>
            <!-- Direct Phone Card -->
            <div class="info-card">
                <div class="info-item">
                    <div class="info-icon">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 4V3z"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#64748B;">National Scheduling Hotline</div>
                        <a href="tel:18002214291" style="font-size:20px; font-weight:800; color:#C1121F; text-decoration:none;">(800) 221-4291</a>
                        <div style="font-size:13px; color:#475569; margin-top:2px;">Toll-free • Available 24 Hours / 7 Days Online</div>
                    </div>
                </div>

                <hr style="border:none; border-top:1px solid #E2E8F0; margin:16px 0;">

                <div class="info-item">
                    <div class="info-icon">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#64748B;">Corporate Headquarters</div>
                        <div style="font-size:14.5px; font-weight:700; color:#0B2545;">Certified Drug Test Centers</div>
                        <div style="font-size:13.5px; color:#475569; line-height:1.5;">
                            201 N. Park Ave.<br>
                            Sanford, FL 32771
                        </div>
                    </div>
                </div>

                <hr style="border:none; border-top:1px solid #E2E8F0; margin:16px 0;">

                <div class="info-item">
                    <div class="info-icon">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#64748B;">Support Hours</div>
                        <div style="font-size:13.5px; color:#475569; line-height:1.5;">
                            <strong>Online Registration:</strong> 24/7/365<br>
                            <strong>Phone Consultation:</strong> Mon - Fri 8:00 AM - 8:00 PM EST
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nationwide Laboratory Network Card -->
            <div class="trust-box">
                <div style="font-size:11px; font-weight:800; letter-spacing:1px; text-transform:uppercase; color:#94A3B8;">Accredited Network</div>
                <h3 style="font-size:18px; font-weight:800; color:#fff; margin:8px 0 10px;">20,000+ Collection Facilities</h3>
                <p style="font-size:13.5px; color:#CBD5E1; line-height:1.6; margin-bottom:16px;">
                    Fast walk-in testing at Quest Diagnostics, Labcorp, and certified partner collection sites nationwide. No doctor order or appointment required.
                </p>
                <a href="{{ route('locations.index') }}" class="btn btn-outline-white btn-sm" style="display:inline-block; padding:8px 18px; font-size:13px; text-decoration:none;">
                    Find Nearby Testing Centers &rarr;
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
