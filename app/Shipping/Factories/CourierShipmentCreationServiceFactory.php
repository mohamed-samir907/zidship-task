<?php

namespace App\Shipping\Factories;

use Exception;
use App\Shipping\Enums\Platform;
use App\Shipping\Interfaces\ShipmentCreationInterface;
use App\Integrations\KwickBox\Services\ShipmentCreationService as KwickBoxService;
use App\Integrations\DummyCourier\Services\ShipmentCreationService as DummyCourierService;

class CourierShipmentCreationServiceFactory
{
    public static function create(string $key): ShipmentCreationInterface
    {
        if (config('app.dummy-courier')) {
            return app(DummyCourierService::class);
        }

        return match ($key) {
            Platform::KwickBox->value => app(KwickBoxService::class),
            Platform::Aramex->value => throw new Exception("not ready"),
        };
    }
}
