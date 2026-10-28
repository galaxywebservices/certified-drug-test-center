<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Official Electronic Donor Pass</title>
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
                                        <div style="color:#CBD5E1; font-size:11px; font-weight:700; letter-spacing:1px; text-transform:uppercase;">Certified Drug Test Center</div>
                                        <div style="color:#ffffff; font-size:22px; font-weight:800; margin-top:4px;">Official Electronic Donor Pass</div>
                                    </td>
                                    <td align="right">
                                        <div style="color:#94A3B8; font-size:12px;">Order Number:</div>
                                        <div style="color:#FFFFFF; font-size:18px; font-weight:800;">{{ $order->order_number }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Barcode Box -->
                    <tr>
                        <td style="padding:28px 32px 14px;">
                            <div style="background:#F8FAFC; border:1px dashed #CBD5E1; border-radius:8px; padding:18px; text-align:center;">
                                <div style="font-size:11px; font-weight:700; text-transform:uppercase; color:#64748B; letter-spacing:0.5px;">Collection Site Authorization Barcode</div>
                                <div style="font-family:'Courier New', monospace; font-size:32px; font-weight:bold; letter-spacing:8px; color:#0B2545; margin:8px 0 4px;">
                                    ||| | |||| || ||| |||| | |||
                                </div>
                                <div style="font-size:14px; font-weight:700; color:#0B2545; letter-spacing:3px;">*{{ $order->order_number }}*</div>
                            </div>
                        </td>
                    </tr>

                    <!-- Donor & Panel Details -->
                    <tr>
                        <td style="padding:14px 32px 24px;">
                            <h3 style="font-size:17px; font-weight:800; color:#0B2545; margin:0 0 14px; border-bottom:1px solid #F1F5F9; padding-bottom:8px;">Donor &amp; Registration Details</h3>
                            
                            <table width="100%" cellpadding="6" cellspacing="0" style="font-size:14px;">
                                <tr>
                                    <td width="35%" style="color:#64748B; font-weight:600;">Donor Name:</td>
                                    <td style="color:#0B2545; font-weight:700;">{{ $order->donor_full_name }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#64748B; font-weight:600;">Contact Email:</td>
                                    <td style="color:#0B2545;">{{ $order->donor_email }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#64748B; font-weight:600;">Contact Phone:</td>
                                    <td style="color:#0B2545;">{{ $order->donor_phone }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#64748B; font-weight:600;">Reason for Test:</td>
                                    <td style="color:#0B2545;">{{ ucfirst($order->test_reason) }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#64748B; font-weight:600;">Preferred ZIP:</td>
                                    <td style="color:#0B2545; font-weight:700;">{{ $order->zip }}</td>
                                </tr>
                            </table>

                            <!-- Items List -->
                            <div style="margin-top:20px; background:#F8FAFC; border:1px solid #E2E8F0; border-radius:8px; padding:16px;">
                                <div style="font-size:12px; font-weight:700; text-transform:uppercase; color:#64748B; margin-bottom:8px;">Authorized Testing Panel</div>
                                @foreach($order->items as $item)
                                    <div style="display:flex; justify-content:space-between; font-size:15px; font-weight:700; color:#0B2545;">
                                        <span>{{ $item->product_name }}</span>
                                        <span style="color:#C1121F;">${{ number_format($item->price, 2) }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Instructions -->
                            <div style="margin-top:24px; padding:16px; background:#EFF6FF; border-left:4px solid #0B2545; border-radius:0 8px 8px 0;">
                                <strong style="color:#0B2545; font-size:14px; display:block; margin-bottom:6px;">Next Steps for the Donor:</strong>
                                <ol style="margin:0 0 0 18px; padding:0; font-size:13.5px; color:#334155; line-height:1.6;">
                                    <li>Print this Donor Pass or show it on your mobile device at the collection center.</li>
                                    <li>Bring a valid government-issued photo ID (Driver's License, Passport, or State ID).</li>
                                    <li>Walk into any certified Quest Diagnostics or Labcorp facility serving your area. No appointment necessary.</li>
                                    <li>There are no fees to pay at the testing center. Your testing and MRO review are 100% pre-paid.</li>
                                </ol>
                            </div>

                            <!-- Button View Pass Online -->
                            <div style="text-align:center; margin-top:28px;">
                                <a href="{{ route('checkout.confirmation', $order->donor_pass_token) }}" style="display:inline-block; background:#C1121F; color:#FFFFFF; text-decoration:none; padding:14px 28px; border-radius:6px; font-weight:700; font-size:15px;">
                                    View &amp; Print Official Pass Online &rarr;
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#F8FAFC; padding:20px 32px; border-top:1px solid #E2E8F0; text-align:center; font-size:12px; color:#64748B;">
                            <div>Certified National Specimen Collection &amp; SAMHSA Accredited Laboratory Network</div>
                            <div style="margin-top:6px;">Questions or Need Assistance? Call Toll-Free <strong>(800) 221-4291</strong> (Mon-Fri 7AM - 8PM EST)</div>
                            <div style="margin-top:6px; color:#94A3B8;">&copy; {{ date('Y') }} Certified Drug Test Centers. All Rights Reserved.</div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
