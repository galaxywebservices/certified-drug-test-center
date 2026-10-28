<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class TestFinderController extends Controller
{
    /**
     * Display the Guided Drug Test Recommender Wizard.
     */
    public function index()
    {
        $products = Product::where('is_active', true)
            ->whereIn('slug', [
                '5-panel-nondot',
                '5-panel-exp-opiates',
                '10-panel',
                '10-panel-exp-opiates',
                '12-panel-comprehensive',
                '5-panel-dot',
                'dot-breath-alcohol',
                '5-panel-hair',
                '10-panel-hair',
                'etg-alcohol',
            ])
            ->get()
            ->keyBy('slug');

        $faqs = [
            [
                'question' => 'How does the Guided Test Finder match the right drug test?',
                'answer' => 'Our interactive recommendation engine analyzes your intended test purpose (employment, DOT compliance, legal/court, or personal), your required detection window (recent 1–3 days vs historical 90 days), and specific target substances (standard vs prescription opioids or alcohol) to suggest the exact, most cost-effective certified panel.',
            ],
            [
                'question' => 'Will my recommended test be legally defensible and court-admissible?',
                'answer' => 'Yes. All recommended tests include complete federal Chain of Custody (CoC), SAMHSA-certified laboratory processing (Quest Diagnostics or Labcorp), and review by a licensed Medical Review Officer (MRO).',
            ],
            [
                'question' => 'Can I walk in immediately after selecting and ordering my test?',
                'answer' => 'Yes. Upon completing your registration, your Electronic Donor Pass is generated instantly with an authorization barcode and directions to the nearest certified collection site. No appointment is needed; walk-ins are welcomed during normal facility hours.',
            ],
        ];

        return view('test-finder.index', compact('products', 'faqs'));
    }
}
