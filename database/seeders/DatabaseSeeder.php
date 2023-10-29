<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Platform;
use App\Models\Shipment;
use App\Models\ShipmentDetail;
use App\Models\ShipmentItem;
use App\Models\User;
use App\Shipping\Enums\ShipmentDetailsType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Mohamed Samir',
            'email' => 'gm.mohamedsamir@gmail.com',
        ]);

        $platform = Platform::query()->create([
            "name" => "KwickBox",
            "key" => "kwickbox"
        ]);

        $shipment = Shipment::factory()
            ->has(ShipmentItem::factory(), "items")
            ->create([
                "user_id" => $user->id,
                "platform_id" => $platform->id,
            ]);

        ShipmentDetail::factory()->create([
            "shipment_id" => $shipment,
            "type" => ShipmentDetailsType::Sender,
        ]);

        ShipmentDetail::factory()->create([
            "shipment_id" => $shipment,
            "type" => ShipmentDetailsType::Recipient,
        ]);
    }
}
