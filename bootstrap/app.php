<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'group' => \App\Http\Middleware\GroupMiddleware::class,
            'cek_login' => \App\Http\Middleware\CekLogin::class, // Ganti 'auth' agar sesuai pemanggilan
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
