@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="display-4 fw-bold">Self-Ordering for Healthy Food</h1>
            <p class="lead">Nikmati makanan sehat dengan layanan pesan mandiri yang cepat dan nyaman.</p>
            <p>Kami menyediakan berbagai pilihan makanan sehat dengan informasi nutrisi lengkap, memudahkan Anda menjaga pola makan sehat.</p>
            <a href="{{ route('before.order') }}" class="btn btn-primary btn-lg mt-3">Pesan Sekarang</a>
                </div>
        <div class="col-md-6">
            <img src="https://images.unsplash.com/photo-1498837167922-ddd27525d352" class="img-fluid rounded shadow" alt="Healthy Food">
        </div>
    </div>
</div>
@endsection
