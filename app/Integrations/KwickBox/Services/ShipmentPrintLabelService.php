<?php

namespace App\Integrations\KwickBox\Services;

use App\Models\Shipment;
use App\Integrations\KwickBox\KwickBox;
use App\Shipping\Interfaces\ShipmentPrintLabelInterface;

class ShipmentPrintLabelService implements ShipmentPrintLabelInterface
{
    public function __construct(
        private KwickBox $api,
    ) {
    }

    public function get(Shipment $shipment): string
    {
        $res = $this->api->postRequest("printLabel", [
            "Number" => $shipment->shipment_id,
            "UniqueReference" => $shipment->ref_number,
        ])->json();

        return $res["Location"];
    }
}
