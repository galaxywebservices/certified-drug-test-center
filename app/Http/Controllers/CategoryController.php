<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = $category->products()
            ->where('products.is_active', true)
            ->get();

        $allCategories = Category::where('is_active', true)
            ->orderBy('position')
            ->get();

        $displayName = $category->display_name ?: $category->name;
        $pageTitle = $category->meta_title ?: "{$displayName} - (800) 985-4339";
        if (str_contains($pageTitle, 'Walk-ins Welcome') || str_contains($pageTitle, 'Walk-in') || !str_contains($pageTitle, '800')) {
            $pageTitle = "{$displayName} - (800) 985-4339";
        }
        $metaDescription = $category->meta_description ?: "Explore certified {$displayName} options. Order online or call (800) 985-4339 for an instant donor pass at 20,000+ certified collection sites nationwide.";
        $metaDescription = preg_replace('/walk[- ]?in\s*(same-day\s*)?(drug\s*)?testing\s*at/i', 'order online or call (800) 985-4339 for an instant donor pass at', $metaDescription);
        $metaDescription = preg_replace('/walk[- ]?in\'?s?\s*welcome/i', 'call (800) 985-4339', $metaDescription);
        $canonicalUrl = $category->canonical_url ?: url('/category/' . $category->slug);
        if (str_contains($canonicalUrl, 'localhost') || str_contains($canonicalUrl, '127.0.0.1')) {
            $canonicalUrl = url('/category/' . $category->slug);
        }

        return view('categories.show', compact('category', 'products', 'allCategories', 'displayName', 'pageTitle', 'metaDescription', 'canonicalUrl'));
    }
}
