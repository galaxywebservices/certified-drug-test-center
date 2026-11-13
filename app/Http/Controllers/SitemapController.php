<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Product;
use App\Models\State;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    /**
     * Master Sitemap Index: /sitemap.xml
     * Organizes sitemaps into core, products, and locations.
     */
    public function index(): Response
    {
        $content = Cache::remember('sitemap_index_xml', 86400, function () {
            $lastmod = now()->format('Y-m-d');
            return view('sitemaps.index', compact('lastmod'))->render();
        });

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=86400',
            'X-Robots-Tag' => 'noindex, follow',
        ]);
    }

    /**
     * Core Sitemap: /sitemap-core.xml
     * Flagship Hub (/certified-drug-test-centers), homepage, static tools, and active canonical categories.
     */
    public function core(): Response
    {
        $content = Cache::remember('sitemap_core_xml', 86400, function () {
            $categories = Category::where('is_active', true)
                ->where('is_canonical', true)
                ->select(['id', 'slug', 'updated_at'])
                ->orderBy('position')
                ->get();

            return view('sitemaps.core', compact('categories'))->render();
        });

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=86400',
            'X-Robots-Tag' => 'noindex, follow',
        ]);
    }

    /**
     * Products Sitemap: /sitemap-products.xml
     * Clean, active, canonical product endpoints only.
     */
    public function products(): Response
    {
        ini_set('memory_limit', '512M');

        $content = Cache::remember('sitemap_products_xml', 86400, function () {
            $products = Product::where('is_active', true)
                ->where('is_canonical', true)
                ->select(['id', 'slug', 'updated_at'])
                ->orderBy('id')
                ->get();

            return view('sitemaps.products', compact('products'))->render();
        });

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=86400',
            'X-Robots-Tag' => 'noindex, follow',
        ]);
    }

    /**
     * Locations Sitemap: /sitemap-locations.xml
     * 51 canonical state pages + gated hierarchical cities passing local-clinic threshold (>=1 center within 35 miles).
     */
    public function locations(): Response
    {
        ini_set('memory_limit', '512M');

        $content = Cache::remember('sitemap_locations_xml', 86400, function () {
            $states = State::where('is_active', true)
                ->select(['id', 'slug', 'updated_at'])
                ->orderBy('name')
                ->get();

            $cities = City::join('pseo_eligible_cities', 'cities.id', '=', 'pseo_eligible_cities.city_id')
                ->join('states', 'cities.state_id', '=', 'states.id')
                ->where('cities.is_active', true)
                ->where('states.is_active', true)
                ->where('pseo_eligible_cities.is_eligible', true)
                ->select('cities.slug as city_slug', 'states.slug as state_slug', 'cities.updated_at')
                ->orderBy('states.name')
                ->orderBy('cities.name')
                ->get();

            return view('sitemaps.locations', compact('states', 'cities'))->render();
        });

        return response($content, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=86400',
            'X-Robots-Tag' => 'noindex, follow',
        ]);
    }
}
