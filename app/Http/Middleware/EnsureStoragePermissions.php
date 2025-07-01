<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStoragePermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Fungsi untuk membuat folder jika belum ada
        $ensureDirectoryExists = function ($path) {
            if (!file_exists($path)) {
                @mkdir($path, 0777, true);
            }
        };

        // Pastikan folder storage/app/public ada
        $publicPath = storage_path('app/public');
        $ensureDirectoryExists($publicPath);

        // Pastikan folder storage/app/public/foods ada
        $foodsPath = storage_path('app/public/foods');
        $ensureDirectoryExists($foodsPath);

        // Pastikan folder storage/app/public/categories ada
        $categoriesPath = storage_path('app/public/categories');
        $ensureDirectoryExists($categoriesPath);

        // Pastikan symbolic link ada
        $publicStoragePath = public_path('storage');
        if (!file_exists($publicStoragePath)) {
            try {
                symlink(storage_path('app/public'), $publicStoragePath);
            } catch (\Exception $e) {
                // Ignore errors
            }
        }

        return $next($request);
    }
} 