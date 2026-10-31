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

        // Attach corresponding PageBuilder IDs for quick visual builder access
        $routes = $pages->pluck('slug')->map(fn($s) => '/' . ltrim($s, '/'))->toArray();
        $translations = \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')
            ->whereIn('route', $routes)
            ->pluck('page_id', 'route');

        foreach ($pages as $p) {
            $r = '/' . ltrim($p->slug, '/');
            $p->pb_page_id = $translations[$r] ?? null;
        }

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

        $page = Page::create([
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

        // Auto-create PageBuilder entry
        $pbRoute = '/' . ltrim($page->slug, '/');
        $pbPageId = \Illuminate\Support\Facades\DB::table('pagebuilder__pages')->insertGetId([
            'name' => $page->title,
            'layout' => 'master',
            'data' => json_encode([
                'html' => [$page->content ?: ''],
                'css' => '',
                'components' => [],
                'assets' => [],
                'styles' => [],
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')->insert([
            'page_id' => $pbPageId,
            'locale' => 'en',
            'title' => \Illuminate\Support\Str::limit($page->title, 250, ''),
            'route' => $pbRoute,
            'meta_title' => \Illuminate\Support\Str::limit($page->meta_title ?: $page->title, 250, ''),
            'meta_description' => $page->meta_description ?: '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        $products = Product::where('is_active', true)->orderBy('name')->get();

        // Retrieve or initialize corresponding PHPageBuilder page
        $pbRoute = '/' . ltrim($page->slug, '/');
        $pbTranslation = \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')
            ->where('route', $pbRoute)
            ->first();

        if (!$pbTranslation) {
            $pbPageId = \Illuminate\Support\Facades\DB::table('pagebuilder__pages')->insertGetId([
                'name' => $page->title,
                'layout' => 'master',
                'data' => json_encode([
                    'html' => [$page->content ?: ''],
                    'css' => '',
                    'components' => [],
                    'assets' => [],
                    'styles' => [],
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')->insert([
                'page_id' => $pbPageId,
                'locale' => 'en',
                'title' => \Illuminate\Support\Str::limit($page->title, 250, ''),
                'route' => $pbRoute,
                'meta_title' => \Illuminate\Support\Str::limit($page->meta_title ?: $page->title, 250, ''),
                'meta_description' => $page->meta_description ?: '',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $pbPageId = $pbTranslation->page_id;
        }

        return view('admin.pages.edit', compact('page', 'products', 'pbPageId'));
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

        $oldSlug = $page->slug;
        $newSlug = trim(Str::slug($validated['slug']), '/');

        $page->update([
            'title' => $validated['title'],
            'slug' => $newSlug,
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

        // Sync with PageBuilder translations & content
        $oldPbRoute = '/' . ltrim($oldSlug, '/');
        $newPbRoute = '/' . ltrim($newSlug, '/');
        $pbTranslation = \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')
            ->where('route', $oldPbRoute)
            ->first();

        if ($pbTranslation) {
            \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')
                ->where('id', $pbTranslation->id)
                ->update([
                    'route' => $newPbRoute,
                    'title' => \Illuminate\Support\Str::limit($page->title, 250, ''),
                    'meta_title' => \Illuminate\Support\Str::limit($page->meta_title ?: $page->title, 250, ''),
                    'meta_description' => $page->meta_description ?: '',
                    'updated_at' => now(),
                ]);

            if ($request->filled('content')) {
                $current = \Illuminate\Support\Facades\DB::table('pagebuilder__pages')
                    ->where('id', $pbTranslation->page_id)
                    ->value('data');
                if ($current) {
                    $data = json_decode($current, true) ?: [];
                    $data['html'] = [$request->content];
                    \Illuminate\Support\Facades\DB::table('pagebuilder__pages')
                        ->where('id', $pbTranslation->page_id)
                        ->update([
                            'data' => json_encode($data),
                            'updated_at' => now(),
                        ]);
                }
            }
        }

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted.');
    }
}
