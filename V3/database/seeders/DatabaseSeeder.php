<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory(5)->create();

        $categories = json_decode(
            file_get_contents(database_path('seeders/categories.json')),
            true
        );
        $now = now();
        foreach ($categories as &$row) {
            $row['slug'] = Str::slug($row['name']);
            $row['created_at'] = $now;
            $row['updated_at'] = $now;
        }
        unset($row);
        Category::query()->insert($categories);

        $products = json_decode(
            file_get_contents(database_path('seeders/products.json')),
            true
        );
        foreach ($products as $row) {
            Product::query()->create([
                'name' => $row['name'],
                'description' => $row['description'] ?? null,
                'category_id' => $row['category_id'],
                'price' => $row['price'],
                'quantity' => $row['quantity'],
                'image' => $row['image'] ?? null,
                'status' => 'active',
            ]);
        }
    }
}
