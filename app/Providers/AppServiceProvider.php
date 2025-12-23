<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Carbon\Carbon;

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
    Blade::componentNamespace('App\\View\\Components', 'app');
     // Configurar Carbon en español
    Carbon::setLocale('es');
    
    // Opcional: establecer la localización (puede variar según el país)
    setlocale(LC_TIME, 'es_ES', 'es', 'ES', 'es_ES.utf8');
}
    
}
