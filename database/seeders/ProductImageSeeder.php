<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            if ($product->images()->exists()) {
                continue;
            }

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => 'images/placeholder.svg',
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }
    }
}
