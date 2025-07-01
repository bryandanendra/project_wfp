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
            ->take(9)
            ->get();

        // Member teraktif
        $activeMembers = Member::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(4)
            ->get();

        // Member teraktif - menggabungkan berdasarkan nama
        $allMembers = Member::all();
        $groupedMembers = [];
        
        foreach ($allMembers as $member) {
            $name = $member->name;
            // Hitung jumlah pesanan untuk member ini
            $ordersCount = $member->orders()->count();
            
            if (isset($groupedMembers[$name])) {
                $groupedMembers[$name]['orders_count'] += $ordersCount;
            } else {
                $groupedMembers[$name] = [
                    'id' => $member->id,
                    'name' => $name,
                    'email' => $member->email,
                    'phone' => $member->phone,
                    'orders_count' => $ordersCount,
                    'model' => $member
                ];
            }
        }
        
        // Urutkan berdasarkan jumlah pesanan terbanyak
        uasort($groupedMembers, function($a, $b) {
            return $b['orders_count'] - $a['orders_count'];
        });
        
        // Ambil 4 member teraktif
        $activeMembers = collect(array_slice($groupedMembers, 0, 4))->map(function($item) {
            $member = $item['model'];
            $member->orders_count = $item['orders_count'];
            return $member;
        });
        
        // Member dengan transaksi terbanyak untuk card utama
        $mostTransactionsMember = null;
        if (!empty($groupedMembers)) {
            $firstMember = reset($groupedMembers);
            $mostTransactionsMember = $firstMember['model'];
            $mostTransactionsMember->orders_count = $firstMember['orders_count'];
        }

        // Member dengan total pembelian terbanyak
        $topBuyingMember = DB::table('members')
            ->select('members.id', 'members.name', 'members.email', DB::raw('SUM(orders.total_amount) as total_spent'))
            ->join('orders', 'members.id', '=', 'orders.member_id')
            ->where('orders.status', 'completed')
            ->groupBy('members.id', 'members.name', 'members.email')
            ->orderBy('total_spent', 'desc')
            ->first();
            
        // Total omzet
        $totalRevenue = DB::table('orders')
            ->where('status', 'completed')
            ->sum('total_amount');
            
        // Makanan terpopuler - perbaikan query GROUP BY
        $popularFoods = DB::table('foods')
            ->select('foods.id', 'foods.name', 'foods.description', 'foods.price', 'foods.image', 
                    DB::raw('COUNT(order_details.id) as order_count'))
            ->leftJoin('order_details', 'foods.id', '=', 'order_details.food_id')
            ->groupBy('foods.id', 'foods.name', 'foods.description', 'foods.price', 'foods.image')
            ->orderBy('order_count', 'desc')
            ->take(3)
            ->get();
            
        // Produk yang perlu diendorse (produk dengan penjualan rendah tetapi potensial)
        $productsToEndorse = DB::table('foods')
            ->select('foods.id', 'foods.name', 'foods.description', 'foods.price', 'foods.image', 
                    DB::raw('COUNT(order_details.id) as order_count'))
            ->leftJoin('order_details', 'foods.id', '=', 'order_details.food_id')
            ->groupBy('foods.id', 'foods.name', 'foods.description', 'foods.price', 'foods.image')
            ->havingRaw('COUNT(order_details.id) > 0')
            ->orderBy('order_count', 'asc')
            ->take(3)
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
            'categoriesForChart',
            'topBuyingMember',
            'mostTransactionsMember',
            'totalRevenue',
            'productsToEndorse'
        ));
    }
} 