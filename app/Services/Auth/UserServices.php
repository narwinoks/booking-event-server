<?php

namespace App\Services\Auth;

use App\Http\Resources\AuthResource;
use App\Interfaces\UserInterface;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class UserServices
{
    use ApiResponse;

    protected $userInterface;
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }
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
    public function changeAvatar($userId, $data)
    {
        try {
            $user =  $this->userInterface->update($userId, $data);
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
