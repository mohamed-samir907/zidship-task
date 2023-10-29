<?php

namespace App\Shipping\Interfaces;

use App\Models\Shipment;
use App\Shipping\Enums\ShipmentStatus;

interface ShipmentStatusInterface
{
    /**
     * Get the status of the given shipment.
     *
     * @param  Shipment $shipment
     * @return ShipmentStatus
     */
    public function get(Shipment $shipment): ShipmentStatus;
}
