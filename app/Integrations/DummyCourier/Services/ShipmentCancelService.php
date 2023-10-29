<?php

namespace App\Integrations\DummyCourier\Services;

use App\Models\Shipment;
use App\Shipping\Interfaces\ShipmentCancelInterface;

class ShipmentCancelService implements ShipmentCancelInterface
{
    public function cancel(Shipment $shipment): void
    {
        // cancel logic
    }
}
