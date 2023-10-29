<?php

namespace App\Shipping\Interfaces;

interface ShipmentCreationInterface
{
    /**
     * Create the shipping using data provided with the given DTO.
     * It returns the Shipment ID returned by the platform.
     *
     * @param  DTOInterface $dto
     * @return string|int
     */
    public function create(DTOInterface $dto): string|int;
}
