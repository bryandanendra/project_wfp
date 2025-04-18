<?php

namespace App\Http\Controllers;

use App\Models\Food;
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
        ]);

        // Generate unique order number
        $orderNumber = 'ORD-' . Str::random(8);

        // Calculate total amount
        $totalAmount = 0;
        foreach ($request->items as $item) {
            $food = Food::findOrFail($item['food_id']);
            $subtotal = $food->price * $item['quantity'];
            $totalAmount += $subtotal;
        }

        // Create order
        $order = Order::create([
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
                'special_instructions' => $item['special_instructions'] ?? null
            ]);
        }

        // Redirect to payment page
        return redirect()->route('payment.index', ['order_id' => $order->id]);
    }

    public function payment($orderId)
    {
        $order = Order::with('orderDetails.food')->findOrFail($orderId);
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

        $order = Order::findOrFail($orderId);
        $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);

        // Process payment
        // In a real application, you would integrate with a payment gateway here

        // For this demo, we'll just mark the payment as completed
        $payment = $order->payment()->create([
            'payment_method_id' => $paymentMethod->id,
            'amount' => $order->total_amount,
            'transaction_id' => 'TRX-' . Str::random(8),
            'status' => 'completed'
        ]);

        // Update order status
        $order->update(['status' => 'processing']);

        return view('payment.success', [
            'order' => $order,
            'payment' => $payment
        ]);
    }
}
