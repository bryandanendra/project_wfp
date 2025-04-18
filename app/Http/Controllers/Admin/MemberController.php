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
}
