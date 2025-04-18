@extends('layouts.app')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow text-center">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success fa-5x"></i>
                    </div>
                    <h2 class="mb-4">Pembayaran Berhasil!</h2>
                    <p class="lead mb-4">Terima kasih atas pesanan Anda. Pesanan Anda sedang diproses.</p>
                    
                    <div class="card mb-4 bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Detail Pesanan</h5>
                            <p><strong>Nomor Pesanan:</strong> {{ $order->order_number }}</p>
                            <p><strong>Total Pembayaran:</strong> Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            <p><strong>Status:</strong> <span class="badge bg-warning">{{ ucfirst($order->status) }}</span></p>
                            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="card mb-4 bg-light">
                        <div class="card-body">
                            <h5 class="card-title">Detail Pembayaran</h5>
                            <p><strong>Metode Pembayaran:</strong> {{ $payment->paymentMethod->name }}</p>
                            <p><strong>ID Transaksi:</strong> {{ $payment->transaction_id }}</p>
                            <p><strong>Status Pembayaran:</strong> <span class="badge bg-success">{{ ucfirst($payment->status) }}</span></p>
                        </div>
                    </div>
                    
                    <div class="alert alert-info">
                        <p class="mb-0">Silakan tunjukkan nomor pesanan ini ke kasir untuk pengambilan pesanan Anda.</p>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('welcome') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 