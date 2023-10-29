<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Shipping\Http\Controllers\V1\ShipmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix("v1")->middleware("auth:sanctum")->group(function () {
    Route::post("/shipments", [ShipmentController::class, 'create']);
    Route::get("/shipments/{id}/status", [ShipmentController::class, 'status']);
    Route::get("/shipments/{id}/print", [ShipmentController::class, 'print']);
    Route::put("/shipments/{id}/cancel", [ShipmentController::class, 'cancel']);
});
