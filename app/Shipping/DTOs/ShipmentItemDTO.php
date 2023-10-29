<?php

namespace App\Shipping\DTOs;

use App\Shipping\Interfaces\DTOInterface;

readonly class ShipmentItemDTO implements DTOInterface
{
    public function __construct(
        public string $title,
        public int $quantity,
        public float $weight,
        public string $unit,
        public float $price,
        public ?string $description = null,
    ) {
    }

    public function toDatabase(): array
    {
        return [
            "title"         => $this->title,
            "description"   => $this->description,
            "quantity"      => $this->quantity,
            "weight"        => $this->weight,
            "unit"          => $this->unit,
            "price"         => $this->price,
        ];
    }
}
