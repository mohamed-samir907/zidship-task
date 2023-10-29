<?php

namespace App\Shipping\Factories;

use App\Shipping\DTOs\ShipmentDTO;
use App\Shipping\DTOs\ShipmentItemDTO;
use App\Shipping\Enums\ShipmentStatus;
use App\Shipping\DTOs\ShipmentDetailDTO;
use App\Shipping\Enums\ShipmentDetailsType;

class ShipmentDTOFactory
{
    public static function createShipmentDTO(array $data): ShipmentDTO
    {
        $sender = self::createShipmentDetailDTO(ShipmentDetailsType::Sender, $data["sender"]);
        $recipient = self::createShipmentDetailDTO(ShipmentDetailsType::Recipient, $data["recipient"]);
        $items = [];

        foreach ($data["items"] as $item) {
            $items[] = self::createShipmentItemDTO($item);
        }

        return new ShipmentDTO(
            userId: $data["user_id"],
            platformId: $data["platform_id"],
            refNumber: $data["ref_number"],
            shipmentId: null,
            status: ShipmentStatus::Draft,
            cod: $data["cod"],
            pickupDate: $data["pickup_date"],
            sender: $sender,
            recipient: $recipient,
            items: $items,
        );
    }

    public static function createShipmentDetailDTO(
        ShipmentDetailsType $type,
        array $data
    ): ShipmentDetailDTO {
        return new ShipmentDetailDTO(
            type: $type,
            name: $data["name"],
            phone: $data["phone"],
            email: $data["email"] ?? null,
            country: $data["country"],
            state: $data["state"] ?? null,
            city: $data["city"],
            postalCode: $data["postal_code"] ?? null,
            addressLine1: $data["address_line1"],
            addressLine2: $data["address_line2"] ?? null,
            addressLine3: $data["address_line2"] ?? null,
        );
    }

    public static function createShipmentItemDTO(array $data): ShipmentItemDTO
    {
        return new ShipmentItemDTO(
            title: $data["title"],
            description: $data["description"] ?? null,
            quantity: $data["quantity"],
            weight: $data["weight"],
            unit: $data["unit"],
            price: $data["price"],
        );
    }
}
