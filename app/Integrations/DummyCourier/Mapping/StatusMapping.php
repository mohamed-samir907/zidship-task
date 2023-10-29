<?php

namespace App\Integrations\DummyCourier\Mapping;

use App\Shipping\Enums\ShipmentStatus;

final class StatusMapping
{
    public function get(string $status): ShipmentStatus
    {
        return match ($status) {
            "Created"               => ShipmentStatus::Created,
            "AssignedForPickup"     => ShipmentStatus::AssignedForPickup,
            "PickedUp"              => ShipmentStatus::PickedUp,
            "PickupFailed"          => ShipmentStatus::PickupFailed,
            "Received"              => ShipmentStatus::Received,
            "AssignedForDelivery"   => ShipmentStatus::AssignedForDelivery,
            "CalledConsignee"       => ShipmentStatus::CalledRecipient,
            "Delivered"             => ShipmentStatus::Delivered,
            "ReturnedToCustomer"    => ShipmentStatus::ReturnedToCustomer,
            "CodCollected"          => ShipmentStatus::CodCollected,
            "Canceled"              => ShipmentStatus::Canceled,
            default                 => ShipmentStatus::Unknown,
        };
    }
}
