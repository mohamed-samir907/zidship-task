<?php

namespace App\Integrations\KwickBox\Services;

use App\Models\Shipment;
use App\Integrations\KwickBox\KwickBox;
use App\Shipping\Interfaces\ShipmentCancelInterface;

class ShipmentCancelService implements ShipmentCancelInterface
{
    public function __construct(
        private KwickBox $api,
    ) {
    }

    public function cancel(Shipment $shipment): void
    {
        $res = $this->api->postRequest($shipment->shipment_id . "/cancel", []);

        if ($res->failed()) {
            $res->throw();
        }
    }
}
