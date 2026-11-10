<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ChainController;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminChainController extends Controller
{
    /**
     * Display the National Chain Page Content Editor form
     */
    public function editNational()
    {
        $chainSettings = ChainController::getNationalChainSettings();
        $faqs = $chainSettings['faqs'] ?? [];

        return view('admin.chains.national', compact('chainSettings', 'faqs'));
    }

    /**
     * Update the National Chain Page content in settings
     */
    public function updateNational(Request $request)
    {
        $validated = $request->validate([
            // SEO Meta
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:1000',
            'meta_keywords' => 'nullable|string|max:1000',

            // Hero Section
            'hero_eyebrow' => 'nullable|string|max:255',
            'hero_title' => 'required|string|max:255',
            'hero_lead' => 'required|string',
            'hero_checks' => 'nullable|array',
            'hero_checks.*' => 'nullable|string|max:255',

            // Quick Answer & Facts
            'quick_answer_title' => 'nullable|string|max:255',
            'quick_answer_text' => 'nullable|string',
            'fact_sites' => 'nullable|string|max:50',
            'fact_sites_label' => 'nullable|string|max:100',
            'fact_states' => 'nullable|string|max:50',
            'fact_states_label' => 'nullable|string|max:100',
            'fact_results' => 'nullable|string|max:50',
            'fact_results_label' => 'nullable|string|max:100',
            'fact_price' => 'nullable|string|max:50',
            'fact_price_label' => 'nullable|string|max:100',

            // National Directory Heading
            'directory_eyebrow' => 'nullable|string|max:255',
            'directory_title' => 'nullable|string|max:255',
            'directory_lead' => 'nullable|string',

            // Employer & On-Site Mobile Section
            'onsite_eyebrow' => 'nullable|string|max:255',
            'onsite_title' => 'nullable|string|max:255',
            'onsite_lead' => 'nullable|string',
            'onsite_checks' => 'nullable|array',
            'onsite_checks.*' => 'nullable|string|max:255',

            // FAQs
            'faqs' => 'nullable|array',
            'faqs.*.question' => 'nullable|string|max:500',
            'faqs.*.answer' => 'nullable|string',
        ]);

        // Process scalar fields
        $fields = [
            'meta_title', 'meta_description', 'meta_keywords',
            'hero_eyebrow', 'hero_title', 'hero_lead',
            'quick_answer_title', 'quick_answer_text',
            'fact_sites', 'fact_sites_label',
            'fact_states', 'fact_states_label',
            'fact_results', 'fact_results_label',
            'fact_price', 'fact_price_label',
            'directory_eyebrow', 'directory_title', 'directory_lead',
            'onsite_eyebrow', 'onsite_title', 'onsite_lead',
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::set('chain_national_' . $field, $request->input($field));
            }
        }

        // Process array fields
        if ($request->has('hero_checks')) {
            $checks = array_values(array_filter($request->input('hero_checks', []), fn($c) => !empty(trim($c))));
            Setting::set('chain_national_hero_checks', json_encode($checks));
        }

        if ($request->has('onsite_checks')) {
            $checks = array_values(array_filter($request->input('onsite_checks', []), fn($c) => !empty(trim($c))));
            Setting::set('chain_national_onsite_checks', json_encode($checks));
        }

        if ($request->has('faqs')) {
            $cleanedFaqs = [];
            foreach ($request->input('faqs', []) as $faq) {
                if (!empty(trim($faq['question'] ?? '')) && !empty(trim($faq['answer'] ?? ''))) {
                    $cleanedFaqs[] = [
                        'question' => trim($faq['question']),
                        'answer' => trim($faq['answer']),
                    ];
                }
            }
            Setting::set('chain_national_faqs', json_encode($cleanedFaqs));
        }

        return redirect()->route('admin.chains.national')->with('success', 'National Chain page content updated successfully.');
    }
}

