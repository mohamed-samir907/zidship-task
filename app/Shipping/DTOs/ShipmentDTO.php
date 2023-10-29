<?php

namespace App\Shipping\DTOs;

use App\Shipping\DTOs\ShipmentItemDTO;
use App\Shipping\Enums\ShipmentStatus;
use App\Shipping\Interfaces\DTOInterface;

readonly class ShipmentDTO implements DTOInterface
{
    /**
     * @param ShipmentItemDTO[] $items
     */
    public function __construct(
        public int $userId,
        public int $platformId,
        public ShipmentStatus $status,
        public bool $cod,
        public string $pickupDate,
        public ShipmentDetailDTO $sender,
        public ShipmentDetailDTO $recipient,
        public array $items,
        public ?string $refNumber = null,
        public ?string $shipmentId = null,
    ) {
    }

    public function toDatabase(): array
    {
        return [
            "user_id"           => $this->userId,
            "platform_id"       => $this->platformId,
            "ref_number"        => $this->refNumber,
            "shipment_id"       => $this->shipmentId,
            "status"            => $this->status->value,
            "cash_on_delivery"  => $this->cod,
            "pickup_date"       => $this->pickupDate,
        ];
    }
}
