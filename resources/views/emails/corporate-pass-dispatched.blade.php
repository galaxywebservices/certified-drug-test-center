<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidate Electronic Pass Dispatched</title>
</head>
<body style="margin:0; padding:0; background-color:#F1F5F9; font-family:'Helvetica Neue', Arial, sans-serif; color:#334155;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#F1F5F9; padding:40px 15px;">
        <tr>
            <td align="center">
                <table width="620" cellpadding="0" cellspacing="0" style="background:#FFFFFF; border-radius:12px; overflow:hidden; border:1px solid #E2E8F0; box-shadow:0 10px 25px rgba(11,37,69,0.08);">
                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg, #0B2545 0%, #133E68 100%); padding:28px 36px; border-bottom:4px solid #10B981;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <div style="color:#94A3B8; font-size:11px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase;">
                                            {{ $account->company_name }}
                                        </div>
                                        <div style="color:#FFFFFF; font-size:22px; font-weight:900; margin-top:4px;">
                                            Electronic Candidate Pass Dispatched
                                        </div>
                                    </td>
                                    <td align="right" valign="top">
                                        <span style="display:inline-block; background:#10B981; color:#FFFFFF; border-radius:6px; padding:6px 12px; font-size:12px; font-weight:800; text-transform:uppercase; letter-spacing:0.5px;">
                                            Pass Sent
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px 36px 24px;">
                            <p style="font-size:15px; line-height:1.6; color:#475569; margin:0 0 24px;">
                                An official electronic scannable donor pass has been dispatched to candidate <strong style="color:#0B2545;">{{ $order->donor_first_name }} {{ $order->donor_last_name }}</strong> via SMS text and secure email.
                            </p>

                            <!-- Candidate & Pass Summary -->
                            <div style="background:#F8FAFC; border:1px solid #CBD5E1; border-radius:10px; padding:20px; margin-bottom:24px;">
                                <div style="font-size:11px; font-weight:800; text-transform:uppercase; color:#64748B; letter-spacing:1px; margin-bottom:12px;">
                                    Dispatched Candidate Details
                                </div>
                                <table width="100%" cellpadding="6" cellspacing="0" style="font-size:14px;">
                                    <tr>
                                        <td width="38%" style="color:#64748B; font-weight:600;">Candidate Name:</td>
                                        <td style="color:#0B2545; font-weight:800;">{{ $order->donor_first_name }} {{ $order->donor_last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#64748B; font-weight:600;">Candidate Email:</td>
                                        <td style="color:#0B2545;">{{ $order->donor_email }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#64748B; font-weight:600;">Candidate Mobile:</td>
                                        <td style="color:#0B2545;">{{ $order->donor_phone }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#64748B; font-weight:600;">Dept / Facility:</td>
                                        <td style="color:#0B2545;">{{ $order->candidate_department ?? 'Corporate' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#64748B; font-weight:600;">Job Title:</td>
                                        <td style="color:#0B2545;">{{ $order->candidate_job_title ?? 'Candidate' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#64748B; font-weight:600;">Reason for Testing:</td>
                                        <td style="color:#0B2545; font-weight:700;">{{ $order->test_reason }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#64748B; font-weight:600;">Authorized Panel:</td>
                                        <td style="color:#C1121F; font-weight:800;">{{ $product->name }} (${{ number_format($product->price, 2) }})</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#64748B; font-weight:600;">Order Reference:</td>
                                        <td style="color:#0B2545; font-family:'Courier New', monospace; font-weight:800;">{{ $order->order_number }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#64748B; font-weight:600;">CCF Accession #:</td>
                                        <td style="color:#0B2545; font-family:'Courier New', monospace; font-weight:800;">{{ $order->ccf_number }}</td>
                                    </tr>
                                </table>
                            </div>

                            @if($order->location)
                            <!-- Facility Box -->
                            <div style="background:#EFF6FF; border:1px solid #BFDBFE; border-radius:10px; padding:18px; margin-bottom:24px;">
                                <div style="font-size:11px; font-weight:800; text-transform:uppercase; color:#1E40AF; letter-spacing:1px; margin-bottom:8px;">
                                    Preferred Specimen Collection Facility
                                </div>
                                <div style="font-size:15px; font-weight:800; color:#0B2545;">
                                    {{ $order->location->name }} ({{ strtoupper($order->location->provider) }})
                                </div>
                                <div style="font-size:13.5px; color:#334155; margin-top:4px;">
                                    {{ $order->location->address1 }}, {{ $order->location->city }}, {{ $order->location->state }} {{ $order->location->zip }}
                                </div>
                                <div style="font-size:13px; color:#64748B; margin-top:4px;">
                                    Hours: {{ $order->location->formatted_hours }}
                                </div>
                            </div>
                            @endif

                            <!-- CTA Buttons -->
                            <div style="text-align:center; margin-bottom:24px;">
                                <a href="{{ route('employers.portal') }}" style="display:inline-block; background:#0B2545; color:#FFFFFF; text-decoration:none; padding:14px 32px; border-radius:8px; font-weight:800; font-size:14px; box-shadow:0 4px 12px rgba(11,37,69,0.2);">
                                    Track Live Status in Employer Portal &rarr;
                                </a>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#F8FAFC; border-top:1px solid #E2E8F0; padding:20px 36px; text-align:center;">
                            <div style="font-size:12px; color:#64748B;">
                                &copy; {{ date('Y') }} Certified Drug Test Centers. Corporate Operations Desk: (800) 985-4339
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
