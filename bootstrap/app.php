<?php

use Illuminate\Foundation\Application;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function ($middleware) {
        $middleware->register('admin', \App\Http\Middleware\IsAdmin::class);
        $middleware->register('approuve', \App\Http\Middleware\IsEntrepreneur::class);
    })
    ->withExceptions(function ($exceptions) {
        //
    })
    ->create();

