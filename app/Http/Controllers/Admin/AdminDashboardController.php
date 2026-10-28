<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Page;
use App\Models\Order;
use App\Models\Location;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $productsCount = Product::count();
        $activeProductsCount = Product::where('is_active', true)->count();
        $categoriesCount = Category::count();
        $pagesCount = Page::count();
        $ordersCount = Order::count();
        $revenue = Order::where('payment_status', 'paid')->sum('total');
        $locationsCount = Location::count();

        $recentOrders = Order::with('items')->latest()->limit(5)->get();
        $recentPages = Page::latest('updated_at')->limit(5)->get();

        return view('admin.dashboard', compact(
            'productsCount',
            'activeProductsCount',
            'categoriesCount',
            'pagesCount',
            'ordersCount',
            'revenue',
            'locationsCount',
            'recentOrders',
            'recentPages'
        ));
    }
}
