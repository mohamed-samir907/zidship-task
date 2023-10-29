<?php

namespace App\Shipping\Factories;

use Exception;
use App\Shipping\Enums\Platform;
use App\Shipping\Interfaces\ShipmentStatusInterface;
use App\Integrations\KwickBox\Services\ShipmentStatusService as KwickBoxService;
use App\Integrations\DummyCourier\Services\ShipmentStatusService as DummyCourierService;

class CourierShipmentStatusServiceFactory
{
    public static function create(string $key): ShipmentStatusInterface
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
