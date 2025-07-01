<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::withCount('orders')->get();
        return view('admin.members.index', compact('members'));
    }

    public function show(Member $member)
    {
        $member->load('orders');
        return view('admin.members.show', compact('member'));
    }

    public function mostActive()
    {
        $members = Member::withCount('orders')
                ->orderBy('orders_count', 'desc')
                ->take(10)
                ->get();
        
        return view('admin.members.most_active', compact('members'));
    }

    public function mostPurchases()
    {
        $members = Member::join('orders', 'members.id', '=', 'orders.member_id')
                ->selectRaw('members.*, SUM(orders.total_amount) as total_spent')
                ->groupBy('members.id')
                ->orderBy('total_spent', 'desc')
                ->take(10)
                ->get();
        
        return view('admin.members.most_purchases', compact('members'));
    }

    public function getActive()
    {
        // Mengambil semua member
        $members = Member::all();
        
        // Mengelompokkan member berdasarkan nama dan menggabungkan jumlah pesanan
        $groupedMembers = [];
        foreach ($members as $member) {
            $name = $member->name;
            
            // Hitung jumlah pesanan untuk member ini
            $ordersCount = $member->orders()->count();
            
            // Jika nama sudah ada di array, tambahkan jumlah pesanan
            if (isset($groupedMembers[$name])) {
                $groupedMembers[$name]['orders_count'] += $ordersCount;
            } else {
                // Jika nama belum ada, tambahkan member baru
                $groupedMembers[$name] = [
                    'id' => $member->id,
                    'name' => $name,
                    'email' => $member->email,
                    'phone' => $member->phone,
                    'orders_count' => $ordersCount
                ];
            }
        }
        
        // Konversi ke array dan urutkan berdasarkan orders_count
        $result = array_values($groupedMembers);
        usort($result, function($a, $b) {
            return $b['orders_count'] - $a['orders_count'];
        });
        
        return response()->json($result);
    }
}
