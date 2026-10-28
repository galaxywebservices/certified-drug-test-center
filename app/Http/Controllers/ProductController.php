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

    public function search(Request $request)
    {
        $q = trim($request->input('q', ''));
        if (strlen($q) < 2) {
            return response()->json(['results' => []]);
        }

        $normalizedQ = str_replace(['-', '_'], ' ', $q);
        $words = array_filter(explode(' ', $normalizedQ));

        $products = Product::where('is_active', true)
            ->where(function ($query) use ($q, $normalizedQ, $words) {
                $query->where('name', 'LIKE', "%{$q}%")
                      ->orWhere('name', 'LIKE', "%{$normalizedQ}%")
                      ->orWhere('short_description', 'LIKE', "%{$q}%")
                      ->orWhere('short_description', 'LIKE', "%{$normalizedQ}%")
                      ->orWhere('specimen_type', 'LIKE', "%{$q}%")
                      ->orWhere('included_panels', 'LIKE', "%{$q}%")
                      ->orWhere('included_panels', 'LIKE', "%{$normalizedQ}%");

                if (!empty($words)) {
                    $query->orWhere(function ($sub) use ($words) {
                        foreach ($words as $w) {
                            if (strlen($w) >= 2) {
                                $sub->where('name', 'LIKE', "%{$w}%");
                            }
                        }
                    });
                }
            })
            ->orderBy('is_popular', 'desc')
            ->orderBy('price', 'asc')
            ->limit(10)
            ->get();

        $results = $products->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'slug' => $p->slug,
                'price' => number_format((float) $p->price, 2),
                'specimen_type' => ucfirst($p->specimen_type ?? 'Urine'),
                'turnaround_time' => $p->turnaround_time ?? '1 - 2 Business Days',
                'dot_required' => (bool) $p->dot_required,
                'is_popular' => (bool) $p->is_popular,
                'included_panels' => array_slice($p->included_panels ?? [], 0, 5),
                'total_panels' => count($p->included_panels ?? []),
                'url' => url('/product/' . $p->slug),
                'checkout_url' => route('checkout.index', $p->slug),
            ];
        });

        return response()->json(['results' => $results]);
    }
}
