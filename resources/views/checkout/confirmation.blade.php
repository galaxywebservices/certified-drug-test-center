@extends('layouts.main')

@section('content')
<style>
    @media print {
        header, footer, .top-notice-bar, .no-print { display: none !important; }
        body { background: #fff !important; }
        .receipt-container { box-shadow: none !important; border: 1px solid #CBD5E1 !important; margin: 0 !important; width: 100% !important; max-width: 100% !important; }
    }

    .receipt-wrapper {
        padding: 40px 15px 80px;
        background: #F8FAFC;
    }

    .receipt-container {
        max-width: 780px;
        margin: 0 auto;
        background: #fff;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(11, 37, 69, 0.06);
        overflow: hidden;
    }

    .receipt-header {
        background: #0B2545;
        color: #fff;
        padding: 24px 32px;
        border-bottom: 3px solid #C1121F;
    }

    .receipt-body {
        padding: 32px;
    }

    .receipt-table th {
        background: #F1F5F9;
        color: #0B2545;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 14px;
        border-bottom: 1px solid #E2E8F0;
    }

    .receipt-table td {
        padding: 12px 14px;
        font-size: 14px;
        border-bottom: 1px solid #E2E8F0;
        color: #334155;
    }
</style>

<div class="receipt-wrapper">
    <div class="container">
        <!-- Status Notification Banner -->
        <div style="max-width:780px; margin:0 auto 20px;">
            <div style="background:#ECFDF5; border:1px solid #A7F3D0; border-radius:10px; padding:16px 20px; display:flex; align-items:center; gap:12px;">
                <div style="font-size:24px; color:#10B981; line-height:1;">✓</div>
                <div>
                    <div style="font-size:16px; font-weight:800; color:#065F46;">Order Placed &amp; Payment Successful</div>
                    <div style="font-size:13.5px; color:#047857; margin-top:2px;">
                        Thank you for your order. A copy of this receipt has been emailed to <strong>{{ $order->donor_email }}</strong>.
                    </div>
                </div>
            </div>
        </div>

        <!-- Official Order Receipt Card -->
        <div class="receipt-container">
            <!-- Receipt Header -->
            <div class="receipt-header">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <div style="font-size:11px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; color:#CBD5E1;">Certified Drug Test Centers</div>
                            <div style="font-size:22px; font-weight:800; color:#ffffff; margin-top:4px;">Payment &amp; Order Receipt</div>
                        </td>
                        <td align="right">
                            <div style="font-size:11px; color:#94A3B8; text-transform:uppercase; letter-spacing:0.5px;">Order Number</div>
                            <div style="font-size:18px; font-weight:800; color:#ffffff; font-family:'Courier New', monospace;">{{ $order->order_number }}</div>
                            <div style="font-size:12px; color:#CBD5E1; margin-top:2px;">{{ $order->created_at ? $order->created_at->format('M d, Y • h:i A T') : now()->format('M d, Y • h:i A T') }}</div>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Receipt Body -->
            <div class="receipt-body">
                <!-- Payment Badge -->
                <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px 20px; margin-bottom:24px;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <span style="display:inline-block; background:#10B981; color:#fff; font-size:11px; font-weight:800; padding:3px 10px; border-radius:999px; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">PAID IN FULL</span>
                                <div style="font-size:20px; font-weight:800; color:#0B2545;">
                                    ${{ number_format($order->total, 2) }}
                                </div>
                            </td>
                            <td align="right" style="font-size:13px; color:#64748B;">
                                <div><strong>Payment Method:</strong> Credit Card (PayTrace)</div>
                                @if(!empty($order->paytrace_transaction_id) || !empty($order->paytrace_approval_code))
                                <div style="margin-top:2px;">
                                    Ref / Trans ID: <strong>{{ $order->paytrace_transaction_id ?? $order->paytrace_approval_code }}</strong>
                                </div>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Customer Details & Collection Center Grid -->
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:24px;">
                    <!-- Customer Information -->
                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                        <div style="font-size:12px; font-weight:800; text-transform:uppercase; color:#64748B; letter-spacing:0.5px; margin-bottom:8px;">
                            Donor / Customer Information
                        </div>
                        <div style="font-size:15px; font-weight:700; color:#0B2545;">{{ $order->donor_full_name }}</div>
                        <div style="font-size:13.5px; color:#475569; margin-top:4px; line-height:1.6;">
                            Email: {{ $order->donor_email }}<br>
                            @if(!empty($order->results_email) && $order->results_email !== $order->donor_email)
                            Results Email: {{ $order->results_email }}<br>
                            @endif
                            Phone: {{ $order->donor_phone }}<br>
                            Reason: {{ ucfirst($order->test_reason) }}
                            @if(!empty($order->dot_agency))
                            <br>DOT Regulated: {{ $order->dot_agency }}
                            @endif
                        </div>
                    </div>

                    <!-- Assigned Collection Facility -->
                    <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                        <div style="font-size:12px; font-weight:800; text-transform:uppercase; color:#64748B; letter-spacing:0.5px; margin-bottom:8px;">
                            Assigned Collection Facility
                        </div>
                        @if($order->location)
                            <div style="font-size:15px; font-weight:700; color:#0B2545;">
                                {{ $order->location->name }} ({{ strtoupper($order->location->provider) }})
                            </div>
                            <div style="font-size:13.5px; color:#475569; margin-top:4px; line-height:1.6;">
                                {{ $order->location->address1 }}<br>
                                {{ $order->location->city }}, {{ $order->location->state }} {{ $order->location->zip }}<br>
                                @if(!empty($order->location->phone))
                                Phone: {{ $order->location->phone }}
                                @endif
                            </div>
                        @else
                            <div style="font-size:14.5px; font-weight:700; color:#0B2545;">
                                Quest Diagnostics &amp; Labcorp Nationwide Walk-in Network
                            </div>
                            <div style="font-size:13px; color:#64748B; margin-top:4px;">
                                Assigned to nearest certified facility based on donor ZIP.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Purchased Services Table -->
                <div style="margin-bottom:24px;">
                    <div style="font-size:12px; font-weight:800; text-transform:uppercase; color:#64748B; letter-spacing:0.5px; margin-bottom:8px;">
                        Purchased Testing Services
                    </div>
                    <table class="receipt-table" width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #E2E8F0; border-radius:8px; overflow:hidden; border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th align="left">Service Description</th>
                                <th align="center" width="80">Qty</th>
                                <th align="right" width="120">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $item)
                            <tr>
                                <td style="font-weight:700; color:#0B2545;">
                                    {{ $item->product_name }}
                                    <div style="font-size:12px; font-weight:400; color:#64748B; margin-top:2px;">
                                        Includes laboratory analysis &amp; Medical Review Officer (MRO) review
                                    </div>
                                </td>
                                <td align="center" style="color:#64748B;">{{ $item->quantity }}</td>
                                <td align="right" style="font-weight:700; color:#0B2545;">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" style="color:#64748B;">Standard Drug Screening Package</td>
                            </tr>
                            @endforelse
                            <tr style="background:#F8FAFC; font-weight:800;">
                                <td colspan="2" align="right" style="padding:14px; color:#0B2545; font-size:14px;">Total Paid:</td>
                                <td align="right" style="padding:14px; color:#C1121F; font-size:18px;">
                                    ${{ number_format($order->total, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Support & Assistance -->
                <div style="background:#F1F5F9; border-radius:8px; padding:16px 20px; font-size:13px; color:#475569; line-height:1.6;">
                    <strong>Questions regarding your order?</strong><br>
                    Please contact our support team at <strong>(800)-985-4339</strong> or email <strong>support@certifieddrugtestingcenters.com</strong>.<br>
                    Customer service is available Monday through Friday 7:00 AM – 8:00 PM EST.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
