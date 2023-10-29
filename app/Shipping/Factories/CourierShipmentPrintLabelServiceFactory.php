<?php

namespace App\Shipping\Factories;

use Exception;
use App\Shipping\Enums\Platform;
use App\Shipping\Interfaces\ShipmentPrintLabelInterface;
use App\Integrations\KwickBox\Services\ShipmentPrintLabelService as KwickBoxService;
use App\Integrations\DummyCourier\Services\ShipmentPrintLabelService as DummyCourierService;

class CourierShipmentPrintLabelServiceFactory
{
    public static function create(string $key): ShipmentPrintLabelInterface
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
