<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentMethods = [
            [
                'name' => 'Kartu Kredit',
                'description' => 'Pembayaran menggunakan kartu kredit',
                'is_active' => true
            ],
            [
                'name' => 'Kartu Debit',
                'description' => 'Pembayaran menggunakan kartu debit',
                'is_active' => true
            ],
            [
                'name' => 'GoPay',
                'description' => 'Pembayaran menggunakan dompet digital GoPay',
                'is_active' => true
            ],
            [
                'name' => 'OVO',
                'description' => 'Pembayaran menggunakan dompet digital OVO',
                'is_active' => true
            ],
            [
                'name' => 'Dana',
                'description' => 'Pembayaran menggunakan dompet digital Dana',
                'is_active' => true
            ],
            [
                'name' => 'ShopeePay',
                'description' => 'Pembayaran menggunakan dompet digital ShopeePay',
                'is_active' => true
            ],
            [
                'name' => 'QRIS',
                'description' => 'Pembayaran menggunakan QRIS',
                'is_active' => false
            ]
        ];

        foreach ($paymentMethods as $method) {
            PaymentMethod::create($method);
        }
    }
}
