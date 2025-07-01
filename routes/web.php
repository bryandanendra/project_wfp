<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FoodController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// User 
Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/before_order', [HomeController::class, 'beforeOrder'])->name('before.order');

// Menu 
Route::get('/menu/{type}', [MenuController::class, 'index'])->name('menu.index');

// Order 
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/payment/{order_id}', [OrderController::class, 'payment'])->name('payment.index');
Route::post('/payment/{order_id}', [OrderController::class, 'processPayment'])->name('payment.process');

// Order Status
Route::get('/order-status/{order_number}', [OrderStatusController::class, 'show'])->name('order.status');
Route::get('/api/order-status/{order_number}', [OrderStatusController::class, 'getStatus'])->name('api.order.status');

// Admin 
Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\EnsureStoragePermissions::class)->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Categories
    Route::resource('categories', CategoryController::class);
    
    // Foods
    Route::resource('foods', FoodController::class);
    
    // Orders
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update.status');
    
    // Members
    Route::get('members', [MemberController::class, 'index'])->name('members.index');
    Route::get('members/get/active', [MemberController::class, 'getActive'])->name('members.get-active');
    Route::get('members/reports/most-active', [MemberController::class, 'mostActive'])->name('members.most-active');
    Route::get('members/reports/most-purchases', [MemberController::class, 'mostPurchases'])->name('members.most-purchases');
    Route::get('members/{member}', [MemberController::class, 'show'])->name('members.show');
});

// Route untuk memperbaiki permission storage (hanya untuk development)
if (app()->environment('local', 'development')) {
    Route::get('/fix-storage-permissions', function () {
        try {
            \Artisan::call('storage:fix-permissions');
            return 'Storage permissions fixed successfully! <a href="/">Back to home</a>';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage() . '<br>Try running these commands manually:<br>
                <code>sudo chmod -R 777 ' . storage_path() . '</code><br>
                <code>php artisan storage:link</code><br>
                <a href="/">Back to home</a>';
        }
    })->name('fix.storage');
    
    // Route khusus untuk memperbaiki storage path error
    Route::get('/fix-storage-path', function () {
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
            if (!file_exists($publicStoragePath)) {
                \Artisan::call('storage:link');
            }
            
            return 'Storage paths fixed successfully! <a href="/admin/orders">Back to admin orders</a>';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage() . '<br>Try running these commands manually:<br>
                <code>php artisan storage:link</code><br>
                <a href="/">Back to home</a>';
        }
    })->name('fix.storage.path');
}
