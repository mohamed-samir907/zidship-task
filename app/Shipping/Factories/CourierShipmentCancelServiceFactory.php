<?php

namespace App\Shipping\Factories;

use Exception;
use App\Shipping\Enums\Platform;
use App\Shipping\Interfaces\ShipmentCancelInterface;
use App\Integrations\KwickBox\Services\ShipmentCancelService as KwickBoxService;
use App\Integrations\DummyCourier\Services\ShipmentCancelService as DummyCourierService;

class CourierShipmentCancelServiceFactory
{
    public static function create(string $key): ShipmentCancelInterface
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
