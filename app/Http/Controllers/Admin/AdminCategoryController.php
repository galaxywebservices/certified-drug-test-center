<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('position')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'display_name' => 'nullable|string|max:150',
            'slug' => 'nullable|string|max:100|unique:categories,slug',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|string',
        ]);

        $slug = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        Category::create([
            'name' => $validated['name'],
            'display_name' => $validated['display_name'] ?: $validated['name'],
            'slug' => $slug,
            'subtitle' => $validated['subtitle'],
            'description' => $validated['description'],
            'position' => $validated['position'] ?? 0,
            'is_active' => $request->boolean('is_active', true),
            'meta_title' => $validated['meta_title'] ?: "{$validated['name']} | Certified Drug Test Center",
            'meta_description' => $validated['meta_description'],
            'canonical_url' => $validated['canonical_url'] ?: url('/category/' . $slug),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'display_name' => 'nullable|string|max:150',
            'slug' => 'required|string|max:100|unique:categories,slug,' . $category->id,
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'position' => 'nullable|integer',
            'is_active' => 'boolean',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|string',
        ]);

        $category->update([
            'name' => $validated['name'],
            'display_name' => $validated['display_name'] ?: $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'subtitle' => $validated['subtitle'],
            'description' => $validated['description'],
            'position' => $validated['position'] ?? 0,
            'is_active' => $request->boolean('is_active'),
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
            'canonical_url' => $validated['canonical_url'],
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
    }
}
