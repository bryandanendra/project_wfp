<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Storage;

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
        // Pastikan folder storage ada dan dapat diakses
        $this->ensureStorageDirectoriesExist();
    }

    /**
     * Pastikan folder storage ada dan dapat diakses
     */
    protected function ensureStorageDirectoriesExist(): void
    {
        try {
            // Pastikan folder storage/app/public ada
            $publicPath = storage_path('app/public');
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0777, true);
            }
            
            // Pastikan folder storage/app/public/foods ada
            $foodsPath = storage_path('app/public/foods');
            if (!file_exists($foodsPath)) {
                mkdir($foodsPath, 0777, true);
            }
            
            // Pastikan folder storage/app/public/categories ada
            $categoriesPath = storage_path('app/public/categories');
            if (!file_exists($categoriesPath)) {
                mkdir($categoriesPath, 0777, true);
            }
            
            // Pastikan symbolic link ada
            $publicStoragePath = public_path('storage');
            if (!file_exists($publicStoragePath) && !app()->runningInConsole()) {
                try {
                    \Artisan::call('storage:link');
                } catch (\Exception $e) {
                    // Ignore errors
                }
            }
        } catch (\Exception $e) {
            // Log error tapi jangan crash aplikasi
            if (app()->hasBeenBootstrapped() && app()->bound('log')) {
                \Log::error('Gagal membuat folder storage: ' . $e->getMessage());
            }
        }
    }
}
