@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Daftar Pesanan</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-3">
                        <table class="table align-items-center mb-0" id="orders-table">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Pesanan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Pelanggan</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jenis</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Tanggal</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $order->order_number }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">
                                            {{ $order->member ? $order->member->name : 'Tamu' }}
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">
                                            {{ $order->order_type == 'dine_in' ? 'Makan di Tempat' : 'Bawa Pulang' }}
                                            @if($order->order_type == 'dine_in')
                                                <span class="text-xs text-muted">(Meja {{ $order->table_number }})</span>
                                            @endif
                                        </p>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm {{ 
                                            $order->status == 'completed' ? 'bg-success' : 
                                            ($order->status == 'cancelled' ? 'bg-danger' : 
                                            ($order->status == 'processing' ? 'bg-warning' : 'bg-secondary')) 
                                        }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-bold mb-0">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-link text-info text-gradient px-3 mb-0">
                                            <i class="fas fa-eye me-2"></i>Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#orders-table').DataTable({
            order: [[5, 'desc']], // Sort by date (column 5) in descending order
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari pesanan...",
            }
        });
    });
</script>
@endpush 