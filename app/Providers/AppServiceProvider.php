<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

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
        // Locale id
        Carbon::setLocale('id');
        // set default string length
        Schema::defaultStringLength(191);
        // menu config
        View::composer('components.navbar', function ($view)
        {
            $view->with('menus', config('menu'));
        });
    }
}
