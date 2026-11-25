<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\NavigationItem;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminNavigationController extends Controller
{
    /**
     * Display navigation management dashboard with tree and quick-add tools.
     */
    public function index(Request $request): View
    {
        $items = NavigationItem::topLevel()
            ->with(['children' => function ($q) {
                $q->with('page')->orderBy('order')->orderBy('id');
            }, 'page'])
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        $parentOptions = NavigationItem::topLevel()
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        $pages = Page::where('is_published', true)
            ->orderBy('title')
            ->get(['id', 'title', 'slug', 'updated_at']);

        $categories = Category::where('is_active', true)
            ->orderBy('position')
            ->get(['id', 'name', 'slug']);

        $products = Product::where('is_active', true)
            ->orderBy('name')
            ->limit(30)
            ->get(['id', 'name', 'slug', 'price']);

        return view('admin.navigation.index', compact(
            'items',
            'parentOptions',
            'pages',
            'categories',
            'products'
        ));
    }

    /**
     * Store a newly created navigation item.
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'parent_id' => 'nullable|exists:navigation_items,id',
            'page_id' => 'nullable|exists:pages,id',
            'target' => 'nullable|in:_self,_blank',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'css_class' => 'nullable|string|max:100',
        ]);

        // Auto-assign order if not provided
        if (!isset($validated['order']) || $validated['order'] === null) {
            $maxOrder = NavigationItem::where('parent_id', $validated['parent_id'] ?? null)->max('order');
            $validated['order'] = ($maxOrder !== null) ? ($maxOrder + 1) : 1;
        }

        // If a CMS page is linked and URL is empty, derive relative URL
        if (!empty($validated['page_id']) && empty($validated['url'])) {
            $page = Page::find($validated['page_id']);
            if ($page) {
                $validated['url'] = '/' . ltrim($page->slug, '/');
            }
        }

        $validated['target'] = $validated['target'] ?? '_self';
        $validated['is_active'] = $request->boolean('is_active', true);

        $item = NavigationItem::create($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Menu item created successfully.',
                'item' => $item->load('page'),
            ]);
        }

        return redirect()->route('admin.navigation.index')->with('success', "Menu item '{$item->title}' created successfully.");
    }

    /**
     * Update an existing navigation item.
     */
    public function update(Request $request, NavigationItem $navigation): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'parent_id' => 'nullable|exists:navigation_items,id',
            'page_id' => 'nullable|exists:pages,id',
            'target' => 'nullable|in:_self,_blank',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'css_class' => 'nullable|string|max:100',
        ]);

        // Prevent item from setting itself as its own parent
        if (!empty($validated['parent_id']) && (int)$validated['parent_id'] === (int)$navigation->id) {
            $validated['parent_id'] = null;
        }

        if (!empty($validated['page_id']) && empty($validated['url'])) {
            $page = Page::find($validated['page_id']);
            if ($page) {
                $validated['url'] = '/' . ltrim($page->slug, '/');
            }
        }

        $validated['target'] = $validated['target'] ?? '_self';
        $validated['is_active'] = $request->has('is_active') ? $request->boolean('is_active') : $navigation->is_active;

        $navigation->update($validated);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Menu item updated successfully.',
                'item' => $navigation->load('page'),
            ]);
        }

        return redirect()->route('admin.navigation.index')->with('success', "Menu item '{$navigation->title}' updated successfully.");
    }

    /**
     * Delete a navigation item.
     */
    public function destroy(Request $request, NavigationItem $navigation): RedirectResponse|JsonResponse
    {
        $title = $navigation->title;
        $navigation->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Menu item '{$title}' removed.",
            ]);
        }

        return redirect()->route('admin.navigation.index')->with('success', "Menu item '{$title}' removed successfully.");
    }

    /**
     * AJAX Endpoint: Reorder menu items and/or update parents via Drag & Drop.
     */
    public function reorder(Request $request): JsonResponse
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:navigation_items,id',
            'items.*.parent_id' => 'nullable',
            'items.*.order' => 'required|integer',
        ]);

        $submittedItems = $request->input('items', []);

        foreach ($submittedItems as $raw) {
            $parentId = !empty($raw['parent_id']) ? (int)$raw['parent_id'] : null;
            $order = (int)$raw['order'];
            $id = (int)$raw['id'];

            // Prevent self-parenting
            if ($parentId === $id) {
                $parentId = null;
            }

            NavigationItem::where('id', $id)->update([
                'parent_id' => $parentId,
                'order' => $order,
            ]);
        }

        NavigationItem::clearCache();

        return response()->json([
            'success' => true,
            'message' => 'Navigation order updated successfully.',
        ]);
    }

    /**
     * AJAX / Post Endpoint: Toggle active/inactive state of a menu item.
     */
    public function toggleStatus(NavigationItem $navigation): JsonResponse
    {
        $navigation->is_active = !$navigation->is_active;
        $navigation->save();

        return response()->json([
            'success' => true,
            'is_active' => $navigation->is_active,
            'message' => "Item '{$navigation->title}' " . ($navigation->is_active ? 'activated' : 'deactivated') . '.',
        ]);
    }

    /**
     * Quick-add a CMS page directly into navigation toolbar or under a parent submenu.
     */
    public function quickAddPage(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'page_id' => 'required|exists:pages,id',
            'parent_id' => 'nullable|exists:navigation_items,id',
            'custom_title' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
        ]);

        $page = Page::findOrFail($validated['page_id']);
        $title = !empty($validated['custom_title']) ? $validated['custom_title'] : $page->title;

        $maxOrder = NavigationItem::where('parent_id', $validated['parent_id'] ?? null)->max('order');
        $order = isset($validated['order']) && $validated['order'] !== null
            ? (int)$validated['order']
            : (($maxOrder !== null) ? ($maxOrder + 1) : 1);

        $item = NavigationItem::create([
            'parent_id' => $validated['parent_id'] ?? null,
            'page_id' => $page->id,
            'title' => $title,
            'url' => '/' . ltrim($page->slug, '/'),
            'target' => '_self',
            'order' => $order,
            'is_active' => true,
        ]);

        // Keep page's show_in_menu flag synchronized
        $page->update([
            'show_in_menu' => true,
            'menu_parent_id' => $item->parent_id,
            'menu_order' => $item->order,
            'menu_name' => $item->title,
        ]);

        return redirect()->route('admin.navigation.index')->with('success', "Page '{$title}' successfully placed in navigation menu!");
    }

    /**
     * Reset navigation to the certified default structure.
     */
    public function resetDefault(Request $request): RedirectResponse
    {
        NavigationItem::seedDefaultNavigation();

        return redirect()->route('admin.navigation.index')->with('success', 'Navigation menu reset to default certified structure.');
    }
}
