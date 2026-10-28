<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CmsPageController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminPageController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes - Front End (Option 2 Design Language)
|--------------------------------------------------------------------------
*/

// Home - Look 2 (Client Approved Design)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/design-2', [HomeController::class, 'design2'])->name('home.design2');
Route::get('/design-1', [HomeController::class, 'design1'])->name('home.design1');

// XML Dynamic Sitemap for SEO
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Dynamic Categories & Products
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

// Checkout & PayTrace Payment Gateway
Route::get('/checkout/{slug?}', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/confirmation/{token}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

// Geographic PSEO Location Pages & ZIP Lookup API
Route::get('/locations', [\App\Http\Controllers\LocationController::class, 'index'])->name('locations.index');
Route::get('/locations/{state_slug}', [\App\Http\Controllers\LocationController::class, 'state'])->name('locations.state');
Route::get('/locations/{state_slug}/{city_slug}', [\App\Http\Controllers\LocationController::class, 'city'])->name('locations.city');
Route::get('/api/locations/search', [\App\Http\Controllers\LocationController::class, 'searchZip'])->name('api.locations.search');

/*
|--------------------------------------------------------------------------
| Super Admin Panel Routes (/admin)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    // Guest Admin Auth
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // Authenticated Super Admin Protected Routes
    Route::middleware(['auth', 'super_admin'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Products Management
        Route::resource('products', AdminProductController::class, ['as' => 'admin']);

        // CMS Pages & Visual Builder
        Route::resource('pages', AdminPageController::class, ['as' => 'admin']);

        // Categories Management
        Route::resource('categories', AdminCategoryController::class, ['as' => 'admin']);

        // PayTrace & Site Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');

        // Orders & Registrations
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');

        // Media & Photo Uploader
        Route::post('/media/upload', [\App\Http\Controllers\Admin\AdminMediaController::class, 'upload'])->name('admin.media.upload');
    });
});

/*
|--------------------------------------------------------------------------
| Dynamic Fallback CMS Page Route (Must be last)
|--------------------------------------------------------------------------
*/
Route::get('/{slug}', [CmsPageController::class, 'show'])
    ->where('slug', '[A-Za-z0-9\-_/]+')
    ->name('cms.page');
