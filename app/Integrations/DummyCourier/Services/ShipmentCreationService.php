<?php

namespace App\Integrations\DummyCourier\Services;

use App\Shipping\DTOs\ShipmentDTO;
use App\Shipping\Interfaces\DTOInterface;
use App\Shipping\Interfaces\ShipmentCreationInterface;

class ShipmentCreationService implements ShipmentCreationInterface
{
    /**
     * @param ShipmentDTO $dto
     */
    public function create(DTOInterface $dto): string|int
    {
        return "id-12345";
    }
}
