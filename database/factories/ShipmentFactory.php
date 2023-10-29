<?php

namespace Database\Factories;

use App\Models\Platform;
use App\Models\User;
use App\Shipping\Enums\ShipmentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => User::first(),
            "platform_id" => Platform::first(),
            "ref_number" => fake()->unique()->randomNumber(),
            "shipment_id" => null,
            "status" => ShipmentStatus::Created,
            "cash_on_delivery" => true,
            "pickup_date" => now()->addDays(3),
        ];
    }
}
