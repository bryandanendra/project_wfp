<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class OrderStatusController extends Controller
{
    /**
     * Menampilkan halaman status pesanan
     */
    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with(['orderDetails.food', 'payment.paymentMethod'])
            ->firstOrFail();
            
        return view('order_status.show', compact('order'));
    }
    
    /**
     * API untuk mendapatkan status pesanan saat ini
     */
    public function getStatus($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->select('id', 'order_number', 'status', 'updated_at')
            ->firstOrFail();
            
        $statusMessage = $this->getStatusMessage($order->status);
        
        return response()->json([
            'order_number' => $order->order_number,
            'status' => $order->status,
            'status_message' => $statusMessage,
            'last_update' => $order->updated_at->format('d M Y, H:i:s'),
            'last_update_diff' => $order->updated_at->diffForHumans(),
        ]);
    }
    
    /**
     * Mendapatkan pesan status sesuai dengan kode status
     */
    private function getStatusMessage($status)
    {
        switch ($status) {
            case 'pending':
                return 'Pesanan Anda sedang menunggu konfirmasi.';
            case 'processing':
                return 'Pesanan Anda sedang diproses dan sedang dimasak.';
            case 'completed':
                return 'Pesanan Anda telah selesai dan siap untuk diambil/disajikan.';
            case 'cancelled':
                return 'Pesanan Anda telah dibatalkan.';
            default:
                return 'Status pesanan tidak diketahui.';
        }
    }
}
