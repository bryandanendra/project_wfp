<?php

namespace Database\Seeders;

use App\Models\Food;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $foods = [
            [
                'name' => 'Nasi Merah dengan Ayam Panggang Kecap & Tumis Kangkung',
                'description' => 'Nikmati hidangan sehat dan lezat dengan Nasi Merah yang kaya serat, dipadukan dengan Ayam Panggang Kecap yang manis gurih dan Tumis Kangkung yang segar. Kombinasi sempurna untuk santapan yang mengenyangkan dan bergizi.',
                'nutrition_facts' => "Kalori: 450 kkal\nProtein: 35 gram\nLemak: 20 gram\nKarbohidrat: 60 gram\nSerat: 7 gram",
                'price' => 35000,
                'image' => 'foods/nasi-merah-ayam.jpg',
                'category_id' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Salad Bowl dengan Quinoa, Alpukat, dan Potongan Ayam Panggang',
                'description' => 'Salad sehat dan bergizi dengan Quinoa yang kaya protein, alpukat yang kaya akan lemak sehat, dan ayam panggang yang lezat. Disiram dengan saus vinaigrette lemon yang segar.',
                'nutrition_facts' => "Kalori: 380 kkal\nProtein: 25 gram\nLemak: 22 gram\nKarbohidrat: 30 gram\nSerat: 9 gram",
                'price' => 40000,
                'image' => 'foods/salad-bowl-quinoa.jpg',
                'category_id' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Smoothie Bowl Buah Naga dan Pisang',
                'description' => 'Smoothie bowl segar dengan campuran buah naga, pisang, dan tambahan granola serta buah-buahan segar di atasnya. Sarapan sehat yang menyegarkan dan mengenyangkan.',
                'nutrition_facts' => "Kalori: 320 kkal\nProtein: 8 gram\nLemak: 5 gram\nKarbohidrat: 65 gram\nSerat: 12 gram",
                'price' => 30000,
                'image' => 'foods/smoothie-bowl.jpg',
                'category_id' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Green Detox Juice',
                'description' => 'Jus detox hijau dengan campuran apel, mentimun, bayam, dan lemon. Minuman sehat yang menyegarkan dan membantu membersihkan tubuh Anda.',
                'nutrition_facts' => "Kalori: 120 kkal\nProtein: 2 gram\nLemak: 0 gram\nKarbohidrat: 28 gram\nSerat: 4 gram",
                'price' => 25000,
                'image' => 'foods/green-detox-juice.jpg',
                'category_id' => 7,
                'is_active' => true
            ],
            [
                'name' => 'Kopi Hitam Organik',
                'description' => 'Kopi hitam organik dengan biji kopi pilihan yang digiling segar. Nikmati rasa kopi yang kaya dan aroma yang menggoda.',
                'nutrition_facts' => "Kalori: 5 kkal\nProtein: 0 gram\nLemak: 0 gram\nKarbohidrat: 0 gram\nSerat: 0 gram",
                'price' => 20000,
                'image' => 'foods/kopi-hitam-organik.jpg',
                'category_id' => 5,
                'is_active' => true
            ],
        ];

        foreach ($foods as $food) {
            Food::create($food);
        }
    }
}
