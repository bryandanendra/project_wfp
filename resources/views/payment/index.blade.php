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
                                            <br><small class="text-muted">{{ $detail->special_instructions }}</small>
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

                    <form action="{{ route('payment.process', $order->id) }}" method="POST">
                        @csrf
                        <h5 class="mb-3">Pilih Metode Pembayaran</h5>
                        
                        <div class="row">
                            @foreach($paymentMethods as $method)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="payment_method_id" 
                                                id="payment_method_{{ $method->id }}" value="{{ $method->id }}" required
                                                {{ $loop->first ? 'checked' : '' }}>
                                            <label class="form-check-label" for="payment_method_{{ $method->id }}">
                                                <strong>{{ $method->name }}</strong>
                                            </label>
                                        </div>
                                        <p class="small text-muted mt-2">{{ $method->description }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">
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