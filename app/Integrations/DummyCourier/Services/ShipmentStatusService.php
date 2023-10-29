<?php

namespace App\Integrations\DummyCourier\Services;

use App\Models\Shipment;
use App\Shipping\Enums\ShipmentStatus;
use App\Shipping\Interfaces\ShipmentStatusInterface;
use App\Integrations\DummyCourier\Mapping\StatusMapping;

class ShipmentStatusService implements ShipmentStatusInterface
{
    public function __construct(
        private StatusMapping $statusMapping,
    ) {
    }

    public function get(Shipment $shipment): ShipmentStatus
    {
        return $this->statusMapping->get("Received");
    }
}
