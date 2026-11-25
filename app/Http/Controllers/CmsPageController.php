<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CmsPageController extends Controller
{
    public function show(string $slug)
    {
        $cleanSlug = trim($slug, '/');

        $page = Page::where('slug', $cleanSlug)
            ->where('is_published', true)
            ->first();

        if (!$page) {
            $page = Page::whereRaw('LOWER(slug) = ?', [strtolower($cleanSlug)])
                ->where('is_published', true)
                ->first();
        }

        if (!$page) {
            abort(404);
        }

        $pageTitle = $page->meta_title ?: "{$page->title} - (800) 985-4339";
        if (str_contains($pageTitle, 'Walk-ins Welcome') || str_contains($pageTitle, 'Walk-in') || !str_contains($pageTitle, '800')) {
            $cleaned = preg_replace('/\|\s*Walk-ins?\s*Welcome/i', '', $pageTitle);
            $cleaned = preg_replace('/\s*[-|]\s*Certified Drug Test Centers?$/i', '', $cleaned);
            $pageTitle = rtrim($cleaned) . ' - (800) 985-4339';
        }
        $metaDescription = strip_tags($page->meta_description ?: "Certified drug testing services for {$page->title}. Order online or call (800) 985-4339 for an instant donor pass.");
        $metaDescription = preg_replace('/walk[- ]?in\'?s?\s*welcome/i', 'same-day testing, call (800) 985-4339', $metaDescription);
        $canonicalUrl = $page->canonical_url ?: url('/' . $page->slug);
        if (str_contains($canonicalUrl, 'localhost') || str_contains($canonicalUrl, '127.0.0.1')) {
            $canonicalUrl = url('/' . $page->slug);
        }

        // Sidebar categories and popular tests
        $popularTests = Product::where('is_popular', true)
            ->where('is_active', true)
            ->where('slug', '!=', 'body-hair-collection')
            ->where('name', 'NOT LIKE', '%Body Hair%')
            ->orderByRaw("CASE WHEN slug = '5-panel-hair-follicle' THEN 0 ELSE 1 END")
            ->limit(5)
            ->get();
        $categories = Category::where('is_active', true)->orderBy('position')->limit(8)->get();

        return view('pages.show', compact('page', 'pageTitle', 'metaDescription', 'canonicalUrl', 'popularTests', 'categories'));
    }
}
