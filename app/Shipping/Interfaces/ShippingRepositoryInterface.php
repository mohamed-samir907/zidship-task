<?php

namespace App\Shipping\Interfaces;

use App\Models\Platform;
use App\Models\Shipment;
use App\Models\ShipmentItem;
use App\Models\ShipmentDetail;
use App\Shipping\Enums\ShipmentStatus;
use App\Shipping\Interfaces\DTOInterface;

interface ShippingRepositoryInterface
{
    /**
     * Find the shipment by the given ID.
     *
     * @param  in $id
     * @return Shipment|null
     */
    public function getShipmentById(int $id): Shipment;

    /**
     * Find the shipment by the given reference number.
     *
     * @param  string $number
     * @return Shipment|null
     */
    public function getShipmentByRefNumber(string $number): Shipment;

    /**
     * Create a shipment in the database.
     *
     * @param  DTOInterface $dto
     * @return Shipment
     */
    public function createShipment(DTOInterface $dto): Shipment;

    /**
     * Create a sender under the given shipment.
     *
     * @param  Shipment $shipment
     * @param  DTOInterface $shipmentDetailDTO
     * @return ShipmentDetail
     */
    public function createSender(Shipment $shipment, DTOInterface $shipmentDetailDTO): ShipmentDetail;

    /**
     * Create a recipient under the given shipment.
     *
     * @param  Shipment $shipment
     * @param  DTOInterface $shipmentDetailDTO
     * @return ShipmentDetail
     */
    public function createRecipient(Shipment $shipment, DTOInterface $shipmentDetailDTO): ShipmentDetail;

    /**
     * Add item to the given shipment.
     *
     * @param  Shipment $shipment
     * @param  DTOInterface $shipmentDetailDTO
     * @return ShipmentDetail
     */
    public function createItem(Shipment $shipment, DTOInterface $itemDTO): ShipmentItem;

    /**
     * Get the platform using it's unique key.
     *
     * @param  string $key
     * @return Platform
     */
    public function getPlatformByKey(string $key): Platform;

    /**
     * Get the platform using it's ID.
     *
     * @param  int $id
     * @return Platform
     */
    public function getPlatformById(int $id): Platform;

    /**
     * Update the shipment id with the ID returned from the platform and change
     * the status to be created.
     *
     * @param  Shipment $shipment
     * @param  string|int $shipmentId
     * @return void
     */
    public function markShipmentAsCreated(Shipment $shipment, string|int $shipmentId);

    /**
     * Change the shipment status.
     *
     * @param  Shipment $shipment
     * @param  ShipmentStatus $status
     * @return void
     */
    public function changeStatus(Shipment $shipment, ShipmentStatus $status);
}
