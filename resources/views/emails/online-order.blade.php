<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Online Order Notification</title>
</head>
<body style="margin:0; padding:0; background-color:#F1F5F9; font-family:'Helvetica Neue', Arial, sans-serif; color:#334155;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#F1F5F9; padding:30px 15px;">
        <tr>
            <td align="center">
                <table width="640" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #E2E8F0; box-shadow:0 4px 14px rgba(11,37,69,0.08);">
                    <!-- Header -->
                    <tr>
                        <td style="background:#0B2545; padding:28px 32px; border-bottom:3px solid #C1121F;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <div style="color:#CBD5E1; font-size:11px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase;">Certified Drug Test Centers</div>
                                        <div style="color:#ffffff; font-size:22px; font-weight:800; margin-top:4px;">🚨 New Online Order Received</div>
                                    </td>
                                    <td align="right">
                                        <div style="color:#94A3B8; font-size:11px; font-weight:700; text-transform:uppercase; letter-spacing:0.5px;">Order Number</div>
                                        <div style="color:#FFFFFF; font-size:18px; font-weight:800; font-family:'Courier New', monospace;">{{ $order->order_number }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Alert Badge & Payment Summary -->
                    <tr>
                        <td style="padding:24px 32px 0;">
                            <div style="background:#ECFDF5; border:1px solid #A7F3D0; border-radius:8px; padding:16px 20px;">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td>
                                            <span style="display:inline-block; background:#10B981; color:#ffffff; font-size:11px; font-weight:800; padding:3px 10px; border-radius:999px; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px;">Paid &amp; Confirmed</span>
                                            <div style="color:#065F46; font-size:16px; font-weight:800;">
                                                Total Paid: ${{ number_format($order->total, 2) }}
                                            </div>
                                            <div style="color:#047857; font-size:12.5px; margin-top:2px;">
                                                Gateway: PayTrace (Trans ID: <strong>{{ $order->paytrace_transaction_id ?? 'N/A' }}</strong>{{ $order->paytrace_approval_code ? ' • Approval: ' . $order->paytrace_approval_code : '' }})
                                            </div>
                                        </td>
                                        <td align="right" style="color:#047857; font-size:12.5px;">
                                            <div><strong>Order Placed:</strong></div>
                                            <div>{{ $order->created_at ? $order->created_at->format('M d, Y • h:i A T') : now()->format('M d, Y • h:i A T') }}</div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>

                    <!-- Donor & Registration Details -->
                    <tr>
                        <td style="padding:24px 32px 14px;">
                            <h3 style="font-size:16px; font-weight:800; color:#0B2545; margin:0 0 12px; border-bottom:2px solid #F1F5F9; padding-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                                👤 Donor Information
                            </h3>
                            
                            <table width="100%" cellpadding="6" cellspacing="0" style="font-size:14px; border-collapse:collapse;">
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td width="35%" style="color:#64748B; font-weight:600;">Donor Full Name:</td>
                                    <td style="color:#0B2545; font-weight:800; font-size:15px;">{{ $order->donor_full_name }}</td>
                                </tr>
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">Date of Birth:</td>
                                    <td style="color:#0B2545; font-weight:700;">{{ $order->donor_dob ? date('m/d/Y', strtotime($order->donor_dob)) : 'Not Provided' }}</td>
                                </tr>
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">Donor Email:</td>
                                    <td style="color:#0B2545;">
                                        <a href="mailto:{{ $order->donor_email }}" style="color:#0B2545; font-weight:700; text-decoration:none;">{{ $order->donor_email }}</a>
                                    </td>
                                </tr>
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">Results Email:</td>
                                    <td style="color:#0B2545;">
                                        <a href="mailto:{{ $order->results_email ?? $order->donor_email }}" style="color:#0B2545; font-weight:700; text-decoration:none;">{{ $order->results_email ?? $order->donor_email }}</a>
                                    </td>
                                </tr>
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">Donor Phone:</td>
                                    <td style="color:#0B2545; font-weight:700;">{{ $order->donor_phone }}</td>
                                </tr>
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">Reason for Test:</td>
                                    <td style="color:#C1121F; font-weight:800;">{{ ucfirst($order->test_reason) }}</td>
                                </tr>
                                @if(!empty($order->donor_id_number))
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">Donor ID / SSN:</td>
                                    <td style="color:#0B2545; font-weight:700; font-family:'Courier New', monospace;">{{ $order->donor_id_number }}</td>
                                </tr>
                                @endif
                                @if(!empty($order->dot_agency))
                                <tr style="border-bottom:1px solid #F8FAFC; background:#FEF2F2;">
                                    <td style="color:#991B1B; font-weight:700;">DOT Regulated Mode:</td>
                                    <td style="color:#991B1B; font-weight:800;">{{ $order->dot_agency }}</td>
                                </tr>
                                @endif
                                @if(!empty($order->cdl_number))
                                <tr style="border-bottom:1px solid #F8FAFC; background:#FEF2F2;">
                                    <td style="color:#991B1B; font-weight:700;">CDL License # &amp; State:</td>
                                    <td style="color:#991B1B; font-weight:800;">{{ $order->cdl_number }} ({{ $order->cdl_state }})</td>
                                </tr>
                                @endif
                                <tr style="border-bottom:1px solid #F8FAFC;">
                                    <td style="color:#64748B; font-weight:600;">Registration IP Address:</td>
                                    <td style="color:#64748B; font-family:'Courier New', monospace; font-size:12px;">{{ $order->donor_ip ?? 'Unknown' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Ordered Products / Services -->
                    <tr>
                        <td style="padding:10px 32px 14px;">
                            <h3 style="font-size:16px; font-weight:800; color:#0B2545; margin:0 0 12px; border-bottom:2px solid #F1F5F9; padding-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                                🧪 Ordered Tests &amp; Panels
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
                        <td style="padding:10px 32px 14px;">
                            <h3 style="font-size:16px; font-weight:800; color:#0B2545; margin:0 0 12px; border-bottom:2px solid #F1F5F9; padding-bottom:8px; text-transform:uppercase; letter-spacing:0.5px;">
                                📍 Assigned Collection Center
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

                    <!-- Barcode & Authorization CCF -->
                    <tr>
                        <td style="padding:10px 32px 24px;">
                            <div style="background:#F8FAFC; border:1px dashed #CBD5E1; border-radius:8px; padding:18px; text-align:center;">
                                <div style="font-size:11px; font-weight:800; text-transform:uppercase; color:#64748B; letter-spacing:1px;">Electronic Chain of Custody &amp; Authorization Barcode</div>
                                <div style="font-family:'Courier New', monospace; font-size:30px; font-weight:bold; letter-spacing:6px; color:#0B2545; margin:8px 0 4px;">
                                    ||| | |||| || ||| |||| | |||
                                </div>
                                <div style="font-size:14px; font-weight:800; color:#0B2545; letter-spacing:2px; font-family:'Courier New', monospace;">
                                    *{{ $order->order_number }}*
                                </div>
                                @if(!empty($order->ccf_number))
                                <div style="font-size:12px; color:#64748B; margin-top:6px;">
                                    CCF Tracking: <strong>{{ $order->ccf_number }}</strong>
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Action Buttons -->
                    <tr>
                        <td style="padding:0 32px 30px; text-align:center;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/admin/orders/' . $order->id) }}" style="display:inline-block; background:#0B2545; color:#ffffff; font-size:14px; font-weight:800; padding:12px 24px; border-radius:6px; text-decoration:none; margin:0 6px 8px 6px;">
                                            Open Order in Admin Panel &rarr;
                                        </a>
                                        <a href="{{ route('checkout.confirmation', $order->donor_pass_token) }}" style="display:inline-block; background:#C1121F; color:#ffffff; font-size:14px; font-weight:800; padding:12px 24px; border-radius:6px; text-decoration:none; margin:0 6px 8px 6px;">
                                            View Electronic Donor Pass &rarr;
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#F8FAFC; padding:20px 32px; border-top:1px solid #E2E8F0; text-align:center; font-size:12px; color:#64748B;">
                            <div><strong>Certified Drug Test Centers</strong> • Automated Online Order Dispatch</div>
                            <div style="margin-top:4px; color:#94A3B8;">This is an automated dispatch notification sent to onlineorders@accrediteddrugtesting.com with BCC to designated dispatch monitors.</div>
                            <div style="margin-top:6px; color:#94A3B8;">&copy; {{ date('Y') }} Certified Drug Test Centers. All Rights Reserved.</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

