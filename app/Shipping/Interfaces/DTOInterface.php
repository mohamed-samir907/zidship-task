<?php

namespace App\Shipping\Interfaces;

interface DTOInterface
{
    public function toDatabase(): array;
}
