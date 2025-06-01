@extends('layouts.app')

@section('title', 'Status Pesanan')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Bagian Status Pesanan -->
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Status Pesanan</h4>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h5>Nomor Pesanan: <span class="text-primary">{{ $order->order_number }}</span></h5>
                        <p class="text-muted small">Tanggal Pemesanan: {{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    <div class="status-timeline mb-4">
                        <div class="row text-center">
                            <div class="col-3">
                                <div class="status-circle {{ $order->status != 'cancelled' ? 'active' : '' }}">1</div>
                                <p class="small mt-2">Pemesanan</p>
                            </div>
                            <div class="col-3">
                                <div class="status-circle {{ in_array($order->status, ['processing', 'completed']) ? 'active' : '' }}">2</div>
                                <p class="small mt-2">Diproses</p>
                            </div>
                            <div class="col-3">
                                <div class="status-circle {{ $order->status == 'completed' ? 'active' : '' }}">3</div>
                                <p class="small mt-2">Siap</p>
                            </div>
                            <div class="col-3">
                                <div class="status-circle {{ $order->status == 'cancelled' ? 'active cancelled' : '' }}">
                                    <i class="fas fa-times"></i>
                                </div>
                                <p class="small mt-2">Dibatalkan</p>
                            </div>
                        </div>
                        <div class="progress mx-auto mt-3" style="height: 4px; width: 80%;">
                            @if($order->status == 'pending')
                                <div class="progress-bar" role="progressbar" style="width: 25%"></div>
                            @elseif($order->status == 'processing')
                                <div class="progress-bar" role="progressbar" style="width: 65%"></div>
                            @elseif($order->status == 'completed')
                                <div class="progress-bar" role="progressbar" style="width: 100%"></div>
                            @elseif($order->status == 'cancelled')
                                <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                            @endif
                        </div>
                    </div>
                    
                    <div id="statusBox" class="alert {{ $order->status == 'completed' ? 'alert-success' : ($order->status == 'cancelled' ? 'alert-danger' : 'alert-info') }} mb-4">
                        <div class="d-flex align-items-center">
                            <div>
                                @if($order->status == 'pending')
                                    <i class="fas fa-clock fa-2x me-3"></i>
                                @elseif($order->status == 'processing')
                                    <i class="fas fa-utensils fa-2x me-3"></i>
                                @elseif($order->status == 'completed')
                                    <i class="fas fa-check-circle fa-2x me-3"></i>
                                @elseif($order->status == 'cancelled')
                                    <i class="fas fa-times-circle fa-2x me-3"></i>
                                @endif
                            </div>
                            <div>
                                <h5 class="alert-heading mb-1">
                                    @if($order->status == 'pending')
                                        Menunggu Konfirmasi
                                    @elseif($order->status == 'processing')
                                        Sedang Diproses
                                    @elseif($order->status == 'completed')
                                        Pesanan Siap
                                    @elseif($order->status == 'cancelled')
                                        Pesanan Dibatalkan
                                    @endif
                                </h5>
                                <p class="mb-0" id="statusMessage">
                                    @if($order->status == 'pending')
                                        Pesanan Anda sedang menunggu konfirmasi.
                                    @elseif($order->status == 'processing')
                                        Pesanan Anda sedang diproses dan sedang dimasak.
                                    @elseif($order->status == 'completed')
                                        Pesanan Anda telah selesai dan siap untuk diambil/disajikan.
                                    @elseif($order->status == 'cancelled')
                                        Pesanan Anda telah dibatalkan.
                                    @endif
                                </p>
                                <p class="small text-muted mt-1" id="lastUpdate">
                                    Terakhir diperbarui: {{ $order->updated_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @if($order->status == 'completed')
                        <div class="alert alert-success text-center">
                            @if($order->order_type == 'dine_in')
                                <p class="mb-0">Pesanan Anda sudah siap dan akan segera diantarkan ke meja {{ $order->table_number }}.</p>
                            @else
                                <p class="mb-0">Pesanan Anda sudah siap! Silakan ambil pesanan Anda di counter.</p>
                            @endif
                        </div>
                    @elseif($order->status == 'processing')
                        <div class="alert alert-warning text-center">
                            <p class="mb-0">Estimasi waktu tunggu: <strong>10-15 menit</strong></p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Ringkasan Pesanan -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Ringkasan Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Menu</th>
                                    <th>Qty</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->orderDetails as $detail)
                                <tr>
                                    <td>
                                        {{ $detail->food->name }}
                                        @if($detail->special_instructions)
                                            <br><small class="text-muted">Instruksi: {{ $detail->special_instructions }}</small>
                                        @endif
                                        
                                        @if($detail->customization_ingredients || $detail->customization_portion_size || $detail->customization_allergies)
                                            <div class="mt-1 small">
                                                <strong>Kustomisasi:</strong>
                                                <ul class="mb-0 ps-3">
                                                    @if($detail->customization_ingredients)
                                                        <li>Bahan: {{ $detail->customization_ingredients }}</li>
                                                    @endif
                                                    @if($detail->customization_portion_size)
                                                        <li>Porsi: {{ $detail->customization_portion_size }}</li>
                                                    @endif
                                                    @if($detail->customization_allergies)
                                                        <li>Alergi: {{ $detail->customization_allergies }}</li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-end">Total:</th>
                                    <th class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6>Informasi Pesanan</h6>
                            <p class="mb-1"><strong>Jenis Pesanan:</strong> {{ $order->order_type == 'dine_in' ? 'Makan di Tempat' : 'Bawa Pulang' }}</p>
                            @if($order->order_type == 'dine_in')
                                <p class="mb-1"><strong>Nomor Meja:</strong> {{ $order->table_number }}</p>
                            @endif
                            @if($order->notes)
                                <p class="mb-1"><strong>Catatan:</strong> {{ $order->notes }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h6>Informasi Pembayaran</h6>
                            @if($order->payment)
                                <p class="mb-1"><strong>Metode Pembayaran:</strong> {{ $order->payment->paymentMethod->name }}</p>
                                <p class="mb-1"><strong>Status Pembayaran:</strong> 
                                    <span class="badge bg-success">{{ ucfirst($order->payment->status) }}</span>
                                </p>
                            @else
                                <p class="text-danger">Belum ada informasi pembayaran</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <a href="{{ route('welcome') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .status-timeline {
        position: relative;
    }
    
    .status-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #e9ecef;
        border: 2px solid #ced4da;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }
    
    .status-circle.active {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }
    
    .status-circle.cancelled {
        background-color: #dc3545;
        border-color: #dc3545;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const orderNumber = '{{ $order->order_number }}';
        const statusBox = document.getElementById('statusBox');
        const statusMessage = document.getElementById('statusMessage');
        const lastUpdate = document.getElementById('lastUpdate');
        let currentStatus = '{{ $order->status }}';
        
        // Fungsi untuk memperbarui status
        function updateOrderStatus() {
            fetch(`/api/order-status/${orderNumber}`)
                .then(response => response.json())
                .then(data => {
                    // Jika status berubah, perbarui tampilan
                    if (data.status !== currentStatus) {
                        location.reload(); // Reload halaman untuk memperbarui timeline dan semua elemen
                    } else {
                        // Jika tidak berubah, hanya perbarui pesan dan waktu
                        statusMessage.textContent = data.status_message;
                        lastUpdate.textContent = `Terakhir diperbarui: ${data.last_update_diff}`;
                    }
                    
                    // Atur status saat ini
                    currentStatus = data.status;
                })
                .catch(error => {
                    console.error('Error fetching order status:', error);
                });
        }
        
        // Perbarui status setiap 30 detik
        const statusInterval = setInterval(updateOrderStatus, 30000);
        
        // Bersihkan interval saat pengguna meninggalkan halaman
        window.addEventListener('beforeunload', function() {
            clearInterval(statusInterval);
        });
        
        // Tampilkan notifikasi jika browser mendukung
        function showStatusNotification(title, message) {
            if ('Notification' in window && Notification.permission === 'granted') {
                new Notification(title, {
                    body: message,
                    icon: '/images/logo.png' // pastikan file logo ada
                });
            }
        }
        
        // Minta izin notifikasi
        if ('Notification' in window && Notification.permission !== 'denied') {
            Notification.requestPermission();
        }
    });
</script>
@endpush 