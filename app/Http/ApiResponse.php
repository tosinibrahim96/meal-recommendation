<?php

namespace App\Http;

use Illuminate\Http\JsonResponse;
use JsonSerializable;

class ApiResponse
{
    /**
     * Return a new JSON response with mixed(object|JsonSerializable) data
     *
     * @param int $status
     * @param mixed $data
     * @param string|null $message
     * @return JsonResponse
     */
    public static function send(
        int $status,
        $data = [],
        string $message = null
    ): JsonResponse {
        $response = [
            'status' => $status,
            'data' => $data,
            "message" => $message
        ];
        return response()->json($response, $status);
    }
}
