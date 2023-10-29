<?php

namespace App\Integrations\KwickBox\Services;

use App\Shipping\DTOs\ShipmentDTO;
use App\Integrations\KwickBox\KwickBox;
use App\Shipping\Interfaces\DTOInterface;
use App\Shipping\Interfaces\ShipmentCreationInterface;
use App\Shipping\Interfaces\ShippingRepositoryInterface;

class ShipmentCreationService implements ShipmentCreationInterface
{
    public function __construct(
        private KwickBox $api,
        private ShippingRepositoryInterface $repo,
    ) {
    }

    /**
     * @param ShipmentDTO $dto
     */
    public function create(DTOInterface $dto): string|int
    {
        $res = $this->createShipment($dto);

        $shipmentId = $res["Number"];

        $this->setPickupDate($shipmentId, $dto->pickupDate);

        return $shipmentId;
    }

    private function createShipment(ShipmentDTO $dto)
    {
        return $this->api->postRequest("shipments", [
            "SinglePagePdf" => true,
            "UniqueReference" => $dto->refNumber,
            "Shipper" => [
                "Contact" => [
                    "Name" => $dto->sender->name,
                    "Email" => $dto->sender->email,
                    "Phone" => $dto->sender->phone,
                ],
                "Address" => [
                    "Country" => $dto->sender->country,
                    "State" => $dto->sender->state,
                    "PostCode" => $dto->sender->postalCode,
                    "City" => $dto->sender->city,
                    "AddressLine1" => $dto->sender->addressLine1,
                    "AddressLine2" => $dto->sender->addressLine2,
                    "AddressLine3" => $dto->sender->addressLine3,
                ],
            ],
            "Consignee" => [
                "Contact" => [
                    "Name" => $dto->recipient->name,
                    "Email" => $dto->recipient->email,
                    "Phone" => $dto->recipient->phone,
                ],
                "Address" => [
                    "Country" => $dto->recipient->country,
                    "State" => $dto->recipient->state,
                    "PostCode" => $dto->recipient->postalCode,
                    "City" => $dto->recipient->city,
                    "AddressLine1" => $dto->recipient->addressLine1,
                    "AddressLine2" => $dto->recipient->addressLine2,
                    "AddressLine3" => $dto->recipient->addressLine3,
                ],
            ],
            "Commodity" => [
                "Weight" => $dto->items[0]->weight,
                "Description" => $dto->items[0]->description,
                "COD" => $dto->cod,
                "NumberOfPieces" => $dto->items[0]->quantity,
            ],
        ])->json();
    }

    private function setPickupDate(string $shipmentId, string $date)
    {
        return $this->api->postRequest("$shipmentId/SetPickupDate", [
            "PickupDate" => $date,
        ]);
    }
}
