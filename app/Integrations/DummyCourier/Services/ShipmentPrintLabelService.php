<?php

namespace App\Integrations\DummyCourier\Services;

use App\Models\Shipment;
use App\Shipping\Interfaces\ShipmentPrintLabelInterface;

class ShipmentPrintLabelService implements ShipmentPrintLabelInterface
{
    public function get(Shipment $shipment): string
    {
        return "https://fake-url.com/shipment-label.pdf";
    }
}
