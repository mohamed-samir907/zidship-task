<?php

namespace App\Shipping\Interfaces;

use App\Models\Shipment;

interface ShipmentCancelInterface
{
    /**
     * Cancel the given shipment.
     *
     * @param  Shipment $shipment
     * @return void
     */
    public function cancel(Shipment $shipment): void;
}
