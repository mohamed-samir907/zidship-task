<?php

namespace App\Shipping\Services;

use Throwable;
use App\Models\Shipment;
use App\Http\ResponseHelper;
use App\Shipping\DTOs\ShipmentDTO;
use App\Shipping\Enums\ShipmentStatus;
use App\Shipping\Factories\ShipmentDTOFactory;
use App\Shipping\Interfaces\ShippingRepositoryInterface;
use App\Shipping\Factories\CourierShipmentCancelServiceFactory;
use App\Shipping\Factories\CourierShipmentStatusServiceFactory;
use App\Shipping\Factories\CourierShipmentCreationServiceFactory;
use App\Shipping\Factories\CourierShipmentPrintLabelServiceFactory;

final class ShipmentService
{
    public function __construct(
        private ShippingRepositoryInterface $repo,
        private RefNumberGeneratorService $refNumberGeneratorService,
    ) {
    }

    /**
     * Create a draft shipment and send it to the shipping platform.
     *
     * @param  array $data
     * @return Shipment
     */
    public function create(array $data): Shipment
    {
        $data["user_id"] = auth()->id();
        $data["platform_id"] = $this->repo->getPlatformByKey($data["platform"])->id;

        $refNumber = $this->refNumberGeneratorService->generate(14);
        $data["ref_number"] = $refNumber;

        $dto = ShipmentDTOFactory::createShipmentDTO($data);

        $shipment = $this->createDraftShipment($dto);

        try {
            $platform = $this->repo->getPlatformById($dto->platformId);

            $service = CourierShipmentCreationServiceFactory::create($platform->key);
            $shipmentId = $service->create($dto);

            $this->repo->markShipmentAsCreated($shipment, $shipmentId);
        } catch (Throwable $e) {
            abort(ResponseHelper::error("failed while creating shipment", [
                "msg" => $e->getMessage(),
            ]));
        }

        return $shipment;
    }

    /**
     * Create a local|draft shipment to be used later.
     *
     * @param  ShipmentDTO $dto
     * @return Shipment
     */
    private function createDraftShipment(ShipmentDTO $dto): Shipment
    {
        $shipment = $this->repo->createShipment($dto);

        $this->repo->createSender($shipment, $dto->sender);

        $this->repo->createRecipient($shipment, $dto->recipient);

        foreach ($dto->items as $item) {
            $this->repo->createItem($shipment, $item);
        }

        return $shipment;
    }

    /**
     * Get the shipment status.
     *
     * @param  int $id
     * @return ShipmentStatus
     */
    public function status(int $id): ShipmentStatus
    {
        $shipment = $this->repo->getShipmentById($id);

        $service = CourierShipmentStatusServiceFactory::create($shipment->platform->key);

        return $service->get($shipment);
    }

    /**
     * Get print shipment label url.
     *
     * @param  int $id
     * @return string
     */
    public function print(int $id): string
    {
        $shipment = $this->repo->getShipmentById($id);

        $service = CourierShipmentPrintLabelServiceFactory::create($shipment->platform->key);

        return $service->get($shipment);
    }

    /**
     * Cancel Shipment.
     *
     * @param  int $id
     * @return void
     */
    public function cancel(int $id): void
    {
        /* abort(ResponseHelper::error("failed", [
            "msg" => "Cancel not supported for this platform",
        ])); */

        $shipment = $this->repo->getShipmentById($id);

        $service = CourierShipmentCancelServiceFactory::create($shipment->platform->key);

        $service->cancel($shipment);

        $this->repo->changeStatus($shipment, ShipmentStatus::Canceled);
    }
}
