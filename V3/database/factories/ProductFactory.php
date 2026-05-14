<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $price = fake()->randomFloat(2, 10, 15000);

        return [
            'name' => fake()->words(4, true),
            'description' => fake()->paragraphs(2, true),
            'category_id' => Category::factory(),
            'price' => $price,
            'compare_at_price' => fake()->boolean(25)
                ? fake()->randomFloat(2, round((float) $price * 1.05, 2), round((float) $price * 1.45, 2))
                : null,
            'quantity' => fake()->numberBetween(0, 500),
            'status' => fake()->randomElement(['active', 'draft', 'archived']),
        ];
    }
}
