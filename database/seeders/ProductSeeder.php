<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // Category 1: Men
            [
                'category_id' => 1,
                'name' => 'Nike Air Zoom Pegasus 39',
                'brand' => 'Nike',
                'description' => 'Lightweight running shoes with responsive cushioning.',
                'price' => 7999.00,
                'stock' => 20,
                'images' => ['nike_pegasus.jpg'],
            ],
            [
                'category_id' => 1,
                'name' => 'Adidas Ultraboost 22',
                'brand' => 'Adidas',
                'description' => 'High-performance running shoes with energy return.',
                'price' => 8999.00,
                'stock' => 15,
                'images' => ['adidas_ultraboost.jpg'],
            ],
            [
                'category_id' => 1,
                'name' => 'Puma RS-X',
                'brand' => 'Puma',
                'description' => 'Chunky sneakers with a bold design.',
                'price' => 6999.00,
                'stock' => 25,
                'images' => ['puma_rsx.jpg'],
            ],
            [
                'category_id' => 1,
                'name' => 'Reebok Zig Kinetica',
                'brand' => 'Reebok',
                'description' => 'Stylish sports shoes with energy return cushioning.',
                'price' => 7499.00,
                'stock' => 18,
                'images' => ['reebok_zig.jpg'],
            ],
            [
                'category_id' => 1,
                'name' => 'Under Armour Charged Pursuit',
                'brand' => 'Under Armour',
                'description' => 'Breathable lightweight shoes for running.',
                'price' => 5999.00,
                'stock' => 12,
                'images' => ['ua_charged.jpg'],
            ],

            // ... repeat same structure for Women, Sports, Formal etc.
        ];

        foreach ($products as $productData) {
            $images = $productData['images'];
            unset($productData['images']); // remove images before inserting

            $productData['created_at'] = now();
            $productData['updated_at'] = now();

            // Insert product and get its ID
            $productId = DB::table('products')->insertGetId($productData);

            // Insert each image into product_images table
            foreach ($images as $img) {
                DB::table('product_images')->insert([
                    'product_id' => $productId,
                    'image' => $img,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
