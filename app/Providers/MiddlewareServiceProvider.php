<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class MiddlewareServiceProvider extends ServiceProvider
{
    public function boot(Router $router)
    {
        $router->aliasMiddleware('admin', \App\Http\Middleware\IsAdmin::class);
        $router->aliasMiddleware('entrepreneur', \App\Http\Middleware\IsEntrepreneur::class);
    }
}
