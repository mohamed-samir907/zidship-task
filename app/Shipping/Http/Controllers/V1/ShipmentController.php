<?php

namespace App\Shipping\Http\Controllers\V1;

use App\Http\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Shipping\Services\ShipmentService;
use App\Shipping\Http\Requests\ShipmentCreationRequest;
use App\Shipping\Http\Resources\ShipmentResource;

class ShipmentController extends Controller
{
    public function __construct(
        private ShipmentService $shipmentService,
    ) {
    }

    public function create(ShipmentCreationRequest $request)
    {
        $shipment = $this->shipmentService->create($request->validated());

        return ResponseHelper::success(
            message: "Shipment created",
            data: new ShipmentResource($shipment),
            status: 201,
        );
    }

    public function status(int $id)
    {
        $status = $this->shipmentService->status($id);

        return ResponseHelper::success(
            message: "OK",
            data: [
                "status" => $status->value,
            ],
        );
    }

    public function print(int $id)
    {
        $url = $this->shipmentService->print($id);

        return ResponseHelper::success(
            message: "OK",
            data: ["url" => $url],
        );
    }

    public function cancel(int $id)
    {
        $this->shipmentService->cancel($id);

        return ResponseHelper::success(
            message: "OK",
        );
    }
}
