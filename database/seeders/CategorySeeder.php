<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'slug' => 'elektronik',
                'description' => 'Perangkat elektronik seperti smartphone, laptop, dan gadget lainnya',
                'is_active' => true,
            ],
            [
                'name' => 'Fashion Pria',
                'slug' => 'fashion-pria',
                'description' => 'Pakaian, sepatu, dan aksesoris untuk pria',
                'is_active' => true,
            ],
            [
                'name' => 'Fashion Wanita',
                'slug' => 'fashion-wanita',
                'description' => 'Pakaian, sepatu, dan aksesoris untuk wanita',
                'is_active' => true,
            ],
            [
                'name' => 'Makanan & Minuman',
                'slug' => 'makanan-minuman',
                'description' => 'Berbagai makanan ringan, minuman, dan bahan makanan',
                'is_active' => true,
            ],
            [
                'name' => 'Kesehatan & Kecantikan',
                'slug' => 'kesehatan-kecantikan',
                'description' => 'Produk kesehatan, skincare, dan kosmetik',
                'is_active' => true,
            ],
            [
                'name' => 'Rumah Tangga',
                'slug' => 'rumah-tangga',
                'description' => 'Peralatan rumah tangga dan dekorasi',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ Categories seeded successfully!');
    }
}
