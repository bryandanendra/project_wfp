@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('header', 'Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Info boxes -->
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Pesanan</span>
                <span class="info-box-number">{{ $totalOrders }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-utensils"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Menu</span>
                <span class="info-box-number">{{ $totalFoods }}</span>
            </div>
        </div>
    </div>

    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Member</span>
                <span class="info-box-number">{{ $totalMembers }}</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-money-bill-wave"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Omzet</span>
                <span class="info-box-number">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Kategori dan Transaksi -->
<div class="row">
    <div class="col-md-3">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tag"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Kategori</span>
                <span class="info-box-number">{{ $totalCategories }}</span>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <!-- Top Spender -->
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Top Spender</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if($topBuyingMember)
                <div class="text-center mb-2">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($topBuyingMember->name) }}&background=random" class="img-circle elevation-2" alt="Member" style="width: 60px; height: 60px;">
                </div>
                <h5 class="text-center">{{ $topBuyingMember->name }}</h5>
                <p class="text-center text-muted mb-0">Rp {{ number_format($topBuyingMember->total_spent, 0, ',', '.') }}</p>
                @else
                <p class="text-center">Tidak ada data pembelian</p>
                @endif
            </div>
        </div>

        <!-- Pesanan Terbaru -->
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Pesanan Terbaru</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td><a href="{{ route('admin.orders.show', $order->id) }}">{{ $order->order_number }}</a></td>
                                <td>{{ $order->member ? $order->member->name : 'Guest' }}</td>
                                <td>
                                    @if($order->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($order->status == 'processing')
                                        <span class="badge bg-primary">Diproses</span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada pesanan terbaru</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary float-end">Lihat Semua Pesanan</a>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <!-- Member Teraktif -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Member Teraktif</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="users-list clearfix">
                            @foreach($activeMembers as $member)
                            <li>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=random" alt="{{ $member->name }}" class="img-fluid">
                                <a class="users-list-name" href="{{ route('admin.members.show', $member->id) }}">{{ $member->name }}</a>
                                <span class="users-list-date">{{ $member->orders_count }} pesanan</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <button id="showAllMembersBtn" class="btn btn-sm btn-primary">Lihat Semua Member</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Pesanan -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Statistik Pesanan</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <p class="text-success text-sm">
                                <i class="fas fa-check"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    {{ $completedOrdersCount }}
                                </span>
                                <span class="text-muted">Pesanan Selesai</span>
                            </p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                            <p class="text-primary text-sm">
                                <i class="fas fa-sync-alt"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    {{ $processingOrdersCount }}
                                </span>
                                <span class="text-muted">Pesanan Diproses</span>
                            </p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <p class="text-warning text-sm">
                                <i class="fas fa-clock"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    {{ $pendingOrdersCount }}
                                </span>
                                <span class="text-muted">Pesanan Pending</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <!-- Makanan Terpopuler -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Makanan Terlaris</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($popularFoods as $food)
                            <li class="item">
                                <div class="product-img">
                                    @if(isset($food->image) && $food->image)
                                        <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" class="img-size-50">
                                    @else
                                        <img src="https://via.placeholder.com/150" alt="{{ $food->name }}" class="img-size-50">
                                    @endif
                                </div>
                                <div class="product-info">
                                    <a href="{{ route('admin.foods.show', $food->id) }}" class="product-title">
                                        {{ $food->name }}
                                        <span class="badge bg-success float-end">Rp {{ number_format($food->price, 0, ',', '.') }}</span>
                                    </a>
                                    <span class="product-description">
                                        {{ \Illuminate\Support\Str::limit($food->description, 50) }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.foods.index') }}" class="btn btn-sm btn-primary">Lihat Semua Makanan</a>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Produk Perlu Diendorse -->
                <div class="card">
                    <div class="card-header bg-warning">
                        <h3 class="card-title">Perlu Diendorse</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach($productsToEndorse as $food)
                            <li class="item">
                                <div class="product-img">
                                    @if(isset($food->image) && $food->image)
                                        <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" class="img-size-50">
                                    @else
                                        <img src="https://via.placeholder.com/150" alt="{{ $food->name }}" class="img-size-50">
                                    @endif
                                </div>
                                <div class="product-info">
                                    <a href="{{ route('admin.foods.show', $food->id) }}" class="product-title">
                                        {{ $food->name }}
                                        <span class="badge bg-warning float-end">{{ $food->order_count }} terjual</span>
                                    </a>
                                    <span class="product-description">
                                        {{ \Illuminate\Support\Str::limit($food->description, 50) }}
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('admin.foods.index') }}?sort=low_sales" class="btn btn-sm btn-warning">Lihat Semua</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <!-- DONUT CHART -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Distribusi Pesanan</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="orderStatusChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <!-- BAR CHART -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pesanan per Kategori</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <canvas id="categoryOrdersChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal untuk menampilkan semua member -->
<div class="modal fade" id="allMembersModal" tabindex="-1" role="dialog" aria-labelledby="allMembersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="allMembersModalLabel">Semua Member Aktif</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="allMembersContainer">
                    <!-- Data member akan dimuat di sini -->
                    <div class="col-12 text-center">
                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                        <p>Memuat data member...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeModalBtn">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Button untuk menampilkan semua member - hanya satu event listener
        document.getElementById('showAllMembersBtn').addEventListener('click', function() {
            // Modal akan dikelola oleh Bootstrap
            loadAllMembers();
        });

        // Fungsi untuk memuat semua member
        function loadAllMembers() {
            fetch('{{ route('admin.members.get-active') }}')
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('allMembersContainer');
                    container.innerHTML = ''; // Bersihkan kontainer
                    
                    if (data.length === 0) {
                        container.innerHTML = '<div class="col-12 text-center"><p>Tidak ada data member aktif.</p></div>';
                        return;
                    }
                    
                    data.forEach(member => {
                        const memberEl = document.createElement('div');
                        memberEl.className = 'col-md-3 col-sm-6 col-12 mb-3';
                        
                        const imgUrl = `https://ui-avatars.com/api/?name=${encodeURIComponent(member.name)}&background=random`;
                        const memberUrl = '{{ route("admin.members.show", ":id") }}'.replace(':id', member.id);
                        
                        memberEl.innerHTML = `
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <img src="${imgUrl}" alt="${member.name}" class="img-fluid rounded-circle">
                                </span>
                                <div class="info-box-content">
                                    <a href="${memberUrl}" class="info-box-text">${member.name}</a>
                                    <span class="info-box-number">${member.orders_count} pesanan</span>
                                </div>
                            </div>
                        `;
                        container.appendChild(memberEl);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    const container = document.getElementById('allMembersContainer');
                    container.innerHTML = '<div class="col-12 text-center"><p>Gagal memuat data member. Silakan coba lagi.</p></div>';
                });
        }
        
        // Inisialisasi Bootstrap modal
        $(function() {
            // Event handler untuk tombol yang membuka modal
            $('#showAllMembersBtn').on('click', function() {
                var myModal = new bootstrap.Modal(document.getElementById('allMembersModal'));
                myModal.show();
            });
        });

        // Order Status Chart
        var orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
        var orderStatusData = {
            labels: [
                'Pending',
                'Diproses',
                'Selesai',
                'Dibatalkan'
            ],
            datasets: [{
                data: [
                    {{ $pendingOrdersCount }},
                    {{ $processingOrdersCount }},
                    {{ $completedOrdersCount }},
                    {{ $cancelledOrdersCount }}
                ],
                backgroundColor: [
                    '#f39c12',
                    '#00c0ef',
                    '#00a65a',
                    '#f56954'
                ]
            }]
        };
        
        new Chart(orderStatusCtx, {
            type: 'doughnut',
            data: orderStatusData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });

        // Category Orders Chart
        var categoryCtx = document.getElementById('categoryOrdersChart').getContext('2d');
        var categoryData = {
            labels: {!! json_encode($categoriesForChart->pluck('name')) !!},
            datasets: [{
                label: 'Jumlah Pesanan',
                data: {!! json_encode($categoriesForChart->pluck('order_count')) !!},
                backgroundColor: [
                    'rgba(60, 141, 188, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(255, 205, 86, 0.8)',
                ],
                borderColor: [
                    'rgb(60, 141, 188)',
                    'rgb(54, 162, 235)',
                    'rgb(75, 192, 192)',
                    'rgb(153, 102, 255)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                ],
                borderWidth: 1
            }]
        };
        
        new Chart(categoryCtx, {
            type: 'bar',
            data: categoryData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endpush 