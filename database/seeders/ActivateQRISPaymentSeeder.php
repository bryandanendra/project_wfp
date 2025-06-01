<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivateQRISPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Aktifkan metode pembayaran QRIS jika sudah ada
        $qris = PaymentMethod::where('name', 'QRIS')->first();
        
        if ($qris) {
            $qris->update([
                'is_active' => true,
                'description' => 'Pembayaran digital menggunakan QRIS, scan dengan aplikasi e-wallet apa saja'
            ]);
        } else {
            // Jika belum ada, buat baru
            PaymentMethod::create([
                'name' => 'QRIS',
                'description' => 'Pembayaran digital menggunakan QRIS, scan dengan aplikasi e-wallet apa saja',
                'is_active' => true
            ]);
        }
    }
}
