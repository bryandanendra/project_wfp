@extends('layouts.app')

@section('title', 'Pilih Jenis Pesanan')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center mb-4">Pilih Jenis Pesanan</h2>
            <div class="row mt-4">
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-utensils fa-4x my-3 text-primary"></i>
                            <h3 class="card-title">Makan di Tempat</h3>
                            <p class="card-text">Nikmati makanan langsung di restoran kami dengan pelayanan yang nyaman</p>
                            <a href="{{ route('menu.index', 'dinein') }}" class="btn btn-primary mt-3">Pilih</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="card h-100 shadow hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-shopping-bag fa-4x my-3 text-primary"></i>
                            <h3 class="card-title">Bawa Pulang</h3>
                            <p class="card-text">Pesan makanan untuk dibawa pulang dan nikmati di rumah atau tempat lain</p>
                            <a href="{{ route('menu.index', 'takeaway') }}" class="btn btn-primary mt-3">Pilih</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 