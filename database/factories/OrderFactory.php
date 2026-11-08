<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
final class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_number' => fake()->numberBetween(100000, 999999),
            'subtotal' => 95,
            'delivery' => 5,
            'total' => 100,
            'shipping_address_id' => Address::factory(),
            'billing_address_id' => Address::factory(),
        ];
    }
}
