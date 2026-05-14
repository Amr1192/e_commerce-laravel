<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 50, 5000);
        $tax = round($subtotal * 0.14, 2);
        $shipping = fake()->randomFloat(2, 0, 150);
        $discount = fake()->randomFloat(2, 0, min(100, $subtotal * 0.1));
        $grand = round($subtotal + $tax + $shipping - $discount, 2);

        return [
            'user_id' => User::factory(),
            'status' => fake()->randomElement(['pending', 'paid', 'processing', 'shipped', 'delivered', 'cancelled']),
            'currency' => 'EGP',
            'subtotal' => $subtotal,
            'tax_total' => $tax,
            'shipping_total' => $shipping,
            'discount_total' => $discount,
            'grand_total' => $grand,
            'notes' => fake()->optional(0.2)->sentence(),
        ];
    }
}
