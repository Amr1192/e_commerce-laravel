<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
        'name' => fake()->name(),
        'description' => fake()->text(),
        'category_id'=> Category::factory(),
        'price' => fake()->numberBetween(1,10000),
        'quantity' => fake()->numberBetween(1,100),
        ];
        
    }
}
