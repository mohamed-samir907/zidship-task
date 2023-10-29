<?php

namespace App\Shipping\Repositories;

use App\Models\Platform;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\ShipmentDetail;
use App\Shipping\Enums\ShipmentStatus;
use App\Shipping\Interfaces\DTOInterface;
use App\Shipping\Interfaces\ShippingRepositoryInterface;

class ShippingRepository implements ShippingRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getShipmentById(int $id): Shipment
    {
        return Shipment::find($id);
    }

    /**
     * @inheritDoc
     */
    public function getShipmentByRefNumber(string $number): Shipment
    {
        return Shipment::where("ref_number", $number)->first();
    }

    /**
     * @inheritDoc
     */
    public function createShipment(DTOInterface $dto): Shipment
    {
        return Shipment::query()->create($dto->toDatabase());
    }

    /**
     * @inheritDoc
     */
    public function createSender(Shipment $shipment, DTOInterface $shipmentDetailDTO): ShipmentDetail
    {
        return $shipment->sender()->create($shipmentDetailDTO->toDatabase());
    }

    /**
     * @inheritDoc
     */
    public function createRecipient(Shipment $shipment, DTOInterface $shipmentDetailDTO): ShipmentDetail
    {
        return $shipment->recipient()->create($shipmentDetailDTO->toDatabase());
    }

    /**
     * @inheritDoc
     */
    public function createItem(Shipment $shipment, DTOInterface $itemDTO): ShipmentItem
    {
        return $shipment->items()->create($itemDTO->toDatabase());
    }

    /**
     * @inheritDoc
     */
    public function getPlatformByKey(string $key): Platform
    {
        return Platform::where("key", $key)->first();
    }

    /**
     * @inheritDoc
     */
    public function getPlatformById(int $id): Platform
    {
        return Platform::find($id);
    }

    /**
     * @inheritDoc
     */
    public function markShipmentAsCreated(Shipment $shipment, string|int $shipmentId)
    {
        $shipment->update([
            "shipment_id" => $shipmentId,
            "status" => ShipmentStatus::Created->value,
        ]);
    }
}
