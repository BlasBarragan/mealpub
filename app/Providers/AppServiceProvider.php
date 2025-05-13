<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // añadimos para forzar https

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
    { // fuerzo https para desplegar en producción
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
