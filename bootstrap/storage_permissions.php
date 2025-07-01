<?php

/**
 * File ini akan dijalankan saat aplikasi dimulai untuk memastikan folder storage memiliki permission yang benar
 */

// PENTING: Jangan gunakan helper Laravel karena aplikasi belum sepenuhnya dimuat
$basePath = dirname(__DIR__);

// Fungsi untuk membuat folder jika belum ada dan mengatur permission
function ensureDirectoryExists($path) {
    if (!file_exists($path)) {
        @mkdir($path, 0777, true);
    }
    @chmod($path, 0777);
}

// Pastikan folder storage/app/public ada
$publicPath = $basePath . '/storage/app/public';
ensureDirectoryExists($publicPath);

// Pastikan folder storage/app/public/foods ada
$foodsPath = $basePath . '/storage/app/public/foods';
ensureDirectoryExists($foodsPath);

// Pastikan folder storage/app/public/categories ada
$categoriesPath = $basePath . '/storage/app/public/categories';
ensureDirectoryExists($categoriesPath);

// Pastikan symbolic link ada - CATATAN: Tidak membuat symlink di bootstrap karena memerlukan helper Laravel
// Symlink akan dibuat oleh middleware EnsureStoragePermissions 