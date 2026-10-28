<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPageController extends Controller
{
    public function index(Request $request)
    {
        $query = Page::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('slug', 'LIKE', "%{$search}%")
                  ->orWhere('meta_title', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $isPublished = $request->input('status') === 'published';
            $query->where('is_published', $isPublished);
        }

        $pages = $query->orderBy('updated_at', 'desc')->paginate(25)->withQueryString();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('admin.pages.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'page_heading' => 'nullable|string|max:255',
            'template' => 'required|string|max:50',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string|max:255',
            'blocks_json' => 'nullable|string',
            'is_published' => 'boolean',
            'show_in_menu' => 'boolean',
            'menu_name' => 'nullable|string|max:100',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|string',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
        ]);

        $slug = $validated['slug'] ? Str::slug($validated['slug']) : Str::slug($validated['title']);

        $blocks = null;
        if (!empty($validated['blocks_json'])) {
            $blocks = json_decode($validated['blocks_json'], true);
        }

        Page::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'page_heading' => $validated['page_heading'] ?? $validated['title'],
            'template' => $validated['template'] ?? 'default',
            'content' => $validated['content'] ?? '',
            'featured_image' => $validated['featured_image'] ?? null,
            'blocks_json' => $blocks,
            'is_published' => $request->boolean('is_published', true),
            'show_in_menu' => $request->boolean('show_in_menu'),
            'menu_name' => $validated['menu_name'] ?? null,
            'meta_title' => $validated['meta_title'] ?? "{$validated['title']} | Certified Drug Test Center",
            'meta_description' => $validated['meta_description'] ?? null,
            'canonical_url' => $validated['canonical_url'] ?? url('/' . $slug),
            'robots_index' => $request->boolean('robots_index', true),
            'robots_follow' => $request->boolean('robots_follow', true),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();
        return view('admin.pages.edit', compact('page', 'products'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'page_heading' => 'nullable|string|max:255',
            'template' => 'required|string|max:50',
            'content' => 'nullable|string',
            'featured_image' => 'nullable|string|max:255',
            'blocks_json' => 'nullable|string',
            'is_published' => 'boolean',
            'show_in_menu' => 'boolean',
            'menu_name' => 'nullable|string|max:100',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'canonical_url' => 'nullable|string',
            'robots_index' => 'boolean',
            'robots_follow' => 'boolean',
        ]);

        $blocks = null;
        if (!empty($validated['blocks_json'])) {
            $blocks = json_decode($validated['blocks_json'], true);
        }

        $page->update([
            'title' => $validated['title'],
            'slug' => trim(Str::slug($validated['slug']), '/'),
            'page_heading' => $validated['page_heading'] ?? $validated['title'],
            'template' => $validated['template'] ?? 'default',
            'content' => $validated['content'] ?? '',
            'featured_image' => $validated['featured_image'] ?? null,
            'blocks_json' => $blocks,
            'is_published' => $request->boolean('is_published'),
            'show_in_menu' => $request->boolean('show_in_menu'),
            'menu_name' => $validated['menu_name'] ?? null,
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'canonical_url' => $validated['canonical_url'] ?? null,
            'robots_index' => $request->boolean('robots_index', true),
            'robots_follow' => $request->boolean('robots_follow', true),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted.');
    }
}
