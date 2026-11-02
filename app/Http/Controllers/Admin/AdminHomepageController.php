<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminHomepageController extends Controller
{
    /**
     * Display the Homepage Content Editor form
     */
    public function edit()
    {
        $homeSettings = HomeController::getHomepageSettings();

        // Load FAQs: either stored from settings or default from HomeController
        $storedFaqs = Setting::get('homepage_faqs');
        if (!empty($storedFaqs)) {
            $faqs = is_string($storedFaqs) ? json_decode($storedFaqs, true) : $storedFaqs;
        } else {
            $homeData = (new HomeController)->getSharedData();
            $faqs = $homeData['faqs'] ?? [];
        }

        return view('admin.homepage.edit', compact('homeSettings', 'faqs'));
    }

    /**
     * Update the homepage contents in settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            // SEO Meta
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:500',

            // Hero Section
            'hero_badge' => 'nullable|string|max:255',
            'hero_title' => 'required|string',
            'hero_subtitle' => 'required|string',
            'hero_bullets' => 'nullable|array',
            'hero_bullets.*' => 'nullable|string|max:255',

            // Estimator Box
            'estimator_title' => 'nullable|string|max:255',
            'estimator_subtitle' => 'nullable|string|max:255',
            'estimator_button' => 'nullable|string|max:255',

            // Substance Tool
            'substance_eyebrow' => 'nullable|string|max:255',
            'substance_title' => 'nullable|string|max:255',
            'substance_subtitle' => 'nullable|string|max:500',

            // 3-Step Process
            'timeline_eyebrow' => 'nullable|string|max:255',
            'timeline_title' => 'nullable|string|max:255',
            'timeline_subtitle' => 'nullable|string|max:500',
            'step1_title' => 'nullable|string|max:255',
            'step1_desc' => 'nullable|string|max:500',
            'step2_title' => 'nullable|string|max:255',
            'step2_desc' => 'nullable|string|max:500',
            'step3_title' => 'nullable|string|max:255',
            'step3_desc' => 'nullable|string|max:500',

            // Catalog Section Headings
            'catalog_eyebrow' => 'nullable|string|max:255',
            'catalog_title' => 'nullable|string|max:255',
            'catalog_subtitle' => 'nullable|string|max:500',

            // Comparison Matrix Headings
            'matrix_eyebrow' => 'nullable|string|max:255',
            'matrix_title' => 'nullable|string|max:255',
            'matrix_subtitle' => 'nullable|string|max:500',

            // State Directory Headings
            'locations_eyebrow' => 'nullable|string|max:255',
            'locations_title' => 'nullable|string|max:255',
            'locations_subtitle' => 'nullable|string|max:500',

            // FAQ Headings & Items
            'faq_eyebrow' => 'nullable|string|max:255',
            'faq_title' => 'nullable|string|max:255',
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'nullable|string|max:300',
            'faqs.*.answer' => 'nullable|string',
        ]);

        // Process scalar settings
        $fields = [
            'meta_title', 'meta_description',
            'hero_badge', 'hero_title', 'hero_subtitle',
            'estimator_title', 'estimator_subtitle', 'estimator_button',
            'substance_eyebrow', 'substance_title', 'substance_subtitle',
            'timeline_eyebrow', 'timeline_title', 'timeline_subtitle',
            'step1_title', 'step1_desc',
            'step2_title', 'step2_desc',
            'step3_title', 'step3_desc',
            'catalog_eyebrow', 'catalog_title', 'catalog_subtitle',
            'matrix_eyebrow', 'matrix_title', 'matrix_subtitle',
            'locations_eyebrow', 'locations_title', 'locations_subtitle',
            'faq_eyebrow', 'faq_title',
        ];

        foreach ($fields as $field) {
            Setting::set('homepage_' . $field, $validated[$field] ?? '', 'homepage');
        }

        // Process Hero Bullets
        $bullets = [];
        if (!empty($validated['hero_bullets'])) {
            foreach ($validated['hero_bullets'] as $b) {
                $trimmed = trim($b ?? '');
                if ($trimmed !== '') {
                    $bullets[] = $trimmed;
                }
            }
        }
        Setting::set('homepage_hero_bullets', json_encode(array_values($bullets)), 'homepage');

        // Process FAQs
        $cleanFaqs = [];
        if (!empty($validated['faqs'])) {
            foreach ($validated['faqs'] as $faq) {
                $q = trim($faq['question'] ?? '');
                $a = trim($faq['answer'] ?? '');
                if ($q !== '' && $a !== '') {
                    $cleanFaqs[] = [
                        'question' => $q,
                        'answer' => $a,
                    ];
                }
            }
        }
        Setting::set('homepage_faqs', json_encode(array_values($cleanFaqs)), 'homepage');

        return redirect()->route('admin.homepage.edit')
            ->with('success', 'HomePage content updated successfully! Changes are live immediately on the homepage.');
    }
}
