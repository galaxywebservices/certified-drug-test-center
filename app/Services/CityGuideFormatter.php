<?php

namespace App\Services;

class CityGuideFormatter
{
    /**
     * Format raw legacy city guide HTML into a modern, professional, high-trust presentation.
     */
    public static function format(?string $html, string $cityName, string $stateAbbr): string
    {
        if (empty($html)) {
            return '';
        }

        // Clean company name references
        $clean = str_replace(
            ['Accredited Drug Testing', 'accrediteddrugtesting.com', 'ADT'],
            ['Certified Drug Test Center', 'certifieddrugtestcenter.com', 'CDTC'],
            $html
        );

        // Extract Step 1, 2, 3 if present
        $hasSteps = preg_match(
            "/Step 1:(.*?)Step 2:(.*?)Step 3:(.*?)(?=<p><strong>|<h[2-4]>|$)/is",
            $clean,
            $stepMatches
        );

        $stepCardsHtml = '';
        if ($hasSteps) {
            $step1 = trim(strip_tags($stepMatches[1]));
            $step2 = trim(strip_tags($stepMatches[2]));
            $step3 = trim(strip_tags($stepMatches[3]));

            // Format phone numbers
            $step1Formatted = preg_replace('/(\(?\d{3}\)?[-.\s]?\d{3}[-.\s]?\d{4})/', '<a href="tel:18002214291" class="guide-phone-inline">$1</a>', $step1);

            $stepCardsHtml = <<<HTML
            <div class="guide-steps-grid">
                <div class="guide-step-card">
                    <div class="guide-step-header">
                        <span class="guide-step-num">01</span>
                        <span class="guide-step-badge">Fast &amp; Online</span>
                    </div>
                    <h4 class="guide-step-title">Order Test Online or By Phone</h4>
                    <p class="guide-step-text">{$step1Formatted}</p>
                </div>
                <div class="guide-step-card">
                    <div class="guide-step-header">
                        <span class="guide-step-num">02</span>
                        <span class="guide-step-badge">Auto Location</span>
                    </div>
                    <h4 class="guide-step-title">Donor Registration &amp; Site Match</h4>
                    <p class="guide-step-text">{$step2}</p>
                </div>
                <div class="guide-step-card">
                    <div class="guide-step-header">
                        <span class="guide-step-num">03</span>
                        <span class="guide-step-badge">Walk In Today</span>
                    </div>
                    <h4 class="guide-step-title">Instant Donor Pass Issued</h4>
                    <p class="guide-step-text">{$step3}</p>
                </div>
            </div>
HTML;

            // Remove the raw steps block from the content so we do not duplicate it
            $clean = preg_replace(
                "/<p>Step 1:.*?<p>Step 3:.*?<\/p>/is",
                $stepCardsHtml,
                $clean
            );
        }

        // Format phone numbers as links
        $clean = preg_replace(
            '/(\(?800\)?[-.\s]?221[-.\s]?4291)/',
            '<a href="tel:18002214291" class="guide-phone-link"><strong>$1</strong></a>',
            $clean
        );

        // Transform <p><strong>Headings into structured <h3> and <h4> with icons
        $clean = preg_replace_callback(
            "/<p><strong>(.*?)<\/strong><\/p>/is",
            function ($matches) use ($cityName, $stateAbbr) {
                $title = trim(strip_tags($matches[1]));

                // Ignore if it's too short or just a label
                if (strlen($title) < 4) {
                    return "<p><strong>{$title}</strong></p>";
                }

                // Determine category & style based on title keywords
                $lower = strtolower($title);

                if (str_contains($lower, 'how to arrange') || str_contains($lower, 'how to schedule')) {
                    return '<div class="guide-section-header">
                        <span class="guide-section-pill">Step-by-Step Walkthrough</span>
                        <h3 class="guide-section-title">' . htmlspecialchars($title) . '</h3>
                    </div>';
                }

                if (str_contains($lower, 'urine or hair') || str_contains($lower, 'typical urine')) {
                    return '<div class="guide-section-header" style="margin-top:32px;">
                        <span class="guide-section-pill guide-pill-blue">Testing Methodology</span>
                        <h3 class="guide-section-title">' . htmlspecialchars($title) . '</h3>
                    </div>';
                }

                if (str_contains($lower, 'court') || str_contains($lower, 'probation') || str_contains($lower, 'child custody')) {
                    return '<div class="guide-card guide-card-legal" style="margin-top:32px;">
                        <div class="guide-card-header">
                            <span class="guide-badge-legal">⚖️ Court Mandated &amp; Legal Compliance</span>
                            <h3 class="guide-section-title" style="margin-top:6px;">' . htmlspecialchars($title) . '</h3>
                        </div>';
                }

                if (str_contains($lower, 'dot drug and alcohol') || str_contains($lower, 'additional dot services')) {
                    return '<div class="guide-section-header" style="margin-top:32px;">
                        <span class="guide-section-pill guide-pill-navy">DOT Transportation Compliance</span>
                        <h3 class="guide-section-title">' . htmlspecialchars($title) . '</h3>
                    </div>';
                }

                if (str_contains($lower, 'workplace drug testing') || str_contains($lower, 'benefits of maintaining')) {
                    return '<div class="guide-section-header" style="margin-top:32px;">
                        <span class="guide-section-pill guide-pill-green">Employer Solutions</span>
                        <h3 class="guide-section-title">' . htmlspecialchars($title) . '</h3>
                    </div>';
                }

                if (str_contains($lower, 'on-site') || str_contains($lower, 'mobile')) {
                    return '<div class="guide-card guide-card-mobile" style="margin-top:32px;">
                        <span class="guide-badge-mobile">🚐 Mobile Testing Team</span>
                        <h3 class="guide-section-title" style="margin-top:6px;">' . htmlspecialchars($title) . '</h3>';
                }

                if (str_contains($lower, 'why choose certified drug test center')) {
                    return '<div class="guide-card guide-card-trust" style="margin-top:36px;">
                        <div class="guide-card-header">
                            <span class="guide-badge-trust">🛡️ Verified Accredited Network</span>
                            <h3 class="guide-section-title" style="margin-top:6px; color:#0B2545;">' . htmlspecialchars($title) . '</h3>
                        </div>';
                }

                // Default clean semantic heading
                return '<h4 class="guide-subheading">' . htmlspecialchars($title) . '</h4>';
            },
            $clean
        );

        // Close any opened callout cards before next sections
        // Close court card, mobile card, trust card properly
        $clean = self::balanceCardDivs($clean);

        // Enhance list items (ul) into modern checkmark grids
        $clean = preg_replace(
            '/<ul>(.*?)<\/ul>/is',
            '<div class="guide-feature-list-wrap"><ul class="guide-feature-list">$1</ul></div>',
            $clean
        );

        // Prettify list items
        $clean = preg_replace(
            '/<li>(.*?)<\/li>/is',
            '<li class="guide-feature-item"><span class="guide-check-icon">✓</span><span>$1</span></li>',
            $clean
        );

        return $clean;
    }

    /**
     * Closes unclosed card containers before new sections or end of content
     */
    protected static function balanceCardDivs(string $content): string
    {
        // Split content by major sections and ensure proper div closing
        $parts = explode('<div class="guide-card', $content);
        if (count($parts) <= 1) {
            return $content;
        }

        $result = $parts[0];
        for ($i = 1; $i < count($parts); $i++) {
            $part = $parts[$i];
            // If another guide-section-header or guide-card follows, close this card before it
            if (str_contains($part, '<div class="guide-section-header"')) {
                $sub = explode('<div class="guide-section-header"', $part, 2);
                $result .= '<div class="guide-card' . $sub[0] . '</div><div class="guide-section-header"' . $sub[1];
            } else {
                $result .= '<div class="guide-card' . $part . '</div>';
            }
        }

        return $result;
    }
}
