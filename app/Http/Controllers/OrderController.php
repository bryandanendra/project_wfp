<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'order_type' => 'required|in:dine_in,take_away',
            'items' => 'required|array',
            'items.*.food_id' => 'required|exists:foods,id',
            'items.*.quantity' => 'required|integer|min:1',
            'table_number' => 'required_if:order_type,dine_in',
            'member_name' => 'required|string|max:255',
            'member_email' => 'nullable|email|max:255',
            'member_phone' => 'nullable|string|max:20',
        ]);

        // Generate unique order number
        $orderNumber = 'ORD-' . Str::random(8);

        // Create or find member
        $memberId = null;
        if ($request->member_name) {
            // Cari member berdasarkan email jika ada dan tidak kosong
            $member = null;
            if ($request->member_email && !empty(trim($request->member_email))) {
                $member = Member::where('email', $request->member_email)->first();
            }
            
            // Jika tidak ditemukan, buat member baru
            if (!$member) {
                $member = Member::create([
                    'name' => $request->member_name,
                    'email' => $request->member_email ? trim($request->member_email) : null,
                    'phone' => $request->member_phone ? trim($request->member_phone) : null,
                    // Password tidak perlu diisi karena sudah nullable
                ]);
            }
            
            $memberId = $member->id;
        }

        // Calculate total amount
        $totalAmount = 0;
        foreach ($request->items as $item) {
            $food = Food::findOrFail($item['food_id']);
            $subtotal = $food->price * $item['quantity'];
            $totalAmount += $subtotal;
        }

        // Create order
        $order = Order::create([
            'member_id' => $memberId,
            'order_number' => $orderNumber,
            'order_type' => $request->order_type,
            'table_number' => $request->table_number,
            'total_amount' => $totalAmount,
            'notes' => $request->notes,
            'status' => 'pending'
        ]);

        // Create order details
        foreach ($request->items as $item) {
            $food = Food::findOrFail($item['food_id']);
            OrderDetail::create([
                'order_id' => $order->id,
                'food_id' => $food->id,
                'quantity' => $item['quantity'],
                'price' => $food->price,
                'subtotal' => $food->price * $item['quantity'],
                'special_instructions' => $item['special_instructions'] ?? null,
                'customization_ingredients' => $item['customization_ingredients'] ?? null,
                'customization_portion_size' => $item['customization_portion_size'] ?? null,
                'customization_allergies' => $item['customization_allergies'] ?? null
            ]);
        }

        // Redirect to payment page
        return redirect()->route('payment.index', ['order_id' => $order->id]);
    }

    public function payment($orderId)
    {
        $order = Order::with(['orderDetails.food', 'member'])->findOrFail($orderId);
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('payment.index', [
            'order' => $order,
            'paymentMethods' => $paymentMethods
        ]);
    }

    public function processPayment(Request $request, $orderId)
    {
        $request->validate([
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        $order = Order::with('member')->findOrFail($orderId);
        $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);
        
        // Generate transaction ID
        $transactionId = 'TRX-' . Str::random(8);
        
        // Handle QRIS payment specifically
        if ($paymentMethod->name === 'QRIS') {
            $transactionId = 'QRIS-' . Str::random(8);
        }

        // Process payment
        // In a real application, you would integrate with a payment gateway here

        // For this demo, we'll just mark the payment as completed
        $payment = $order->payment()->create([
            'payment_method_id' => $paymentMethod->id,
            'amount' => $order->total_amount,
            'transaction_id' => $transactionId,
            'status' => 'completed'
        ]);

        // Update order status
        $order->update(['status' => 'processing']);

        return view('payment.success', [
            'order' => $order,
            'payment' => $payment,
            'showStatusButton' => true
        ]);
    }
}
