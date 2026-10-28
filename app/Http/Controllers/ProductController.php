<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::with('categories')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $category = $product->categories->first() ?? Category::first();

        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('is_active', true)
            ->when($category, function ($query) use ($category) {
                return $query->whereHas('categories', function ($q) use ($category) {
                    $q->where('categories.id', $category->id);
                });
            })
            ->limit(4)
            ->get();

        $pageTitle = $product->meta_title ?: "{$product->name} | Certified Drug Test Center";
        $metaDescription = $product->meta_description ?: "Order {$product->name} online. Walk in today at over 20,000 certified collection sites nationwide. Fast, confidential, and legally defensible.";
        $canonicalUrl = $product->canonical_url ?: url('/product/' . $product->slug);

        return view('products.show', compact('product', 'category', 'relatedProducts', 'pageTitle', 'metaDescription', 'canonicalUrl'));
    }
}
