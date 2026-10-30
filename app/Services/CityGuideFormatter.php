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

        // Clean legacy company names
        $content = str_replace(
            ['Accredited Drug Testing', 'accrediteddrugtesting.com', 'ADT'],
            ['Certified Drug Test Center', 'certifieddrugtestcenter.com', 'CDTC'],
            $html
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
                            <span class="guide-step-num">01</span>
                            <span class="guide-step-badge">Fast &amp; Online</span>
                        </div>
                        <h4 class="guide-step-title">Order Test Online or By Phone</h4>
                        <p class="guide-step-text">Choose and pay for your test online or dial <a href="tel:18009854339" class="guide-phone-inline">(800)-985-4339</a> to reach our scheduling center. Upfront payment is required as collection sites do not accept direct payments.</p>
                    </div>
                    <div class="guide-step-card">
                        <div class="guide-step-header">
                            <span class="guide-step-num">02</span>
                            <span class="guide-step-badge">Auto Location</span>
                        </div>
                        <h4 class="guide-step-title">Donor Registration &amp; Site Match</h4>
                        <p class="guide-step-text">Complete the Donor Registration section and specify your destination email for confidential reporting. Your zip code automatically assigns the closest certified facility.</p>
                    </div>
                    <div class="guide-step-card">
                        <div class="guide-step-header">
                            <span class="guide-step-num">03</span>
                            <span class="guide-step-badge">Walk In Today</span>
                        </div>
                        <h4 class="guide-step-title">Instant Donor Pass Issued</h4>
                        <p class="guide-step-text">Receive your official donor authorization pass with barcode and facility hours via email immediately. Bring this pass with a photo ID to the collection site — no appointment necessary!</p>
                    </div>
                </div>';
                continue;
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
                $output .= '<div class="guide-card guide-card-mobile">
                    <div class="guide-card-header">
                        <span class="guide-badge-mobile">🚐 Mobile On-Site Testing Dispatch</span>
                        <h3 class="guide-card-title">' . htmlspecialchars($heading) . '</h3>
                    </div>
                    <div class="guide-card-body">' . $body . '</div>
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
