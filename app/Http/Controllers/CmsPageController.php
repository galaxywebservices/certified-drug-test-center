<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CmsPageController extends Controller
{
    public function show(string $slug)
    {
        $cleanSlug = trim($slug, '/');

        $page = Page::where('slug', $cleanSlug)
            ->where('is_published', true)
            ->first();

        if (!$page) {
            abort(404);
        }

        $pageTitle = $page->meta_title ?: "{$page->title} | Certified Drug Test Center";
        $metaDescription = $page->meta_description ?: "Accredited drug testing information and nationwide services for {$page->title}.";
        $canonicalUrl = $page->canonical_url ?: url('/' . $page->slug);

        // Sidebar categories and popular tests
        $popularTests = Product::where('is_popular', true)->where('is_active', true)->limit(5)->get();
        $categories = Category::where('is_active', true)->orderBy('position')->limit(8)->get();

        return view('pages.show', compact('page', 'pageTitle', 'metaDescription', 'canonicalUrl', 'popularTests', 'categories'));
    }
}
