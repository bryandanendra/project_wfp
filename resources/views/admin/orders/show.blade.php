@extends('layouts.admin')

@section('title', 'Detail Pesanan')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Detail Pesanan #{{ $order->order_number }}</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm mb-0">Kembali</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-sm text-uppercase text-secondary font-weight-bolder">Informasi Pesanan</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-sm text-secondary">Nomor Pesanan:</span>
                                    <span class="text-sm font-weight-bold ms-2">{{ $order->order_number }}</span>
                                </li>
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-sm text-secondary">Jenis Pesanan:</span>
                                    <span class="text-sm font-weight-bold ms-2">
                                        {{ $order->order_type == 'dine_in' ? 'Makan di Tempat' : 'Bawa Pulang' }}
                                    </span>
                                </li>
                                @if($order->order_type == 'dine_in')
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-sm text-secondary">Nomor Meja:</span>
                                    <span class="text-sm font-weight-bold ms-2">{{ $order->table_number }}</span>
                                </li>
                                @endif
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-sm text-secondary">Tanggal Pesanan:</span>
                                    <span class="text-sm font-weight-bold ms-2">{{ $order->created_at->format('d M Y, H:i') }}</span>
                                </li>
                                @if($order->notes)
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-sm text-secondary">Catatan:</span>
                                    <p class="text-sm font-weight-bold mt-1">{{ $order->notes }}</p>
                                </li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-sm text-uppercase text-secondary font-weight-bolder">Informasi Pelanggan</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-sm text-secondary">Pelanggan:</span>
                                    <span class="text-sm font-weight-bold ms-2">
                                        {{ $order->member ? $order->member->name : 'Tamu' }}
                                    </span>
                                </li>
                                @if($order->member)
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-sm text-secondary">Email:</span>
                                    <span class="text-sm font-weight-bold ms-2">{{ $order->member->email }}</span>
                                </li>
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-sm text-secondary">No. Telepon:</span>
                                    <span class="text-sm font-weight-bold ms-2">{{ $order->member->phone }}</span>
                                </li>
                                @endif
                            </ul>
                            
                            <h6 class="text-sm text-uppercase text-secondary font-weight-bolder mt-4">Informasi Pembayaran</h6>
                            <ul class="list-group list-group-flush">
                                @if($order->payment)
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-sm text-secondary">Metode Pembayaran:</span>
                                    <span class="text-sm font-weight-bold ms-2">{{ $order->payment->paymentMethod->name }}</span>
                                </li>
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-sm text-secondary">Status Pembayaran:</span>
                                    <span class="badge bg-success">{{ ucfirst($order->payment->status) }}</span>
                                </li>
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-sm text-secondary">ID Transaksi:</span>
                                    <span class="text-sm font-weight-bold ms-2">{{ $order->payment->transaction_id }}</span>
                                </li>
                                @else
                                <li class="list-group-item px-0 border-0">
                                    <span class="text-danger">Belum ada informasi pembayaran</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    
                    <!-- Form Update Status -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="card card-body border">
                                <h6 class="text-sm text-uppercase text-secondary font-weight-bolder mb-3">Update Status Pesanan</h6>
                                <form action="{{ route('admin.orders.update.status', $order->id) }}" method="POST" id="updateStatusForm">
                                    @csrf
                                    @method('PATCH')
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="status" class="form-control-label text-sm">Status:</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Sedang Diproses</option>
                                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="d-flex align-items-center h-100">
                                                <span class="badge badge-sm {{ 
                                                    $order->status == 'completed' ? 'bg-success' : 
                                                    ($order->status == 'cancelled' ? 'bg-danger' : 
                                                    ($order->status == 'processing' ? 'bg-warning' : 'bg-secondary')) 
                                                }} me-2">
                                                    Status Saat Ini: {{ ucfirst($order->status) }}
                                                </span>
                                                <span class="text-sm text-muted">(diperbarui: {{ $order->updated_at->diffForHumans() }})</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <button type="submit" class="btn btn-primary btn-sm mb-0">Perbarui Status</button>
                                            <a href="{{ route('order.status', $order->order_number) }}" target="_blank" class="btn btn-info btn-sm mb-0">
                                                <i class="fas fa-eye me-1"></i> Lihat Status Pelanggan
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Detail Item Pesanan -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-sm text-uppercase text-secondary font-weight-bolder mb-3">Item Pesanan</h6>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Harga</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jumlah</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->orderDetails as $detail)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $detail->food->name }}</h6>
                                                        @if($detail->special_instructions)
                                                            <p class="text-xs text-muted mb-0">Instruksi: {{ $detail->special_instructions }}</p>
                                                        @endif
                                                        
                                                        @if($detail->customization_ingredients || $detail->customization_portion_size || $detail->customization_allergies)
                                                            <div class="mt-1">
                                                                <p class="text-xs text-muted mb-0"><strong>Kustomisasi:</strong></p>
                                                                <ul class="mb-0 ps-3 text-xs text-muted">
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
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">{{ $detail->quantity }}</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end">
                                                <p class="text-sm font-weight-bold mb-0">Total:</p>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-bold mb-0">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateStatusForm = document.getElementById('updateStatusForm');
        const statusSelect = document.getElementById('status');
        
        // Confirm before changing to "cancelled" status
        updateStatusForm.addEventListener('submit', function(e) {
            if (statusSelect.value === 'cancelled') {
                if (!confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    });
</script>
@endpush 