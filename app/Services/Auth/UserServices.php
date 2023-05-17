<?php

namespace App\Services\Auth;

use App\Http\Resources\AuthResource;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class UserServices
{
    use ApiResponse;
    public function getUser()
    {
        try {
            $user = Auth::user();
            $response = new AuthResource($user);
            return $this->successResponse($response, 200, "Successfully");
        } catch (\Throwable $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }
    }
}
