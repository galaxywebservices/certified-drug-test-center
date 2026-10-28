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
        $pageTitle = $category->meta_title ?: "{$displayName} | Certified Drug Test Center";
        $metaDescription = $category->meta_description ?: "Explore accredited {$displayName} options. Walk-in same-day drug testing at certified collection sites nationwide.";
        $canonicalUrl = $category->canonical_url ?: url('/category/' . $category->slug);

        return view('categories.show', compact('category', 'products', 'allCategories', 'displayName', 'pageTitle', 'metaDescription', 'canonicalUrl'));
    }
}
