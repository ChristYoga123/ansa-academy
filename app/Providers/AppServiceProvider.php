<?php

namespace App\Providers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use BezhanSalleh\FilamentShield\Facades\FilamentShield;

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
        Schema::defaultStringLength(191);
        // Filament Shield
        FilamentShield::configurePermissionIdentifierUsing(
            fn($resource) => Str::of($resource)
                ->afterLast('Resources\\')
                ->before('Resource')
                ->replace('\\', '')
                ->snake()
                ->replace('_', '::')
        );
    }
}
