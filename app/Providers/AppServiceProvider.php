<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\MidtransPaymentService;
use App\Contracts\PaymentServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentServiceInterface::class, MidtransPaymentService::class);
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
        // Pagination
        Paginator::useBootstrap();
        // Components
        Blade::include('components.header', 'Header');
    }
}
