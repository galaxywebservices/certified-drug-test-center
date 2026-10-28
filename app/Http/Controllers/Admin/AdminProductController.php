<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('categories');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('slug', 'LIKE', "%{$search}%")
                  ->orWhere('sku', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $catId = $request->input('category_id');
            $query->whereHas('categories', function ($q) use ($catId) {
                $q->where('categories.id', $catId);
            });
        }

        if ($request->filled('specimen')) {
            $query->where('specimen_type', $request->input('specimen'));
        }

        $products = $query->orderBy('position')->orderBy('id', 'desc')->paginate(20)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:150|unique:products,slug',
            'price' => 'required|numeric|min:0',
            'retail_price' => 'nullable|numeric|min:0',
            'subtitle' => 'nullable|string',
            'specimen_type' => 'required|string',
            'dot_required' => 'boolean',
            'turnaround_time' => 'nullable|string|max:100',
            'short_description' => 'nullable|string',
            'details' => 'nullable|string',
            'preparation_instructions' => 'nullable|string',
            'included_panels' => 'nullable|string',
            'categories' => 'nullable|array',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|string',
        ]);

        $slug = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        $panels = [];
        if (!empty($validated['included_panels'])) {
            $panels = array_filter(array_map('trim', explode(',', $validated['included_panels'])));
        }

        $product = Product::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'price' => $validated['price'],
            'retail_price' => $validated['retail_price'] ?: round($validated['price'] * 1.3, 2),
            'subtitle' => $validated['subtitle'] ?? 'Online Discount Applied',
            'specimen_type' => $validated['specimen_type'],
            'dot_required' => $request->boolean('dot_required'),
            'turnaround_time' => $validated['turnaround_time'] ?: '24-48 Hours Lab MRO',
            'short_description' => $validated['short_description'],
            'details' => $validated['details'],
            'preparation_instructions' => $validated['preparation_instructions'],
            'included_panels' => $panels,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active', true),
            'meta_title' => $validated['meta_title'] ?: "{$validated['name']} | Certified Drug Test Center",
            'meta_description' => $validated['meta_description'],
            'canonical_url' => $validated['canonical_url'] ?: url('/product/' . $slug),
        ]);

        if (!empty($validated['categories'])) {
            $product->categories()->sync($validated['categories']);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:150|unique:products,slug,' . $product->id,
            'price' => 'required|numeric|min:0',
            'retail_price' => 'nullable|numeric|min:0',
            'subtitle' => 'nullable|string',
            'specimen_type' => 'required|string',
            'dot_required' => 'boolean',
            'turnaround_time' => 'nullable|string|max:100',
            'short_description' => 'nullable|string',
            'details' => 'nullable|string',
            'preparation_instructions' => 'nullable|string',
            'included_panels' => 'nullable|string',
            'categories' => 'nullable|array',
            'is_popular' => 'boolean',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|string',
        ]);

        $panels = [];
        if (!empty($validated['included_panels'])) {
            $panels = array_filter(array_map('trim', explode(',', $validated['included_panels'])));
        }

        $product->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'price' => $validated['price'],
            'retail_price' => $validated['retail_price'] ?: round($validated['price'] * 1.3, 2),
            'subtitle' => $validated['subtitle'],
            'specimen_type' => $validated['specimen_type'],
            'dot_required' => $request->boolean('dot_required'),
            'turnaround_time' => $validated['turnaround_time'],
            'short_description' => $validated['short_description'],
            'details' => $validated['details'],
            'preparation_instructions' => $validated['preparation_instructions'],
            'included_panels' => $panels,
            'is_popular' => $request->boolean('is_popular'),
            'is_active' => $request->boolean('is_active'),
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
            'canonical_url' => $validated['canonical_url'],
        ]);

        $product->categories()->sync($validated['categories'] ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}
