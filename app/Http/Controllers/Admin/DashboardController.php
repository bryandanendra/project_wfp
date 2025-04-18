<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Food;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik dasar
        $totalOrders = Order::count();
        $totalFoods = Food::count();
        $totalMembers = Member::count();
        $totalCategories = Category::count();

        // Statistik status pesanan
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $processingOrdersCount = Order::where('status', 'processing')->count();
        $completedOrdersCount = Order::where('status', 'completed')->count();
        $cancelledOrdersCount = Order::where('status', 'cancelled')->count();

        // Pesanan terbaru
        $recentOrders = Order::with('member')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Member teraktif
        $activeMembers = Member::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(4)
            ->get();

        // Makanan terpopuler - perbaikan query GROUP BY
        $popularFoods = DB::table('foods')
            ->select('foods.id', 'foods.name', 'foods.description', 'foods.price', 'foods.image', 
                    DB::raw('COUNT(order_details.id) as order_count'))
            ->leftJoin('order_details', 'foods.id', '=', 'order_details.food_id')
            ->groupBy('foods.id', 'foods.name', 'foods.description', 'foods.price', 'foods.image')
            ->orderBy('order_count', 'desc')
            ->take(5)
            ->get();

        // Data untuk grafik kategori - perbaikan query GROUP BY
        $categoriesForChart = DB::table('categories')
            ->select('categories.name', DB::raw('COUNT(order_details.id) as order_count'))
            ->leftJoin('foods', 'categories.id', '=', 'foods.category_id')
            ->leftJoin('order_details', 'foods.id', '=', 'order_details.food_id')
            ->groupBy('categories.name', 'categories.id')
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalFoods',
            'totalMembers',
            'totalCategories',
            'pendingOrdersCount',
            'processingOrdersCount',
            'completedOrdersCount',
            'cancelledOrdersCount',
            'recentOrders',
            'activeMembers',
            'popularFoods',
            'categoriesForChart'
        ));
    }
} 