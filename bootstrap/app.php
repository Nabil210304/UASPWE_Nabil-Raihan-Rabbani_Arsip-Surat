<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\UserAccessMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Menambahkan middleware global (jika diperlukan)

        // Menambahkan alias middleware
        $middleware->alias([
            'user.access' => UserAccessMiddleware::class, // Alias untuk middleware UserAccessMiddleware
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();