<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Page;
use App\Models\Product;
use App\Models\State;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index(): Response
    {
        ini_set('memory_limit', '512M');

        $content = Cache::remember('sitemap_xml', 86400, function () {
            $categories = Category::where('is_active', true)
                ->select(['id', 'slug', 'updated_at'])
                ->get();

            $products = Product::where('is_active', true)
                ->select(['id', 'slug', 'updated_at'])
                ->get();

            $pages = Page::where('is_published', true)
                ->where('robots_index', true)
                ->select(['id', 'slug', 'updated_at'])
                ->get();

            $states = State::where('is_active', true)
                ->select(['id', 'slug', 'updated_at'])
                ->get();

            $cities = City::with(['state' => fn($q) => $q->select(['id', 'abbr'])])
                ->where('is_active', true)
                ->whereNotNull('content')
                ->select(['id', 'state_id', 'slug', 'updated_at'])
                ->limit(1000)
                ->get();

            return view('sitemap', compact('categories', 'products', 'pages', 'states', 'cities'))->render();
        });

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }
}
