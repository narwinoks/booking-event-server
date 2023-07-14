<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

if (!function_exists('success')) {
    function success($message =[], $data = [], $statusCode = 200): JsonResponse
    {
        return response()->json(array_merge($message,$data), $statusCode);
    }
}

if (!function_exists('error')) {
    function error($message = [], $statusCode = 400, $error = []): JsonResponse
    {
        return response()->json(array_merge($message, $error),404);
    }
}
