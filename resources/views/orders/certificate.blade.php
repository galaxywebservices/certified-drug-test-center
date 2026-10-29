@extends('layouts.main')

@section('content')
<style>
    /* ==========================================================================
       Official MRO Laboratory Drug Test Result Certificate & Medical Report
       Option 2 Design: High Trust, Tamper-Evident Medical Clean
       ========================================================================== */
    .certificate-page-wrap {
        background-color: #F1F5F9;
        padding: 36px 0 80px;
    }

    /* Floating Action Bar (Hidden in Print) */
    .cert-action-bar {
        max-width: 900px;
        margin: 0 auto 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        background: #FFFFFF;
        padding: 14px 20px;
        border-radius: 10px;
        border: 1px solid #CBD5E1;
        box-shadow: 0 2px 8px rgba(11, 37, 69, 0.05);
    }

    /* Main Certificate Sheet */
    .cert-sheet {
        max-width: 900px;
        margin: 0 auto;
        background: #FFFFFF;
        border: 2px solid #0B2545;
        border-radius: 8px;
        box-shadow: 0 12px 36px rgba(11, 37, 69, 0.1);
        padding: 40px 48px;
        position: relative;
        overflow: hidden;
    }

    /* Security Watermark Background */
    .cert-sheet::before {
        content: "CERTIFIED DRUG TEST CENTERS • OFFICIAL MRO REPORT • CONFIDENTIAL";
        position: absolute;
        top: 45%;
        left: -10%;
        width: 120%;
        font-size: 26px;
        font-weight: 900;
        letter-spacing: 4px;
        color: rgba(11, 37, 69, 0.03);
        transform: rotate(-25deg);
        pointer-events: none;
        user-select: none;
        z-index: 0;
        text-align: center;
    }

    /* Certificate Header */
    .cert-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 20px;
        border-bottom: 3px solid #0B2545;
        margin-bottom: 24px;
        position: relative;
        z-index: 1;
    }

    .cert-brand-title {
        font-family: var(--font-heading, 'Montserrat', sans-serif);
        font-size: 20px;
        font-weight: 900;
        color: #0B2545;
        letter-spacing: -0.3px;
        text-transform: uppercase;
        margin: 0 0 2px;
    }
    .cert-sub-brand {
        font-size: 11px;
        font-weight: 700;
        color: #C1121F;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }
    .cert-accreditation {
        font-size: 11px;
        color: #475569;
        margin-top: 6px;
        line-height: 1.4;
    }

    .cert-document-tag {
        text-align: right;
    }
    .cert-doc-badge {
        display: inline-block;
        background: #0B2545;
        color: #FFFFFF;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 5px 12px;
        border-radius: 4px;
        margin-bottom: 6px;
    }
    .cert-barcode {
        font-family: 'Courier New', monospace;
        font-size: 20px;
        letter-spacing: 4px;
        font-weight: bold;
        color: #0B2545;
        margin: 2px 0;
    }
    .cert-order-num {
        font-size: 12px;
        color: #64748B;
        font-weight: 600;
    }

    /* Demographics & Chain of Custody 2-Col Grid */
    .cert-info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 24px;
        position: relative;
        z-index: 1;
    }
    .cert-card-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        padding: 16px 18px;
    }
    .cert-box-title {
        font-size: 11px;
        font-weight: 800;
        color: #0B2545;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        padding-bottom: 6px;
        border-bottom: 1px solid #CBD5E1;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .cert-data-row {
        display: flex;
        justify-content: space-between;
        font-size: 12.5px;
        margin-bottom: 5px;
        line-height: 1.5;
    }
    .cert-data-row:last-child { margin-bottom: 0; }
    .cert-lbl {
        color: #64748B;
        font-weight: 600;
    }
    .cert-val {
        color: #0B2545;
        font-weight: 700;
        text-align: right;
    }

    /* Specimen Integrity Bar */
    .specimen-integrity-strip {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        border-radius: 6px;
        padding: 10px 16px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        font-size: 11.5px;
        color: #166534;
        position: relative;
        z-index: 1;
    }
    .integrity-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .integrity-item strong { color: #14532D; }

    /* Results Table */
    .cert-table-wrap {
        margin-bottom: 24px;
        position: relative;
        z-index: 1;
    }
    .cert-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12.5px;
    }
    .cert-table th {
        background: #0B2545;
        color: #FFFFFF;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        padding: 9px 12px;
        text-align: left;
    }
    .cert-table td {
        padding: 9px 12px;
        border-bottom: 1px solid #E2E8F0;
        color: #1E293B;
    }
    .cert-table tr:nth-child(even) td {
        background: #F8FAFC;
    }
    .cert-result-pill {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .cert-result-negative {
        background: #DCFCE7;
        color: #15803D;
        border: 1px solid #86EFAC;
    }
    .cert-result-positive {
        background: #FEE2E2;
        color: #B91C1C;
        border: 1px solid #FCA5A5;
    }
    .cert-result-pending {
        background: #FEF3C7;
        color: #B45309;
        border: 1px solid #FDE68A;
    }

    /* Overall Determination Banner */
    .cert-determination-banner {
        border-radius: 8px;
        padding: 18px 24px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        z-index: 1;
    }
    .det-negative {
        background: #F0FDF4;
        border: 2px solid #16A34A;
    }
    .det-positive {
        background: #FEF2F2;
        border: 2px solid #DC2626;
    }
    .det-pending {
        background: #FFFBEB;
        border: 2px solid #D97706;
    }
    .det-title {
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 2px;
    }
    .det-headline {
        font-size: 22px;
        font-weight: 900;
        letter-spacing: -0.5px;
    }

    /* MRO Signature & Attestation */
    .cert-mro-section {
        border-top: 2px solid #CBD5E1;
        padding-top: 18px;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }
    .cert-attestation-text {
        font-size: 11.5px;
        color: #475569;
        line-height: 1.6;
        margin-bottom: 16px;
        text-align: justify;
    }
    .mro-signature-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 20px;
        align-items: end;
    }
    .signature-line-box {
        border-top: 1px solid #0B2545;
        padding-top: 6px;
        margin-top: 30px;
    }
    .mro-script-signature {
        font-family: 'Brush Script MT', 'Dancing Script', cursive;
        font-size: 28px;
        color: #0B2545;
        line-height: 1;
        margin-bottom: -15px;
        padding-left: 10px;
    }
    .mro-seal-box {
        border: 2px dashed #CBD5E1;
        border-radius: 6px;
        padding: 10px;
        text-align: center;
        font-size: 11px;
        color: #64748B;
        background: #FAFAFA;
    }

    /* Certificate Footer Notice */
    .cert-footer-notice {
        font-size: 10.5px;
        color: #94A3B8;
        line-height: 1.5;
        border-top: 1px solid #E2E8F0;
        padding-top: 12px;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    /* Print Stylesheet */
    @media print {
        header, footer, .top-notice-bar, .cert-action-bar, .no-print {
            display: none !important;
        }
        body, .certificate-page-wrap {
            background: #FFFFFF !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .cert-sheet {
            max-width: 100% !important;
            border: 1px solid #000000 !important;
            box-shadow: none !important;
            padding: 24px 30px !important;
            page-break-inside: avoid;
        }
        .cert-sheet::before {
            display: none !important;
        }
    }
</style>

<div class="certificate-page-wrap">
    <!-- Top Action Bar (Hidden when printing or saving as PDF) -->
    <div class="cert-action-bar no-print">
        <div>
            <strong style="font-size:14px; color:#0B2545;">Official MRO Laboratory Report</strong>
            <span style="font-size:12.5px; color:#64748B; margin-left:8px;">Order #{{ $order->order_number }}</span>
        </div>
        <div style="display:flex; gap:10px; align-items:center;">
            <button onclick="window.print()" class="btn btn-primary btn-sm" style="display:flex; align-items:center; gap:6px;">
                <span>🖨️</span> Print / Save Official PDF
            </button>
            @if($isAdmin)
                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-outline btn-sm">
                    &larr; Back to Admin Order
                </a>
            @else
                <a href="{{ route('order.track', ['order' => $order->order_number, 'email' => $order->donor_email]) }}" class="btn btn-outline btn-sm">
                    &larr; Back to Order Tracking
                </a>
            @endif
        </div>
    </div>

    <!-- Official Printable Certificate Sheet -->
    <div class="cert-sheet" id="printableCertificate">
        <!-- Header -->
        <div class="cert-header">
            <div>
                <div class="cert-brand-title">Certified Drug Test Centers</div>
                <div class="cert-sub-brand">National Medical Review Office &bull; Forensic Toxicology Division</div>
                <div class="cert-accreditation">
                    SAMHSA / CLIA Accredited Laboratory Network &bull; Federal CLIA ID: <strong>{{ $mroDetails['clia_number'] }}</strong><br>
                    Standards: 49 CFR Part 40 &bull; CAP Accredited Reference Laboratory
                </div>
            </div>

            <div class="cert-document-tag">
                <span class="cert-doc-badge">Official Laboratory Certificate</span>
                <div class="cert-barcode">||| | |||| || ||| |||| | |||</div>
                <div class="cert-order-num">Doc ID: {{ $accessionNumber }} &bull; Order: {{ $order->order_number }}</div>
            </div>
        </div>

        <!-- Demographics & Chain of Custody Data -->
        <div class="cert-info-grid">
            <!-- Box 1: Donor Identification -->
            <div class="cert-card-box">
                <div class="cert-box-title">
                    <span>1. Donor Identification</span>
                    <span style="font-size:10px; color:#64748B;">Confidential Record</span>
                </div>
                <div class="cert-data-row">
                    <span class="cert-lbl">Donor Legal Name:</span>
                    <span class="cert-val">{{ $order->donor_full_name }}</span>
                </div>
                <div class="cert-data-row">
                    <span class="cert-lbl">Donor ID / SSN:</span>
                    <span class="cert-val">***-**-{{ $order->donor_ssn_last4 ?: 'ON-FILE' }}</span>
                </div>
                <div class="cert-data-row">
                    <span class="cert-lbl">Date of Birth:</span>
                    <span class="cert-val">{{ $order->donor_dob ? $order->donor_dob->format('M d, Y') : 'Verified by Collector' }}</span>
                </div>
                <div class="cert-data-row">
                    <span class="cert-lbl">Testing Reason:</span>
                    <span class="cert-val">{{ ucfirst($order->test_reason) }}</span>
                </div>
                <div class="cert-data-row">
                    <span class="cert-lbl">Requesting Entity:</span>
                    <span class="cert-val">Certified Drug Test Centers Corporate</span>
                </div>
            </div>

            <!-- Box 2: Specimen & Chain of Custody -->
            <div class="cert-card-box">
                <div class="cert-box-title">
                    <span>2. Chain of Custody &amp; Collection</span>
                    <span style="font-size:10px; color:#16A34A;">CCF Verified</span>
                </div>
                <div class="cert-data-row">
                    <span class="cert-lbl">Custody Form (CCF) #:</span>
                    <span class="cert-val">{{ $order->ccf_number ?: 'CCF-' . strtoupper(substr(md5($order->id . 'cdtc'), 0, 8)) }}</span>
                </div>
                <div class="cert-data-row">
                    <span class="cert-lbl">Accession Number:</span>
                    <span class="cert-val">{{ $accessionNumber }}</span>
                </div>
                <div class="cert-data-row">
                    <span class="cert-lbl">Collection Site:</span>
                    <span class="cert-val">{{ $order->location ? $order->location->name : 'Certified National Collection Site' }}</span>
                </div>
                <div class="cert-data-row">
                    <span class="cert-lbl">Collection Date / Time:</span>
                    <span class="cert-val">{{ $collectionDate->format('M d, Y h:i A') }}</span>
                </div>
                <div class="cert-data-row">
                    <span class="cert-lbl">Specimen Modality:</span>
                    <span class="cert-val">{{ $specimenValidity['specimen_type'] }} Specimen</span>
                </div>
            </div>
        </div>

        <!-- Specimen Integrity Verification Bar -->
        <div class="specimen-integrity-strip">
            <div class="integrity-item">
                <span>✓</span> <strong>Temp (90.0°-100.0°F):</strong> Within Range
            </div>
            <div class="integrity-item">
                <span>✓</span> <strong>Split Specimen:</strong> Collected &amp; Sealed
            </div>
            <div class="integrity-item">
                <span>✓</span> <strong>Tamper Seals:</strong> Intact (A &amp; B)
            </div>
            <div class="integrity-item">
                <span>✓</span> <strong>Adulteration Screen:</strong> Negative / Normal
            </div>
        </div>

        <!-- Analyte Screening & Confirmation Matrix Table -->
        <div class="cert-table-wrap">
            <table class="cert-table">
                <thead>
                    <tr>
                        <th style="width:34%;">Substance / Drug Class Analyzed</th>
                        <th style="width:18%;">Screening Cut-Off</th>
                        <th style="width:18%;">Confirmation Cut-Off</th>
                        <th style="width:16%;">Methodology</th>
                        <th style="width:14%; text-align:right;">Determination</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($analytes as $a)
                    <tr>
                        <td>
                            <strong>{{ $a['name'] }}</strong><br>
                            <span style="font-size:11px; color:#64748B;">{{ $a['analyte'] }}</span>
                        </td>
                        <td>{{ $a['screen_cutoff'] }}</td>
                        <td>{{ $a['conf_cutoff'] }}</td>
                        <td style="font-size:11.5px; color:#475569;">{{ $a['method'] }}</td>
                        <td style="text-align:right;">
                            @if($a['is_positive'])
                                <span class="cert-result-pill cert-result-positive">POSITIVE</span>
                            @elseif(str_contains($a['result'], 'PENDING'))
                                <span class="cert-result-pill cert-result-pending">PENDING</span>
                            @else
                                <span class="cert-result-pill cert-result-negative">NEGATIVE</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Overall MRO Determination Banner -->
        @if($order->result_outcome === 'negative')
            <div class="cert-determination-banner det-negative">
                <div>
                    <div class="det-title" style="color:#15803D;">FINAL LABORATORY DETERMINATION</div>
                    <div class="det-headline" style="color:#14532D;">✓ VERIFIED NEGATIVE (PASSED)</div>
                    <div style="font-size:12px; color:#166534; margin-top:2px;">
                        All tested analytes were detected below the established screening cut-off levels.
                    </div>
                </div>
                <div style="text-align:right;">
                    <div style="background:#16A34A; color:#FFFFFF; font-size:12px; font-weight:800; padding:6px 14px; border-radius:4px; text-transform:uppercase;">
                        PASSED
                    </div>
                </div>
            </div>
        @elseif($order->result_outcome === 'positive')
            <div class="cert-determination-banner det-positive">
                <div>
                    <div class="det-title" style="color:#B91C1C;">FINAL LABORATORY DETERMINATION</div>
                    <div class="det-headline" style="color:#7F1D1D;">⚠ VERIFIED POSITIVE (NON-NEGATIVE)</div>
                    <div style="font-size:12px; color:#991B1B; margin-top:2px;">
                        One or more target analytes were confirmed above the established cut-off threshold.
                    </div>
                </div>
                <div style="text-align:right;">
                    <div style="background:#DC2626; color:#FFFFFF; font-size:12px; font-weight:800; padding:6px 14px; border-radius:4px; text-transform:uppercase;">
                        NON-NEGATIVE
                    </div>
                </div>
            </div>
        @else
            <div class="cert-determination-banner det-pending">
                <div>
                    <div class="det-title" style="color:#B45309;">LABORATORY STATUS</div>
                    <div class="det-headline" style="color:#78350F;">⏳ PENDING FINAL MRO CONFIRMATION</div>
                    <div style="font-size:12px; color:#92400E; margin-top:2px;">
                        Specimen received by certified reference laboratory; final verification in progress.
                    </div>
                </div>
                <div style="text-align:right;">
                    <div style="background:#D97706; color:#FFFFFF; font-size:12px; font-weight:800; padding:6px 14px; border-radius:4px; text-transform:uppercase;">
                        IN PROCESS
                    </div>
                </div>
            </div>
        @endif

        @if(!empty($order->mro_notes))
        <!-- MRO Physician Clinical Notes -->
        <div style="background:#F8FAFC; border:1px solid #CBD5E1; border-radius:6px; padding:12px 16px; margin-bottom:20px;">
            <div style="font-size:11px; font-weight:800; color:#0B2545; text-transform:uppercase; margin-bottom:4px;">Medical Review Officer (MRO) Clinical Remarks:</div>
            <div style="font-size:12px; color:#334155; line-height:1.5;">{{ $order->mro_notes }}</div>
        </div>
        @endif

        <!-- MRO Physician Certification Statement -->
        <div class="cert-mro-section">
            <p class="cert-attestation-text">
                <strong>Medical Review Officer (MRO) Certification Statement:</strong> I certify that I am a licensed physician certified as a Medical Review Officer (MRO) in accordance with U.S. Department of Transportation regulations (49 CFR Part 40) and clinical forensic standards. I have reviewed the chain of custody documentation, laboratory analytical data, and specimen integrity records. The verified result indicated above represents the definitive medical and legal determination for this testing order.
            </p>

            <div class="mro-signature-grid">
                <div>
                    <div class="mro-script-signature">Dr. Robert S. Vance, M.D.</div>
                    <div class="signature-line-box">
                        <strong style="font-size:13px; color:#0B2545;">{{ $mroDetails['name'] }}</strong> &bull; <span style="font-size:12px; color:#475569;">{{ $mroDetails['title'] }}</span><br>
                        <span style="font-size:11.5px; color:#64748B;">
                            Registry: <strong>{{ $mroDetails['cert_body'] }}</strong> &bull; Verification Date: <strong>{{ $mroVerificationDate ? $mroVerificationDate->format('M d, Y h:i A') : now()->format('M d, Y h:i A') }}</strong>
                        </span>
                    </div>
                </div>

                <div class="mro-seal-box">
                    <strong style="color:#0B2545; display:block; text-transform:uppercase; font-size:10.5px;">National MRO Office Seal</strong>
                    <div style="font-size:11px; color:#16A34A; font-weight:800; margin:4px 0;">ELECTRONICALLY VERIFIED</div>
                    <span style="font-size:10px; color:#94A3B8;">CLIA # {{ $mroDetails['clia_number'] }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Legal & Privacy Notice -->
        <div class="cert-footer-notice">
            CONFIDENTIAL MEDICAL RECORD: This document contains protected health information (PHI) governed by HIPAA (45 CFR Parts 160 &amp; 164) and federal drug testing confidentiality standards. Unauthorized review, disclosure, copying, or distribution is strictly prohibited. If you are not the intended recipient, please immediately contact Certified Drug Test Centers at {{ $mroDetails['phone'] }}.
        </div>
    </div>
</div>
@endsection
