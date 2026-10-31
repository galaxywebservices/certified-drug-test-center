<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Certified Drug Test Centers</title>
</head>
<body style="margin:0; padding:0; background-color:#F1F5F9; font-family:'Helvetica Neue', Arial, sans-serif; color:#334155;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#F1F5F9; padding:40px 15px;">
        <tr>
            <td align="center">
                <table width="620" cellpadding="0" cellspacing="0" style="background:#FFFFFF; border-radius:12px; overflow:hidden; border:1px solid #E2E8F0; box-shadow:0 10px 25px rgba(11,37,69,0.08);">
                    <!-- Brand Top Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg, #0B2545 0%, #133E68 100%); padding:32px 36px; border-bottom:4px solid #C1121F;">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <div style="color:#94A3B8; font-size:11px; font-weight:800; letter-spacing:1.5px; text-transform:uppercase;">
                                            SAMHSA Accredited Laboratory Network
                                        </div>
                                        <div style="color:#FFFFFF; font-size:24px; font-weight:900; margin-top:6px; letter-spacing:-0.5px;">
                                            Certified Drug Test Centers
                                        </div>
                                        <div style="color:#E2E8F0; font-size:13px; font-weight:500; margin-top:4px;">
                                            Corporate &amp; Employer Solutions Portal
                                        </div>
                                    </td>
                                    <td align="right" valign="top">
                                        <span style="display:inline-block; background:rgba(255,255,255,0.12); color:#FFFFFF; border:1px solid rgba(255,255,255,0.25); border-radius:6px; padding:6px 12px; font-size:12px; font-weight:700;">
                                            Corporate Account
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding:36px 36px 24px;">
                            <h2 style="font-size:20px; font-weight:800; color:#0B2545; margin:0 0 12px;">
                                Welcome, {{ $account->contact_name }}!
                            </h2>
                            <p style="font-size:15px; line-height:1.6; color:#475569; margin:0 0 24px;">
                                Your corporate testing account for <strong style="color:#0B2545;">{{ $account->company_name }}</strong> has been successfully established with Certified Drug Test Centers. Your team now has 24/7 access to our nationwide screening network of over 20,000 Quest Diagnostics and Labcorp collection facilities.
                            </p>

                            <!-- Credentials Box -->
                            <div style="background:#F8FAFC; border:1.5px solid #CBD5E1; border-radius:10px; padding:22px; margin-bottom:28px;">
                                <div style="font-size:11px; font-weight:800; text-transform:uppercase; color:#64748B; letter-spacing:1px; margin-bottom:14px;">
                                    Your Corporate Access Credentials
                                </div>
                                <table width="100%" cellpadding="6" cellspacing="0" style="font-size:14px;">
                                    <tr>
                                        <td width="38%" style="color:#64748B; font-weight:600;">Account Code:</td>
                                        <td style="color:#0B2545; font-weight:800; font-family:'Courier New', monospace; font-size:16px;">
                                            {{ $accountCode }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color:#64748B; font-weight:600;">Authorized Contact:</td>
                                        <td style="color:#0B2545; font-weight:700;">{{ $account->contact_name }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#64748B; font-weight:600;">Login Email:</td>
                                        <td style="color:#0B2545; font-weight:700;">{{ $account->email }}</td>
                                    </tr>
                                    <tr>
                                        <td style="color:#64748B; font-weight:600;">Corporate PIN:</td>
                                        <td style="color:#C1121F; font-weight:800; font-family:'Courier New', monospace; font-size:16px;">
                                            {{ $accessPin }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="color:#64748B; font-weight:600;">DOT Compliance:</td>
                                        <td style="color:#0B2545; font-weight:700;">
                                            {{ $account->is_dot_regulated ? 'DOT Regulated (' . ($account->dot_agency ?? 'FMCSA') . ')' : 'Non-DOT Commercial Fleet' }}
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align:center; margin-bottom:32px;">
                                <a href="{{ route('employers.portal', ['access_token' => $account->access_token]) }}" style="display:inline-block; background:#0B2545; color:#FFFFFF; text-decoration:none; padding:15px 36px; border-radius:8px; font-weight:800; font-size:15px; box-shadow:0 4px 14px rgba(11,37,69,0.25);">
                                    Access Employer Portal Now &rarr;
                                </a>
                                <div style="font-size:12px; color:#94A3B8; margin-top:8px;">
                                    Instant secure magic link login — no manual password required
                                </div>
                            </div>

                            <!-- Key Capabilities List -->
                            <div style="border-top:1px solid #E2E8F0; padding-top:24px; margin-bottom:24px;">
                                <div style="font-size:13px; font-weight:800; color:#0B2545; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:12px;">
                                    What You Can Do in Your Corporate Portal:
                                </div>
                                <table width="100%" cellpadding="6" cellspacing="0" style="font-size:13.5px; color:#475569;">
                                    <tr>
                                        <td width="24" valign="top" style="color:#10B981; font-weight:bold;">✓</td>
                                        <td><strong>1-Click Candidate Passes:</strong> Instantly dispatch electronic scannable passes to candidate smartphones via SMS text and email.</td>
                                    </tr>
                                    <tr>
                                        <td width="24" valign="top" style="color:#10B981; font-weight:bold;">✓</td>
                                        <td><strong>Real-Time Specimen Tracking:</strong> Follow chain of custody from specimen collection through SAMHSA lab analysis and Medical Review Officer (MRO) verification.</td>
                                    </tr>
                                    <tr>
                                        <td width="24" valign="top" style="color:#10B981; font-weight:bold;">✓</td>
                                        <td><strong>Automated Random Compliance:</strong> Run quarterly randomized draws meeting DOT &amp; company compliance standards with exportable audit logs.</td>
                                    </tr>
                                    <tr>
                                        <td width="24" valign="top" style="color:#10B981; font-weight:bold;">✓</td>
                                        <td><strong>Consolidated Net-30 Invoicing:</strong> Centralized monthly itemized billing with zero upfront expense reports for remote staff.</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Dedicated Support Card -->
                            <div style="background:#EFF6FF; border-left:4px solid #0B2545; border-radius:0 8px 8px 0; padding:16px 20px;">
                                <strong style="color:#0B2545; font-size:14px; display:block; margin-bottom:4px;">Dedicated Corporate Operations &amp; Dispatch:</strong>
                                <p style="margin:0; font-size:13px; color:#334155; line-height:1.5;">
                                    Toll-Free Corporate Scheduling: <strong style="color:#0B2545;">(800) 985-4339</strong> (Mon–Fri 7AM–8PM EST)<br>
                                    Corporate Accounts Desk: <a href="mailto:corporate@certifieddrugtestcenters.com" style="color:#0B2545; font-weight:600;">corporate@certifieddrugtestcenters.com</a>
                                </p>
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#F8FAFC; border-top:1px solid #E2E8F0; padding:24px 36px; text-align:center;">
                            <div style="font-size:12px; color:#64748B; line-height:1.5;">
                                &copy; {{ date('Y') }} Certified Drug Test Centers. National Specimen Collection &amp; SAMHSA Accredited Laboratory Network.<br>
                                201 N. Park Ave., Sanford, FL 32771 | Over 20,000 Certified Collection Facilities Nationwide.
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
