<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'isAdministrator' => \App\Http\Middleware\isAdministrator::class,
            'isResepsionis' => \App\Http\Middleware\isResepsionis::class,
            'isPerawat' => \App\Http\Middleware\isPerawat::class,
            'isDokter' => \App\Http\Middleware\isDokter::class,
            'isPemilik' => \App\Http\Middleware\isPemilik::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
