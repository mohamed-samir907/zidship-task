<?php

namespace Database\Factories;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShipmentItem>
 */
class ShipmentItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "shipment_id" => Shipment::factory(),
            "title" => fake()->title(),
            "description" => fake()->text(),
            "quantity" => fake()->randomDigitNot(0),
            "weight" => fake()->randomFloat(10, 1),
            "unit" => ["kg", "gm"][rand(0, 1)],
            "price" => fake()->numberBetween(100, 20000),
        ];
    }
}
