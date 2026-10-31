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
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminLeadController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\EmployerPortalController;
use App\Http\Controllers\TestFinderController;
use App\Http\Controllers\ReviewController;

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

// AEO & GEO Standards: llms.txt, llms-full.txt, robots.txt
Route::get('/llms.txt', function () {
    return response()->file(public_path('llms.txt'), [
        'Content-Type' => 'text/markdown; charset=UTF-8',
    ]);
});
Route::get('/llms-full.txt', function () {
    return response()->file(public_path('llms-full.txt'), [
        'Content-Type' => 'text/markdown; charset=UTF-8',
    ]);
});
Route::get('/robots.txt', function () {
    return response()->file(public_path('robots.txt'), [
        'Content-Type' => 'text/plain; charset=UTF-8',
    ]);
});

// Canonical Legal Aliases
Route::redirect('/terms-of-service', '/terms-and-conditions');
Route::redirect('/terms', '/terms-and-conditions');
Route::redirect('/privacy', '/privacy-policy');
Route::redirect('/contact', '/contact-us');
Route::redirect('/login', '/admin/login')->name('login');

// Contact Us & Corporate Consultation
Route::get('/contact-us', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact-us', [ContactController::class, 'submit'])->middleware('throttle:15,1')->name('contact.submit');

// Dynamic Categories & Products
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::get('/api/products/search', [ProductController::class, 'search'])->name('api.products.search');

// Checkout & PayTrace Payment Gateway
Route::get('/checkout/{slug?}', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->middleware('throttle:20,1')->name('checkout.process');
Route::get('/checkout/confirmation/{token}', [CheckoutController::class, 'confirmation'])->name('checkout.confirmation');

// Order Tracking, Electronic Donor Pass & MRO Certificates
Route::get('/track-order', [OrderTrackingController::class, 'index'])->name('order.track');
Route::post('/track-order', [OrderTrackingController::class, 'lookup'])->middleware('throttle:30,1')->name('order.track.lookup');
Route::post('/track-order/resend', [OrderTrackingController::class, 'resend'])->name('order.track.resend');
Route::get('/orders/certificate/{token}', [\App\Http\Controllers\OrderCertificateController::class, 'show'])->name('orders.certificate');
Route::redirect('/donor-pass', '/track-order');
Route::redirect('/order-status', '/track-order');
Route::redirect('/order-tracking', '/track-order');

// Employer & Corporate Solutions Suite
Route::get('/employers', [EmployerController::class, 'index'])->name('employers.index');
Route::post('/employers', [EmployerController::class, 'submit'])->middleware('throttle:15,1')->name('employers.submit');
Route::redirect('/corporate-accounts', '/employers');
Route::redirect('/business-solutions', '/employers');
Route::redirect('/employer-accounts', '/employers');
Route::redirect('/corporate', '/employers');

// Employer Self-Service Portal & Candidate Pipeline Suite
Route::get('/employers/portal', [EmployerPortalController::class, 'index'])->name('employers.portal');
Route::post('/employers/portal/login', [EmployerPortalController::class, 'login'])->middleware('throttle:10,1')->name('employers.portal.login');
Route::post('/employers/portal/demo', [EmployerPortalController::class, 'demoLogin'])->name('employers.portal.demo');
Route::post('/employers/portal/logout', [EmployerPortalController::class, 'logout'])->name('employers.portal.logout');
Route::post('/employers/portal/dispatch', [EmployerPortalController::class, 'dispatchCandidatePass'])->middleware('throttle:20,1')->name('employers.portal.dispatch');
Route::post('/employers/portal/orders/{order}/resend-pass', [EmployerPortalController::class, 'resendPass'])->name('employers.portal.resend-pass');
Route::get('/employers/portal/export', [EmployerPortalController::class, 'exportCsv'])->name('employers.portal.export');
Route::post('/employers/portal/random-draw', [EmployerPortalController::class, 'randomDraw'])->name('employers.portal.random-draw');

Route::redirect('/employer-portal', '/employers/portal');
Route::redirect('/corporate/portal', '/employers/portal');
Route::redirect('/portal', '/employers/portal');

// Guided Drug Test Finder & Medical Recommender Tool
Route::get('/find-my-test', [TestFinderController::class, 'index'])->name('test-finder.index');
Route::redirect('/test-selector', '/find-my-test');
Route::redirect('/test-recommender', '/find-my-test');
Route::redirect('/which-test', '/find-my-test');

// Verified Patient & Client Reviews
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::redirect('/testimonials', '/reviews');
Route::redirect('/customer-reviews', '/reviews');


// Geographic PSEO Location Pages & ZIP Lookup API
Route::get('/locations', [\App\Http\Controllers\LocationController::class, 'index'])->name('locations.index');
Route::get('/location/{id}', [\App\Http\Controllers\LocationController::class, 'show'])->name('locations.show')->whereNumber('id');
Route::get('/locations/site/{id}', [\App\Http\Controllers\LocationController::class, 'show'])->whereNumber('id');
Route::get('/locations/{state_slug}', [\App\Http\Controllers\LocationController::class, 'state'])->name('locations.state');
Route::get('/locations/{state_slug}/{city_slug}', [\App\Http\Controllers\LocationController::class, 'city'])->name('locations.city');
Route::get('/locations/{state_slug}/{city_slug}/site-{id}', [\App\Http\Controllers\LocationController::class, 'show'])->whereNumber('id');
Route::get('/api/locations/search', [\App\Http\Controllers\LocationController::class, 'searchZip'])->name('api.locations.search');

// Programmatic SEO Chain URLs & Aliases (e.g. /drug-testing-locations/{state}/{city}, /drug-testing-{city}-{state})
Route::get('/drug-testing-locations', [\App\Http\Controllers\LocationController::class, 'index']);
Route::get('/drug-testing-locations/{state_slug}', [\App\Http\Controllers\LocationController::class, 'state']);
Route::get('/drug-testing-locations/{state_slug}/{city_slug}', [\App\Http\Controllers\LocationController::class, 'city']);
Route::get('/drug-testing-{chain_city}', [\App\Http\Controllers\LocationController::class, 'resolveChainCity'])
    ->where('chain_city', '[a-zA-Z0-9\-]+');
Route::get('/local-drug-testing-locations-{chain_city}', [\App\Http\Controllers\LocationController::class, 'resolveChainCity'])
    ->where('chain_city', '[a-zA-Z0-9\-]+');
Route::get('/{state_name}-drug-testing', function(string $stateName) {
    $slug = strtolower($stateName);
    $state = \App\Models\State::where('slug', $slug)
        ->orWhere('name', str_replace('-', ' ', $stateName))
        ->first();
    if ($state) {
        return app(\App\Http\Controllers\LocationController::class)->state($state->slug);
    }
    abort(404);
})->where('state_name', '[a-zA-Z\-]+');

/*
|--------------------------------------------------------------------------
| Super Admin Panel Routes (/admin)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    // Guest Admin Auth & Recovery
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPassword'])->name('admin.password.request');
    Route::post('/forgot-password', [AdminAuthController::class, 'sendResetLink'])->middleware('throttle:5,1')->name('admin.password.email');
    Route::get('/reset-password/{token}', [AdminAuthController::class, 'showResetPassword'])->name('admin.password.reset');
    Route::post('/reset-password', [AdminAuthController::class, 'resetPassword'])->middleware('throttle:10,1')->name('admin.password.update');

    // Authenticated Super Admin Protected Routes
    Route::middleware(['auth', 'super_admin'])->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // Super Admin Profile & Password Management
        Route::get('/profile', [AdminProfileController::class, 'edit'])->name('admin.profile');
        Route::put('/profile', [AdminProfileController::class, 'updateProfile'])->name('admin.profile.update');
        Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('admin.profile.password');

        // Products Management
        Route::resource('products', AdminProductController::class, ['as' => 'admin']);

        // CMS Pages & Visual Builder
        Route::resource('pages', AdminPageController::class, ['as' => 'admin']);

        // Drag & Drop Visual Page Builder (PHPageBuilder / GrapesJS like ATA LMS)
        Route::any('/pagebuilder/{any?}', function (\Illuminate\Http\Request $request) {
            $config = config('pagebuilder');
            $builder = new \HansSchouten\LaravelPageBuilder\LaravelPageBuilder($config);
            $builder->handleAuthenticatedRequest();
        })->where('any', '.*')->name('admin.pagebuilder');

        Route::post('/pagebuilder-upload', function (\Illuminate\Http\Request $request) {
            if (!$request->hasFile('files')) {
                return response()->json(['data' => [], 'error' => 'no_files']);
            }
            $file = $request->file('files');
            $id = sha1(uniqid(true));
            $safeName = str_replace(' ', '-', $file->getClientOriginalName());
            $relativeDir = "uploads/pagebuilder/{$id}";
            $targetDir = public_path($relativeDir);
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $file->move($targetDir, $safeName);
            $url = url("/{$relativeDir}/{$safeName}");
            return response()->json(['data' => [$url]]);
        })->name('admin.pagebuilder.upload');

        // Categories Management
        Route::resource('categories', AdminCategoryController::class, ['as' => 'admin']);

        // PayTrace & Site Settings
        Route::get('/settings', [AdminSettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');

        // Orders & Registrations
        Route::get('/orders/export', [AdminOrderController::class, 'export'])->name('admin.orders.export');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::get('/orders/{order}/certificate', [\App\Http\Controllers\OrderCertificateController::class, 'adminShow'])->name('admin.orders.certificate');
        Route::post('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');
        Route::post('/orders/{order}/resend-pass', [AdminOrderController::class, 'resendPass'])->name('admin.orders.resend-pass');

        // Customer & Corporate Inquiries (Leads)
        Route::get('/leads', [AdminLeadController::class, 'index'])->name('admin.leads.index');
        Route::post('/leads/{lead}/status', [AdminLeadController::class, 'updateStatus'])->name('admin.leads.update-status');
        Route::delete('/leads/{lead}', [AdminLeadController::class, 'destroy'])->name('admin.leads.destroy');

        // Media & Photo Uploader
        Route::post('/media/upload', [\App\Http\Controllers\Admin\AdminMediaController::class, 'upload'])->name('admin.media.upload');

        // Collection Locations & PSEO Cities
        Route::get('/locations', [\App\Http\Controllers\Admin\AdminLocationController::class, 'index'])->name('admin.locations.index');
        Route::get('/locations/{location}/edit', [\App\Http\Controllers\Admin\AdminLocationController::class, 'edit'])->name('admin.locations.edit');
        Route::put('/locations/{location}', [\App\Http\Controllers\Admin\AdminLocationController::class, 'update'])->name('admin.locations.update');
        Route::get('/cities', [\App\Http\Controllers\Admin\AdminLocationController::class, 'cities'])->name('admin.cities.index');
        Route::get('/cities/{city}/edit', [\App\Http\Controllers\Admin\AdminLocationController::class, 'editCity'])->name('admin.cities.edit');
        Route::put('/cities/{city}', [\App\Http\Controllers\Admin\AdminLocationController::class, 'updateCity'])->name('admin.cities.update');
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
