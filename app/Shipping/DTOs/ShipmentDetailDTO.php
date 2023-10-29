<?php

namespace App\Shipping\DTOs;

use App\Shipping\Enums\ShipmentDetailsType;
use App\Shipping\Interfaces\DTOInterface;

readonly class ShipmentDetailDTO implements DTOInterface
{
    public function __construct(
        public ShipmentDetailsType $type,
        public string $name,
        public string $phone,
        public string $country,
        public string $city,
        public string $addressLine1,
        public ?string $email = null,
        public ?string $state = null,
        public ?string $postalCode = null,
        public ?string $addressLine2 = null,
        public ?string $addressLine3 = null,
    ) {
    }

    public function toDatabase(): array
    {
        return [
            "type"          => $this->type->value,
            "name"          => $this->name,
            "phone"         => $this->phone,
            "email"         => $this->email,
            "country"       => $this->country,
            "state"         => $this->state,
            "city"          => $this->city,
            "postal_code"   => $this->postalCode,
            "address_line1" => $this->addressLine1,
            "address_line2" => $this->addressLine2,
            "address_line3" => $this->addressLine3,
        ];
    }
}
