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
        $this->decodeBase64Inputs($request);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
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
            'show_sidebar' => 'nullable|boolean',
            'show_hero' => 'nullable|boolean',
            'full_width' => 'nullable|boolean',
        ]);

        $rawSlug = !empty($validated['slug']) ? $validated['slug'] : $validated['title'];
        $baseSlug = Str::slug($rawSlug) ?: ('page-' . time());
        $slug = $baseSlug;
        $counter = 1;
        while (Page::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $blocks = null;
        if (!empty($validated['blocks_json'])) {
            $blocks = json_decode($validated['blocks_json'], true);
        }

        $showSidebar = $request->has('show_sidebar_submitted')
            ? $request->boolean('show_sidebar')
            : ($validated['template'] === 'default');

        $showHero = $request->has('show_hero_submitted')
            ? $request->boolean('show_hero')
            : ($validated['template'] !== 'landing');

        $fullWidth = $request->has('full_width_submitted')
            ? $request->boolean('full_width')
            : in_array($validated['template'], ['landing', 'fullscreen']);

        $pageData = [
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
        ];

        if (\Illuminate\Support\Facades\Schema::hasColumn('pages', 'show_sidebar')) {
            $pageData['show_sidebar'] = $showSidebar;
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('pages', 'show_hero')) {
            $pageData['show_hero'] = $showHero;
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('pages', 'full_width')) {
            $pageData['full_width'] = $fullWidth;
        }

        $page = Page::create($pageData);

        // Auto-create PageBuilder entry
        $pbRoute = '/' . ltrim($page->slug, '/');

        // Delete any existing translation for the same route to prevent duplicate route conflict
        \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')
            ->where('route', $pbRoute)
            ->delete();

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
            'meta_description' => \Illuminate\Support\Str::limit(strip_tags($page->meta_description ?: ''), 250, ''),
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
                'meta_description' => \Illuminate\Support\Str::limit(strip_tags($page->meta_description ?: ''), 250, ''),
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
        $this->decodeBase64Inputs($request);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
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
            'show_sidebar' => 'nullable|boolean',
            'show_hero' => 'nullable|boolean',
            'full_width' => 'nullable|boolean',
        ]);

        $blocks = null;
        if (!empty($validated['blocks_json'])) {
            $blocks = json_decode($validated['blocks_json'], true);
        }

        $oldSlug = $page->slug;
        $rawSlug = !empty($validated['slug']) ? $validated['slug'] : $validated['title'];
        $baseSlug = Str::slug($rawSlug) ?: ('page-' . time());
        $newSlug = $baseSlug;
        $counter = 1;
        while (Page::where('slug', $newSlug)->where('id', '!=', $page->id)->exists()) {
            $newSlug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $showSidebar = $request->has('show_sidebar_submitted')
            ? $request->boolean('show_sidebar')
            : ($validated['template'] === 'default');

        $showHero = $request->has('show_hero_submitted')
            ? $request->boolean('show_hero')
            : ($validated['template'] !== 'landing');

        $fullWidth = $request->has('full_width_submitted')
            ? $request->boolean('full_width')
            : in_array($validated['template'], ['landing', 'fullscreen']);

        $updateData = [
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
        ];

        if (\Illuminate\Support\Facades\Schema::hasColumn('pages', 'show_sidebar')) {
            $updateData['show_sidebar'] = $showSidebar;
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('pages', 'show_hero')) {
            $updateData['show_hero'] = $showHero;
        }
        if (\Illuminate\Support\Facades\Schema::hasColumn('pages', 'full_width')) {
            $updateData['full_width'] = $fullWidth;
        }

        $page->update($updateData);

        // Sync with PageBuilder translations & content
        $oldPbRoute = '/' . ltrim($oldSlug, '/');
        $newPbRoute = '/' . ltrim($newSlug, '/');

        if ($oldPbRoute !== $newPbRoute) {
            \Illuminate\Support\Facades\DB::table('pagebuilder__page_translations')
                ->where('route', $newPbRoute)
                ->delete();
        }

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
                    'meta_description' => \Illuminate\Support\Str::limit(strip_tags($page->meta_description ?: ''), 250, ''),
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

    protected function decodeBase64Inputs(Request $request): void
    {
        $decoded = [];
        foreach ($request->all() as $key => $value) {
            if (is_string($value) && str_ends_with($key, '_b64')) {
                $originalKey = substr($key, 0, -4);
                $decodedValue = base64_decode($value, true);
                if ($decodedValue !== false) {
                    $decoded[$originalKey] = $decodedValue;
                }
            }
        }
        if (!empty($decoded)) {
            $request->merge($decoded);
        }
    }
}
