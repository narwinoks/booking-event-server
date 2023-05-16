<?php

namespace App\Traits;

trait ApiResponse
{

    protected function successResponse($data = null, int $code = 200, String $message = null, array $meta = [])
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];
        if (!empty($meta)) {
            $response['meta'] = $meta;
        }
        return response()->json($response, $code);
    }

    protected function errorResponse(String $message, int $code = 500, String $customCode = null, $error = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
            'errors' => $error,
            'code' => $customCode
        ];
        return response()->json($response, $code);
    }
}
