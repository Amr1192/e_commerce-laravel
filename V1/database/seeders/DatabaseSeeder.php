<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();

        $categories = json_decode(file_get_contents(database_path('seeders/categories.json')),true);
         Category::insert($categories);

    $products = json_decode(file_get_contents(database_path('seeders/products.json')), true);
    Product::insert($products);
    
    }
}
