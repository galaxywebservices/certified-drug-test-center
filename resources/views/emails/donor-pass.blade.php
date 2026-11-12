<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payment &amp; Order Receipt</title>
</head>
<body style="margin:0; padding:0; background-color:#F8FAFC; font-family:'Helvetica Neue', Arial, sans-serif; color:#334155;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#F8FAFC; padding:30px 15px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden; border:1px solid #E2E8F0; box-shadow:0 4px 12px rgba(11,37,69,0.06);">
                    <!-- Header -->
                    <tr>
                        <td style="background:#0B2545; padding:28px 32px; border-bottom:3px solid #C1121F;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <div style="color:#CBD5E1; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">Certified Drug Test Centers</div>
                                        <div style="color:#ffffff; font-size:22px; font-weight:800; margin-top:4px;">Payment &amp; Order Receipt</div>
                                    </td>
                                    <td align="right">
                                        <div style="color:#94A3B8; font-size:11px; text-transform:uppercase; letter-spacing:0.5px;">Order Number:</div>
                                        <div style="color:#FFFFFF; font-size:18px; font-weight:800; font-family:'Courier New', monospace;">{{ $order->order_number }}</div>
                                        <div style="color:#CBD5E1; font-size:12px; margin-top:2px;">{{ $order->created_at ? $order->created_at->format('M d, Y • h:i A T') : now()->format('M d, Y • h:i A T') }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Payment Summary Badge -->
                    <tr>
                        <td style="padding:24px 32px 0;">
                            <div style="background:#ECFDF5; border:1px solid #A7F3D0; border-radius:8px; padding:16px 20px;">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <span style="display:inline-block; background:#10B981; color:#ffffff; font-size:11px; font-weight:800; padding:3px 10px; border-radius:999px; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:4px;">PAID IN FULL</span>
                                            <div style="color:#065F46; font-size:18px; font-weight:800;">
                                                Total Paid: ${{ number_format($order->total, 2) }}
                                            </div>
                                            @if(!empty($order->paytrace_transaction_id) || !empty($order->paytrace_approval_code))
                                            <div style="color:#047857; font-size:12px; margin-top:2px;">
                                                Gateway Ref: {{ $order->paytrace_transaction_id ?? $order->paytrace_approval_code }}
                                            </div>
                                            @endif
                                        </td>
                                        <td align="right" style="color:#047857; font-size:13px;">
                                            <div><strong>Status:</strong> Completed</div>
                                            <div><strong>Method:</strong> Credit Card</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- Customer & Registration Details -->
                    <tr>
                        <td style="padding:20px 32px 14px;">
                            <h3 style="font-size:15px; font-weight:800; color:#0B2545; margin:0 0 12px; border-bottom:1px solid #F1F5F9; padding-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                                Customer / Donor Information
                            </h3>
                            
                            <table width="100%" cellpadding="6" cellspacing="0" style="font-size:14px; border-collapse:collapse;">
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td width="35%" style="color:#64748B; font-weight:600;">Full Name:</td>
                                    <td style="color:#0B2545; font-weight:700;">{{ $order->donor_full_name }}</td>
                                </tr>
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">Email Address:</td>
                                    <td style="color:#0B2545;">{{ $order->donor_email }}</td>
                                </tr>
                                @if(!empty($order->results_email) && $order->results_email !== $order->donor_email)
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">Results Email:</td>
                                    <td style="color:#0B2545; font-weight:700;">{{ $order->results_email }}</td>
                                </tr>
                                @endif
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">Contact Phone:</td>
                                    <td style="color:#0B2545;">{{ $order->donor_phone }}</td>
                                </tr>
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">Reason for Test:</td>
                                    <td style="color:#0B2545; font-weight:700;">{{ ucfirst($order->test_reason) }}</td>
                                </tr>
                                @if($order->corporate_account_id && $order->corporateAccount)
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">Sponsoring Employer:</td>
                                    <td style="color:#0B2545; font-weight:700;">{{ $order->corporateAccount->company_name }}</td>
                                </tr>
                                @endif
                                @if(!empty($order->dot_agency))
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">DOT Regulated Mode:</td>
                                    <td style="color:#0B2545; font-weight:700;">{{ $order->dot_agency }}</td>
                                </tr>
                                @endif
                            </table>
                        </td>
                    </tr>

                    <!-- Purchased Services Table -->
                    <tr>
                        <td style="padding:6px 32px 14px;">
                            <h3 style="font-size:15px; font-weight:800; color:#0B2545; margin:0 0 12px; border-bottom:1px solid #F1F5F9; padding-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                                Purchased Testing Services
                            </h3>

                            <table width="100%" cellpadding="10" cellspacing="0" style="border:1px solid #E2E8F0; border-radius:8px; background:#F8FAFC; font-size:14px; border-collapse:collapse;">
                                <thead>
                                    <tr style="background:#0B2545; color:#ffffff; font-size:12px; text-transform:uppercase; letter-spacing:0.5px;">
                                        <th align="left" style="padding:10px 14px;">Service Description</th>
                                        <th align="center" style="padding:10px 14px;">Qty</th>
                                        <th align="right" style="padding:10px 14px;">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->items as $item)
                                    <tr style="border-bottom:1px solid #E2E8F0; background:#ffffff;">
                                        <td style="padding:12px 14px; font-weight:700; color:#0B2545;">
                                            {{ $item->product_name }}
                                        </td>
                                        <td align="center" style="padding:12px 14px; color:#64748B;">
                                            {{ $item->quantity }}
                                        </td>
                                        <td align="right" style="padding:12px 14px; font-weight:800; color:#C1121F;">
                                            ${{ number_format($item->price * $item->quantity, 2) }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr style="background:#ffffff;">
                                        <td colspan="3" style="padding:12px 14px; color:#64748B;">Standard Drug Screening Registration</td>
                                    </tr>
                                    @endforelse
                                    <tr style="background:#F1F5F9; font-weight:800;">
                                        <td colspan="2" align="right" style="padding:10px 14px; color:#0B2545;">Total Paid:</td>
                                        <td align="right" style="padding:10px 14px; color:#C1121F; font-size:16px;">
                                            ${{ number_format($order->total, 2) }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                    <!-- Facility / Collection Site -->
                    <tr>
                        <td style="padding:6px 32px 20px;">
                            <h3 style="font-size:15px; font-weight:800; color:#0B2545; margin:0 0 12px; border-bottom:1px solid #F1F5F9; padding-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                                Assigned Collection Facility
                            </h3>

                            <div style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                                @if($order->location)
                                    <div style="font-size:15px; font-weight:800; color:#0B2545;">
                                        {{ $order->location->name }} ({{ strtoupper($order->location->provider) }})
                                    </div>
                                    <div style="font-size:13.5px; color:#475569; margin-top:4px;">
                                        {{ $order->location->address1 }}, {{ $order->location->city }}, {{ $order->location->state }} {{ $order->location->zip }}
                                    </div>
                                    @if(!empty($order->location->phone))
                                    <div style="font-size:13px; color:#64748B; margin-top:4px;">
                                        Phone: {{ $order->location->phone }}
                                    </div>
                                    @endif
                                @else
                                    <div style="font-size:14.5px; font-weight:700; color:#0B2545;">
                                        Quest Diagnostics &amp; Labcorp Nationwide Walk-in Network
                                    </div>
                                    <div style="font-size:13px; color:#64748B; margin-top:4px;">
                                        Assigned to nearest certified collection facility by donor ZIP.
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#F8FAFC; padding:20px 32px; border-top:1px solid #E2E8F0; text-align:center; font-size:12px; color:#64748B;">
                            <div>Certified National Specimen Collection &amp; SAMHSA Accredited Laboratory Network</div>
                            <div style="margin-top:6px;">Questions regarding this receipt? Call Toll-Free <strong>(800)-985-4339</strong> or email <strong>support@certifieddrugtestingcenters.com</strong></div>
                            <div style="margin-top:6px; color:#94A3B8;">&copy; {{ date('Y') }} Certified Drug Test Centers. All Rights Reserved.</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
