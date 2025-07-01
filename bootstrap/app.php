<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Memuat file storage_permissions.php untuk mengatur permission folder storage
// Hanya jika file ada dan kita tidak sedang di console (untuk menghindari error)
if (file_exists(__DIR__.'/storage_permissions.php') && php_sapi_name() !== 'cli') {
    try {
        require_once __DIR__.'/storage_permissions.php';
    } catch (\Exception $e) {
        // Ignore errors
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
