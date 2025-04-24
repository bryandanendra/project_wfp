<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
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

// Admin 
Route::prefix('admin')->name('admin.')->group(function () {
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
    Route::get('members/{member}', [MemberController::class, 'show'])->name('members.show');
    Route::get('members/reports/most-active', [MemberController::class, 'mostActive'])->name('members.most-active');
    Route::get('members/reports/most-purchases', [MemberController::class, 'mostPurchases'])->name('members.most-purchases');
});
