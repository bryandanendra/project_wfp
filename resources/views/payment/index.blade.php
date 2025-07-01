@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Pembayaran Pesanan</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Detail Pesanan</h5>
                            <p><strong>Nomor Pesanan:</strong> {{ $order->order_number }}</p>
                            <p><strong>Jenis Pesanan:</strong> 
                                {{ $order->order_type == 'dine_in' ? 'Makan di Tempat' : 'Bawa Pulang' }}
                            </p>
                            @if($order->order_type == 'dine_in')
                                <p><strong>Nomor Meja:</strong> {{ $order->table_number }}</p>
                            @endif
                            @if($order->notes)
                                <p><strong>Catatan:</strong> {{ $order->notes }}</p>
                            @endif
                            @if($order->member)
                                <div class="mt-3 pt-2 border-top">
                                    <h5><i class="fas fa-user-circle me-2 text-primary"></i>Informasi Member</h5>
                                    <p class="mb-1"><strong>Nama:</strong> {{ $order->member->name }}</p>
                                    @if($order->member->email)
                                        <p class="mb-1"><strong>Email:</strong> {{ $order->member->email }}</p>
                                    @endif
                                    @if($order->member->phone)
                                        <p class="mb-1"><strong>Telepon:</strong> {{ $order->member->phone }}</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6 text-md-end">
                            <h5>Total Pembayaran</h5>
                            <h3 class="text-primary">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h3>
                        </div>
                    </div>

                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Menu</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
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
                                    <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td>{{ $detail->quantity }}</td>
                                    <td class="text-end">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th class="text-end">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <form action="{{ route('payment.process', $order->id) }}" method="POST" id="paymentForm">
                        @csrf
                        <h5 class="mb-3">Pilih Metode Pembayaran</h5>
                        
                        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                            @foreach($paymentMethods as $method)
                            <div class="col">
                                <div class="card h-100 payment-card">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="form-check w-100">
                                            <input class="form-check-input payment-method-radio" type="radio" name="payment_method_id" 
                                                id="payment_method_{{ $method->id }}" value="{{ $method->id }}" required
                                                data-method="{{ $method->name }}"
                                                {{ $loop->first ? 'checked' : '' }}>
                                            <label class="form-check-label d-block py-2" for="payment_method_{{ $method->id }}">
                                                <strong>{{ $method->name }}</strong>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- QRIS Payment Section -->
                        <div id="qrisPaymentSection" class="mt-4 text-center" style="display: none;">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Scan QRIS untuk Membayar</h5>
                                    <div class="mb-3">
                                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=https://www.example.com/pay/{{ $order->order_number }}" 
                                            alt="QRIS Code" class="img-fluid" style="max-width: 200px;">
                                    </div>
                                    <p class="text-muted mb-0">Scan QR code di atas menggunakan aplikasi e-wallet atau mobile banking anda.</p>
                                    <p class="text-muted mb-3">Jumlah yang harus dibayar: <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></p>
                                    <div class="alert alert-info mb-0">
                                        <small><i class="fas fa-info-circle me-1"></i> Setelah melakukan pembayaran, klik tombol "Saya Sudah Bayar" di bawah.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary" id="payButton">
                                <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('menu.index', $order->order_type == 'dine_in' ? 'dinein' : 'takeaway') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Menu
                </a>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .payment-card {
        transition: all 0.2s ease;
        cursor: pointer;
        border: 1px solid #dee2e6;
    }
    
    .payment-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    
    .payment-method-radio:checked + .form-check-label {
        font-weight: bold;
        color: #0d6efd;
    }
    
    .payment-method-radio:checked ~ .payment-card {
        border-color: #0d6efd;
        box-shadow: 0 0 0 1px #0d6efd;
    }
    
    /* Improve touchable area for mobile */
    .form-check-label {
        cursor: pointer;
        padding: 0.5rem 0;
        width: 100%;
    }

    @media (max-width: 576px) {
        .form-check-label {
            padding: 0.75rem 0;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dapatkan elemen-elemen yang diperlukan
        const paymentMethodRadios = document.querySelectorAll('.payment-method-radio');
        const qrisPaymentSection = document.getElementById('qrisPaymentSection');
        const payButton = document.getElementById('payButton');
        const paymentForm = document.getElementById('paymentForm');
        
        // Fungsi untuk menampilkan/menyembunyikan section QRIS berdasarkan metode pembayaran yang dipilih
        function toggleQRISSection() {
            const selectedMethod = document.querySelector('.payment-method-radio:checked');
            
            if (selectedMethod && selectedMethod.dataset.method === 'QRIS') {
                qrisPaymentSection.style.display = 'block';
                payButton.innerHTML = '<i class="fas fa-check-circle me-2"></i>Saya Sudah Bayar';
            } else {
                qrisPaymentSection.style.display = 'none';
                payButton.innerHTML = '<i class="fas fa-credit-card me-2"></i>Bayar Sekarang';
            }
        }
        
        // Cek metode pembayaran saat halaman dimuat
        toggleQRISSection();
        
        // Tambahkan event listener untuk radio button
        paymentMethodRadios.forEach(radio => {
            radio.addEventListener('change', toggleQRISSection);
        });
        
        // Tambahkan event listener untuk kartu pembayaran
        document.querySelectorAll('.payment-card').forEach(card => {
            card.addEventListener('click', function() {
                const radio = this.querySelector('.payment-method-radio');
                if (radio) {
                    radio.checked = true;
                    toggleQRISSection();
                }
            });
        });
    });
</script>
@endpush 