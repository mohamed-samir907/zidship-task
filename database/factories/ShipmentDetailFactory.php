<?php

namespace Database\Factories;

use App\Models\Shipment;
use App\Shipping\Enums\ShipmentDetailsType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShipmentDetail>
 */
class ShipmentDetailFactory extends Factory
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
            "type" => [ShipmentDetailsType::Sender, ShipmentDetailsType::Recipient][rand(0, 1)],
            "name" => fake()->firstName() . " " . fake()->lastName(),
            "phone" => fake()->phoneNumber(),
            "email" => fake()->email(),
            "country" => fake()->countryCode(),
            "state" => null,
            "city" => fake()->city(),
            "postal_code" => fake()->postcode(),
            "address_line1" => fake()->streetAddress(),
            "address_line2" => fake()->streetAddress(),
            "address_line3" => fake()->streetAddress(),
        ];
    }
}
