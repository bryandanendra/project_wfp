<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixStoragePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:fix-permissions {--force : Paksa menggunakan sudo untuk mengubah permission}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix storage folder permissions for cross-platform compatibility';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fixing storage folder permissions...');
        $force = $this->option('force');

        // Pastikan folder storage/app/public ada
        $publicPath = storage_path('app/public');
        if (!file_exists($publicPath)) {
            try {
                mkdir($publicPath, 0777, true);
                $this->info('Created directory: ' . $publicPath);
            } catch (\Exception $e) {
                $this->warn('Tidak dapat membuat direktori: ' . $publicPath);
                $this->warn('Error: ' . $e->getMessage());
            }
        }
        
        try {
            chmod($publicPath, 0777);
            $this->info('Set permissions for: ' . $publicPath);
        } catch (\Exception $e) {
            $this->warn('Tidak dapat mengubah permission folder: ' . $publicPath);
            $this->warn('Error: ' . $e->getMessage());
            
            if (PHP_OS_FAMILY === 'Darwin') { // macOS
                $this->warn('Anda perlu menjalankan perintah berikut secara manual:');
                $this->line('sudo chmod -R 777 ' . storage_path());
            } elseif (PHP_OS_FAMILY === 'Windows') {
                $this->warn('Anda perlu mengatur permission folder secara manual:');
                $this->line('Klik kanan folder storage > Properties > Security > Edit > Add > Everyone > Full Control');
            } else { // Linux
                $this->warn('Anda perlu menjalankan perintah berikut secara manual:');
                $this->line('sudo chmod -R 777 ' . storage_path());
            }
        }

        // Pastikan folder storage/app/public/foods ada
        $foodsPath = storage_path('app/public/foods');
        if (!file_exists($foodsPath)) {
            try {
                mkdir($foodsPath, 0777, true);
                $this->info('Created directory: ' . $foodsPath);
            } catch (\Exception $e) {
                $this->warn('Tidak dapat membuat direktori: ' . $foodsPath);
                $this->warn('Error: ' . $e->getMessage());
            }
        }
        
        try {
            chmod($foodsPath, 0777);
            $this->info('Set permissions for: ' . $foodsPath);
        } catch (\Exception $e) {
            $this->warn('Tidak dapat mengubah permission folder: ' . $foodsPath);
        }

        // Pastikan folder storage/app/public/categories ada
        $categoriesPath = storage_path('app/public/categories');
        if (!file_exists($categoriesPath)) {
            try {
                mkdir($categoriesPath, 0777, true);
                $this->info('Created directory: ' . $categoriesPath);
            } catch (\Exception $e) {
                $this->warn('Tidak dapat membuat direktori: ' . $categoriesPath);
                $this->warn('Error: ' . $e->getMessage());
            }
        }
        
        try {
            chmod($categoriesPath, 0777);
            $this->info('Set permissions for: ' . $categoriesPath);
        } catch (\Exception $e) {
            $this->warn('Tidak dapat mengubah permission folder: ' . $categoriesPath);
        }

        // Atur permission untuk semua file di dalam folder foods
        if (is_dir($foodsPath)) {
            try {
                $files = scandir($foodsPath);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..' && !is_dir($foodsPath . '/' . $file)) {
                        try {
                            chmod($foodsPath . '/' . $file, 0666);
                            $this->line('Set permissions for file: ' . $foodsPath . '/' . $file);
                        } catch (\Exception $e) {
                            // Skip jika tidak bisa mengubah permission file
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->warn('Tidak dapat mengakses folder: ' . $foodsPath);
            }
        }

        // Atur permission untuk semua file di dalam folder categories
        if (is_dir($categoriesPath)) {
            try {
                $files = scandir($categoriesPath);
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..' && !is_dir($categoriesPath . '/' . $file)) {
                        try {
                            chmod($categoriesPath . '/' . $file, 0666);
                            $this->line('Set permissions for file: ' . $categoriesPath . '/' . $file);
                        } catch (\Exception $e) {
                            // Skip jika tidak bisa mengubah permission file
                        }
                    }
                }
            } catch (\Exception $e) {
                $this->warn('Tidak dapat mengakses folder: ' . $categoriesPath);
            }
        }

        // Pastikan symbolic link ada
        $this->info('Checking symbolic link...');
        $publicStoragePath = public_path('storage');
        
        if (!file_exists($publicStoragePath)) {
            $this->call('storage:link');
        } else {
            $this->info('Symbolic link already exists.');
        }

        $this->info('Storage permissions fixed successfully!');
        $this->info('Jika masih ada masalah permission, jalankan perintah berikut:');
        
        if (PHP_OS_FAMILY === 'Darwin') { // macOS
            $this->line('sudo chmod -R 777 ' . storage_path());
        } elseif (PHP_OS_FAMILY === 'Windows') {
            $this->line('icacls ' . storage_path() . ' /grant Everyone:(OI)(CI)F /T');
        } else { // Linux
            $this->line('sudo chmod -R 777 ' . storage_path());
        }

        return Command::SUCCESS;
    }
} 