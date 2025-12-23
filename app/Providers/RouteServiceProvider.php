<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    public function middlewareAliases(): array
    {
        return [
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ];
    }
}
