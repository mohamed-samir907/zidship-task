<?php

namespace App\Shipping\Interfaces;

use App\Models\Shipment;

interface ShipmentPrintLabelInterface
{
    /**
     * Get the PDF url of the given shipment.
     *
     * @param  Shipment $shipment
     * @return string PDF URL
     */
    public function get(Shipment $shipment): string;
}
