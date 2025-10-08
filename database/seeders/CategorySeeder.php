<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => "Men's Shoes", 'description' => 'Casual, formal and sports shoes for men'],
            ['name' => "Women's Shoes", 'description' => 'Trendy and comfortable shoes for women'],
            ['name' => "Kids' Shoes", 'description' => 'Colorful and durable shoes for kids'],
            ['name' => "Sports Shoes", 'description' => 'Performance sports shoes for all activities'],
            ['name' => "Formal Shoes", 'description' => 'Elegant formal footwear'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(
                ['name' => $cat['name']], // check by name
                ['description' => $cat['description']]
            );
        }
    }
}
