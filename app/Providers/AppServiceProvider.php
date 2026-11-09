<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Pagination\Paginator::defaultView('admin.partials.pagination');
        \Illuminate\Pagination\Paginator::defaultSimpleView('admin.partials.pagination');

        \Illuminate\Support\Facades\View::composer(['layouts.main', 'home-design-1', 'home-design-2'], function ($view) {
            $globalStates = \Illuminate\Support\Facades\Cache::remember('global_active_states_list', 86400, function () {
                return \App\Models\State::where('is_active', true)
                    ->orderBy('name')
                    ->get(['id', 'name', 'slug', 'abbr']);
            });
            $view->with('globalStates', $globalStates);
        });
    }
}
