@extends('layouts.admin')

@section('title', 'Detail Makanan')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-6 d-flex align-items-center">
                            <h6 class="mb-0">Detail Menu Makanan</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a href="{{ route('admin.foods.index') }}" class="btn btn-outline-secondary btn-sm mb-0">Kembali</a>
                            <a href="{{ route('admin.foods.edit', $food->id) }}" class="btn btn-primary btn-sm mb-0">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if($food->image)
                                <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" class="img-fluid rounded shadow" style="max-height: 250px; max-width: 100%; object-fit: contain;">
                            @else
                                <div class="bg-light p-5 rounded d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <i class="fas fa-utensils fa-5x text-muted"></i>
                                </div>
                            @endif
                            
                            <div class="mt-3">
                                <span class="badge {{ $food->is_active ? 'bg-gradient-success' : 'bg-gradient-secondary' }} mb-2">
                                    {{ $food->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                                <p class="mb-1">
                                    <strong>Kategori:</strong> {{ $food->category->name }}
                                </p>
                                <p class="mb-1">
                                    <strong>Harga:</strong> Rp {{ number_format($food->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <h3>{{ $food->name }}</h3>
                            
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Deskripsi</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $food->description }}</p>
                                </div>
                            </div>
                            
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Informasi Nutrisi</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0">{{ $food->nutrition_facts }}</p>
                                </div>
                            </div>
                            
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Informasi Tambahan</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>ID:</strong> {{ $food->id }}</p>
                                            <p class="mb-1"><strong>Dibuat pada:</strong> {{ $food->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-1"><strong>Diperbarui pada:</strong> {{ $food->updated_at->format('d M Y, H:i') }}</p>
                                            <p class="mb-1">
                                                <strong>Status Tampil:</strong> 
                                                <span class="{{ $food->is_active ? 'text-success' : 'text-muted' }}">
                                                    {{ $food->is_active ? 'Ditampilkan di menu' : 'Tidak ditampilkan di menu' }}
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 