<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Appetizer',
                'description' => 'Makanan ringan untuk mengawali hidangan utama',
                'image' => 'categories/appetizer.jpg'
            ],
            [
                'name' => 'Main Course',
                'description' => 'Hidangan utama dengan porsi yang mengenyangkan',
                'image' => 'categories/main-course.jpg'
            ],
            [
                'name' => 'Snacks',
                'description' => 'Makanan ringan untuk dikonsumsi di antara waktu makan',
                'image' => 'categories/snacks.jpg'
            ],
            [
                'name' => 'Dessert',
                'description' => 'Makanan penutup yang manis dan lezat',
                'image' => 'categories/dessert.jpg'
            ],
            [
                'name' => 'Coffee',
                'description' => 'Minuman kopi dengan berbagai variasi',
                'image' => 'categories/coffee.jpg'
            ],
            [
                'name' => 'Non-Coffee',
                'description' => 'Minuman non-kopi yang menyegarkan',
                'image' => 'categories/non-coffee.jpg'
            ],
            [
                'name' => 'Healthy Juice',
                'description' => 'Jus buah dan sayuran segar yang menyehatkan',
                'image' => 'categories/healthy-juice.jpg'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
