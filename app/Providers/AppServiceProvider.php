<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if($this->app->environment('production') || !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Share low stock products with navbar
        \Illuminate\Support\Facades\View::composer('components.navbar', function ($view) {
            $lowStockProducts = \App\Models\Articulo::where('stock', '<=', 10)
                ->where('estado', '!=', 'inactivo') // Optional: ignore inactive
                ->get();
            $view->with('lowStockProducts', $lowStockProducts);
        });
    }
}
