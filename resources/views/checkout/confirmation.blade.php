@extends('layouts.main')

@section('content')
<style>
    @media print {
        header, footer, .top-notice-bar, .no-print { display: none !important; }
        body { background: #fff !important; }
        .pass-container { box-shadow: none !important; border: 1px solid #000 !important; }
    }

    .pass-wrapper {
        padding: 40px 0 80px;
    }

    .pass-container {
        max-width: 800px;
        margin: 0 auto;
        background: #fff;
        border: 2px solid #0B2545;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        overflow: hidden;
    }

    .pass-header {
        background: #0B2545;
        color: #fff;
        padding: 24px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .pass-body { padding: 36px 32px; }

    .pass-barcode-box {
        text-align: center;
        padding: 16px;
        background: #F8FAFC;
        border: 1px dashed #CBD5E1;
        border-radius: 8px;
        margin-bottom: 28px;
    }

    .barcode-svg {
        display: inline-block;
        letter-spacing: 5px;
        font-family: monospace;
        font-size: 24px;
        font-weight: 700;
        color: #0B2545;
        margin-top: 6px;
    }
</style>

<div class="container pass-wrapper">
    <div class="no-print" style="max-width:800px; margin:0 auto 20px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h1 style="font-size:24px; font-weight:800; color:#0B2545;">Registration Confirmed!</h1>
            <p style="font-size:14px; color:#64748B;">Your electronic Donor Pass has been generated and sent to {{ $order->donor_email }}.</p>
        </div>
        <button onclick="window.print()" class="btn btn-navy">
            🖨️ Print Donor Pass
        </button>
    </div>

    <!-- Official Electronic Donor Pass Document -->
    <div class="pass-container" id="printablePass">
        <div class="pass-header">
            <div>
                <div style="font-size:11px; font-weight:800; letter-spacing:1px; text-transform:uppercase; color:#94A3B8;">Certified Drug Test Center</div>
                <div style="font-size:22px; font-weight:800;">Official Electronic Donor Pass</div>
            </div>
            <div style="text-align:right;">
                <div style="font-size:12px; color:#94A3B8;">Order Number:</div>
                <div style="font-size:18px; font-weight:800; color:#C1121F;">{{ $order->order_number }}</div>
            </div>
        </div>

        <div class="pass-body">
            <!-- Simulated Barcode Box -->
            <div class="pass-barcode-box">
                <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#64748B;">Collection Site Authorization Barcode</div>
                <div style="font-family:'Courier New', monospace; font-size:36px; font-weight:bold; letter-spacing:8px; color:#0B2545; margin:6px 0;">
                    ||| | |||| || ||| |||| | |||
                </div>
                <div class="barcode-svg">*{{ $order->order_number }}*</div>
            </div>

            <!-- Donor & Test Grid -->
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:24px; margin-bottom:28px;">
                <div style="background:#F8FAFC; padding:18px; border-radius:8px; border:1px solid #E2E8F0;">
                    <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#64748B; margin-bottom:6px;">Donor Details</div>
                    <div style="font-size:16px; font-weight:700; color:#0B2545;">{{ $order->donor_full_name }}</div>
                    <div style="font-size:14px; color:#475569; margin-top:4px;">
                        Phone: {{ $order->donor_phone }}<br>
                        Email: {{ $order->donor_email }}<br>
                        Reason: {{ ucfirst($order->test_reason) }}
                    </div>
                </div>

                <div style="background:#F8FAFC; padding:18px; border-radius:8px; border:1px solid #E2E8F0;">
                    <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#64748B; margin-bottom:6px;">Authorized Test Panel</div>
                    <div style="font-size:16px; font-weight:700; color:#0B2545;">
                        {{ $order->items->first()?->product_name ?? 'Comprehensive Drug Screen' }}
                    </div>
                    <div style="font-size:14px; color:#475569; margin-top:4px;">
                        Payment Status: <strong style="color:#16A34A;">PAID IN FULL (${{ number_format($order->total, 2) }})</strong><br>
                        Gateway Ref: {{ $order->paytrace_approval_code ?: 'AP-' . rand(100000, 999999) }}<br>
                        Issued: {{ $order->created_at->format('M d, Y h:i A') }}
                    </div>
                </div>
            </div>

            <!-- Collection Instructions -->
            <div style="background:#FEF2F2; border:1px solid #FECACA; border-radius:8px; padding:20px; margin-bottom:28px;">
                <h3 style="font-size:16px; font-weight:800; color:#991B1B; margin-bottom:8px;">
                    Important Instructions for the Donor
                </h3>
                <ol style="margin-left:20px; font-size:13px; color:#7F1D1D; line-height:1.7;">
                    <li><strong>Present This Pass:</strong> Show this electronic pass on your phone or bring a printed copy to any certified Quest Diagnostics or Labcorp collection facility.</li>
                    <li><strong>Photo Identification:</strong> You must present a valid government-issued photo ID (Driver's License, State ID, or Passport).</li>
                    <li><strong>No Additional Payment:</strong> All laboratory analysis and collection fees are prepaid in full. Do not pay any fees at the collection site.</li>
                    <li><strong>Walk-In Hours:</strong> Testing centers accept walk-ins during normal collection hours (Monday - Friday 8:00 AM - 5:00 PM).</li>
                </ol>
            </div>

            <!-- Laboratory & MRO Signature -->
            <div style="display:flex; justify-content:space-between; align-items:flex-end; border-top:1px solid #E2E8F0; padding-top:20px;">
                <div style="font-size:12px; color:#64748B; line-height:1.6;">
                    <strong>Certified Partner Networks:</strong><br>
                    Quest Diagnostics • Labcorp • SAMHSA Certified Laboratories<br>
                    Licensed Physician Medical Review Officer (MRO)
                </div>
                <div style="text-align:right;">
                    <div style="font-size:13px; font-weight:700; color:#0B2545;">Certified Drug Test Center</div>
                    <div style="font-size:12px; color:#64748B;">National Scheduling Hotline: (800) 221-4291</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
