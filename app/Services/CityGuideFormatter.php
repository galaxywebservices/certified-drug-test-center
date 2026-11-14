<?php

namespace App\Services;

class CityGuideFormatter
{
    /**
     * Format raw legacy city guide HTML into a modern, professional, high-trust presentation.
     */
    public static function format(?string $html, string $cityName, string $stateAbbr): string
    {
        if (empty(trim($html))) {
            return '';
        }

        // Clean legacy company names & ensure plural brand name
        $content = str_replace(
            ['Accredited Drug Testing', 'accrediteddrugtesting.com', 'ADT', 'Certified Drug Test Center offers', 'Certified Drug Test Center provides', 'Certified Drug Test Center is', 'Certified Drug Test Center has', 'Certified Drug Test Center'],
            ['Certified Drug Test Centers', 'certifieddrugtestingcenters.com', 'CDTC', 'Certified Drug Test Centers offer', 'Certified Drug Test Centers provide', 'Certified Drug Test Centers are', 'Certified Drug Test Centers have', 'Certified Drug Test Centers'],
            $html
        );
        $content = str_replace('Certified Drug Test Centerss', 'Certified Drug Test Centers', $content);

        // Fix broken # links in employer sections
        $content = str_replace(
            ['<a href="#">Open your account today</a>', '<a href="#">', 'href="#"'],
            ['<a href="' . url('/employers') . '">Open your account today</a>', '<a href="' . url('/employers') . '">', 'href="' . url('/employers') . '"'],
            $content
        );

        // Split into sections by <p><strong>
        $sections = explode('<p><strong>', $content);
        $output = '';

        foreach ($sections as $i => $sec) {
            $sec = trim($sec);
            if (empty($sec)) {
                continue;
            }

            // If first piece has content before the first <p><strong>
            if ($i === 0) {
                $output .= '<div class="guide-section-body">' . $sec . '</div>';
                continue;
            }

            $parts = explode('</strong></p>', $sec, 2);
            $heading = trim($parts[0]);
            $heading = str_replace(['Certified Drug Test Center', 'Certified Drug Test Centerss'], ['Certified Drug Test Centers', 'Certified Drug Test Centers'], $heading);
            $body = isset($parts[1]) ? trim($parts[1]) : '';

            // Clean any trailing telephone numbers in body into clickable links (safely avoiding existing tags)
            $body = preg_replace(
                '/(?<!tel:|tel:1|">)(\(?800\)?[-.\s]?(?:985|221)[-.\s]?(?:4339|4291))/',
                '<a href="tel:18009854339" class="guide-phone-inline">(800)-985-4339</a>',
                $body
            );

            // Format feature bullet lists with modern checkmarks
            $body = preg_replace(
                '/<ul>(.*?)<\/ul>/is',
                '<div class="guide-feature-list-wrap"><ul class="guide-feature-list">$1</ul></div>',
                $body
            );
            $body = preg_replace(
                '/<li>(.*?)<\/li>/is',
                '<li class="guide-feature-item"><span class="guide-check-icon">✓</span><span>$1</span></li>',
                $body
            );

            $lower = strtolower($heading);

            // 1. Step-by-Step Scheduling Section (3-Step Cards Grid)
            if (str_contains($lower, 'arrange') || str_contains($lower, 'arranging') || str_contains($lower, 'schedule') || str_contains($lower, 'scheduling') || str_contains($lower, 'steps to')) {
                $output .= '<div class="guide-section-header">
                    <span class="guide-section-pill">STEP-BY-STEP WALKTHROUGH</span>
                    <h3 class="guide-section-title">' . htmlspecialchars($heading) . '</h3>
                </div>';

                $output .= '<div class="guide-steps-grid">
                    <div class="guide-step-card">
                        <div class="guide-step-header">
                            <span class="guide-step-num">Step 1</span>
                            <span class="guide-step-badge">Fast &amp; Online</span>
                        </div>
                        <h4 class="guide-step-title">Order Test Online or By Phone</h4>
                        <p class="guide-step-text">Choose and pay for your test online or dial <a href="tel:18009854339" class="guide-phone-inline">(800)-985-4339</a> to reach our scheduling center. Upfront payment is required as collection sites do not accept direct payments.</p>
                    </div>
                    <div class="guide-step-card">
                        <div class="guide-step-header">
                            <span class="guide-step-num">Step 2</span>
                            <span class="guide-step-badge">Complete Registration</span>
                        </div>
                        <h4 class="guide-step-title">Donor Registration &amp; Site Match</h4>
                        <p class="guide-step-text">Complete the Donor Registration section and specify your destination email for confidential reporting. Your zip code automatically assigns the closest certified facility.</p>
                    </div>
                    <div class="guide-step-card">
                        <div class="guide-step-header">
                            <span class="guide-step-num">Step 3</span>
                            <span class="guide-step-badge">Electronic Donor Pass</span>
                        </div>
                        <h4 class="guide-step-title">Instant Donor Pass Issued</h4>
                        <p class="guide-step-text">Receive your official electronic donor authorization pass with barcode and facility hours via email or text immediately. Bring your pass and a photo ID to the certified testing center. Negative results are typically available within 24–48 hours.</p>
                    </div>
                </div>';
                continue;
            }

            // 1.1 Unique Anti-Duplicate Content Variations for Diagnostic FAQs
            if (str_contains($lower, 'passive smoke') || str_contains($lower, 'false positive')) {
                $heading = "Does Secondhand Smoke Inhalation Cause Marijuana False Positives?";
                $body = "<p>Standard laboratory cutoff concentrations established by federal SAMHSA and HHS regulations are calibrated to prevent passive, casual secondhand cannabis exposure from triggering a non-negative result. Initial immunoassay screening thresholds (50 ng/mL) and confirmatory GC/MS or LC/MS testing (15 ng/mL) require active consumption. All laboratory specimens also undergo specimen validity testing (monitoring creatinine levels, specific gravity, and pH) to ensure sample integrity.</p>";
            } elseif (str_contains($lower, 'detection') || str_contains($lower, 'remain detectable')) {
                $heading = "Drug Detection Windows by Testing Methodology in {$cityName}, {$stateAbbr}";
                $body = "<p>Detection windows depend on the biological specimen matrix, drug class, metabolism, and frequency of exposure:</p>
                <div class=\"guide-feature-list-wrap\"><ul class=\"guide-feature-list\">
                    <li class=\"guide-feature-item\"><span class=\"guide-check-icon\">✓</span><span><strong>Urine Drug Testing:</strong> 1 to 5 days for most substances (up to 30 days for habitual cannabis use).</span></li>
                    <li class=\"guide-feature-item\"><span class=\"guide-check-icon\">✓</span><span><strong>Hair Follicle Testing:</strong> Up to 90 days of substance history using standard 1.5-inch specimens.</span></li>
                    <li class=\"guide-feature-item\"><span class=\"guide-check-icon\">✓</span><span><strong>EtG Alcohol Urine Testing:</strong> Up to 80 hours following alcohol consumption.</span></li>
                    <li class=\"guide-feature-item\"><span class=\"guide-check-icon\">✓</span><span><strong>Breath Alcohol Testing:</strong> Immediate blood alcohol concentration (BAC) measurement.</span></li>
                </ul></div>";
            } elseif (str_contains($lower, 'options for drug testing methods') || str_contains($lower, 'common drug tests')) {
                $heading = "Diagnostic Drug Testing Panels in {$cityName}, {$stateAbbr}";
                $body = "<p>Certified Drug Test Centers offers nationwide lab screening solutions tailored to corporate employers, DOT regulations, legal proceedings, and personal requirements. Standard 5-panel and 10-panel urine tests provide rapid turnaround within 24 to 48 hours, while comprehensive 12-panel, hair follicle, and specialty EtG screens accommodate extended forensic and safety-sensitive testing protocols across {$cityName}.</p>";
            }

            // Guard against empty bodies causing blank cards/sections
            if (empty(trim(strip_tags($body)))) {
                continue;
            }

            // 2. Court & Legal Mandated Testing Card
            if (str_contains($lower, 'court') || str_contains($lower, 'probation') || str_contains($lower, 'child custody')) {
                $output .= '<div class="guide-card guide-card-legal">
                    <div class="guide-card-header">
                        <span class="guide-badge-legal">⚖️ Court Mandated &amp; Legal Compliance</span>
                        <h3 class="guide-card-title">' . htmlspecialchars($heading) . '</h3>
                    </div>
                    <div class="guide-card-body">' . $body . '</div>
                </div>';
                continue;
            }

            // 3. Mobile / On-Site Dispatch Card
            if (str_contains($lower, 'on-site') || str_contains($lower, 'mobile')) {
                $cleanedBody = preg_replace('/\b10\s+employees\b/i', '20 employees', $body);
                $cleanedBody = preg_replace('/\bat\s+least\s+10\s+employees\b/i', 'at least 20 employees', $cleanedBody);
                $output .= '<div class="guide-card guide-card-mobile">
                    <div class="guide-card-header">
                        <span class="guide-badge-mobile">🚐 Mobile On-Site Testing Dispatch</span>
                        <h3 class="guide-card-title">' . htmlspecialchars($heading) . '</h3>
                    </div>
                    <div class="guide-card-body">' . $cleanedBody . '</div>
                </div>';
                continue;
            }

            // 4. Accredited Trust Guarantee Card
            if (str_contains($lower, 'why choose') || str_contains($lower, 'why opt') || str_contains($lower, 'why select')) {
                $output .= '<div class="guide-card guide-card-trust">
                    <div class="guide-card-header">
                        <span class="guide-badge-trust">🛡️ Verified Accredited Network</span>
                        <h3 class="guide-card-title">' . htmlspecialchars($heading) . '</h3>
                    </div>
                    <div class="guide-card-body">' . $body . '</div>
                </div>';
                continue;
            }

            // 5. DOT Compliance Section
            if (str_contains($lower, 'dot drug') || str_contains($lower, 'dot services') || str_contains($lower, 'dot transportation')) {
                $output .= '<div class="guide-section-header">
                    <span class="guide-section-pill guide-pill-navy">DOT Transportation Compliance</span>
                    <h3 class="guide-section-title">' . htmlspecialchars($heading) . '</h3>
                </div>
                <div class="guide-section-body">' . $body . '</div>';
                continue;
            }

            // 6. Workplace Drug Testing Section
            if (str_contains($lower, 'workplace') || str_contains($lower, 'benefits of maintaining') || str_contains($lower, 'drug-free') || str_contains($lower, 'employer')) {
                $output .= '<div class="guide-section-header">
                    <span class="guide-section-pill guide-pill-green">Employer Solutions</span>
                    <h3 class="guide-section-title">' . htmlspecialchars($heading) . '</h3>
                </div>
                <div class="guide-section-body">' . $body . '</div>';
                continue;
            }

            // 7. Testing Methodology (Urine vs Hair, Panels)
            if (str_contains($lower, 'urine') || str_contains($lower, 'hair') || str_contains($lower, 'panel') || str_contains($lower, 'understanding drug')) {
                $output .= '<div class="guide-section-header">
                    <span class="guide-section-pill guide-pill-blue">Testing Methodology</span>
                    <h3 class="guide-section-title">' . htmlspecialchars($heading) . '</h3>
                </div>
                <div class="guide-section-body">' . $body . '</div>';
                continue;
            }

            // Default Clean Subheading & Body
            $output .= '<h4 class="guide-subheading">' . htmlspecialchars($heading) . '</h4>
            <div class="guide-section-body">' . $body . '</div>';
        }

        return $output;
    }
}
