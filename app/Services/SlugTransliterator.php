<?php

namespace App\Services;

class SlugTransliterator
{
    /**
     * Transliterate a string into a strict ASCII SEO-friendly slug.
     *
     * Rules:
     * - Strip diacritics and macrons (e.g., 'Hālawa' -> 'halawa')
     * - Remove apostrophes and quotes without hyphenation (e.g., "O'Fallon" -> "ofallon", "Lee's Summit" -> "lees-summit")
     * - Convert punctuation (&, /, +, etc.) to dashes
     * - Retain only lowercase alphanumeric characters [a-z0-9-]
     * - Collapse multiple hyphens into a single hyphen
     * - Trim leading and trailing hyphens
     */
    public static function slugify(?string $text): string
    {
        if (empty($text)) {
            return '';
        }

        // 1. Remove curly/straight apostrophes and single/double quotes without adding dashes
        $text = preg_replace("/['’‘\"“”`´]/u", '', $text);

        // 2. Transliterate diacritics and macrons (e.g. Hālawa -> Halawa, naïve -> naive)
        if (function_exists('transliterator_transliterate')) {
            $transliterated = transliterator_transliterate('Any-Latin; Latin-ASCII; [\u0080-\uffff] remove;', $text);
            if ($transliterated !== false && !empty($transliterated)) {
                $text = $transliterated;
            }
        } else {
            $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text) ?: $text;
        }

        // 3. Lowercase
        $text = mb_strtolower($text, 'UTF-8');

        // 4. Replace ampersands, slashes, pluses and non-alphanumeric chars with a dash
        $text = preg_replace('/[^a-z0-9]+/i', '-', $text);

        // 5. Deduplicate hyphens and trim from edges
        $text = preg_replace('/-+/', '-', $text);
        $text = trim($text, '-');

        return $text;
    }
}
