<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $categories = Category::where('is_active', true)->get();
        $products = Product::where('is_active', true)->get();
        $pages = Page::where('is_published', true)->where('robots_index', true)->get();
        $states = \App\Models\State::where('is_active', true)->get();
        $cities = \App\Models\City::with('state')
            ->where('is_active', true)
            ->whereNotNull('content')
            ->limit(1000)
            ->get();

        $content = view('sitemap', compact('categories', 'products', 'pages', 'states', 'cities'))->render();

        return response($content, 200, [
            'Content-Type' => 'application/xml',
        ]);
    }
}
