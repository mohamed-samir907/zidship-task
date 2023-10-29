<?php

namespace App\Http;

use Illuminate\Http\Resources\Json\JsonResource;

class ResponseHelper
{
    /**
     * Send a response with success status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(
        string $message,
        array|JsonResource $data = [],
        int $status = 200
    ) {
        return response()->json([
            "message" => $message,
            "data" => $data,
        ], $status);
    }

    /**
     * Send a response with error status.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error(
        string $message,
        array $errors = [],
        int $status = 400
    ) {
        return response()->json([
            "message" => $message,
            "errors" => $errors,
        ], $status);
    }
}
