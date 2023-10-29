<?php

namespace App\Integrations\KwickBox\Services;

use App\Models\Shipment;
use App\Shipping\Enums\ShipmentStatus;
use App\Integrations\KwickBox\KwickBox;
use App\Integrations\KwickBox\Mapping\StatusMapping;
use App\Shipping\Interfaces\ShipmentStatusInterface;

class ShipmentStatusService implements ShipmentStatusInterface
{
    public function __construct(
        private KwickBox $api,
        private StatusMapping $statusMapping,
    ) {
    }

    public function get(Shipment $shipment): ShipmentStatus
    {
        $res = $this->api->postRequest("track", [
            "Number" => $shipment->shipment_id,
            "UniqueReference" => $shipment->ref_number,
        ])->json();

        return $this->statusMapping->get(
            $res["Shipments"][0]["TrackingEntries"][0]["Status"]
        );
    }
}
