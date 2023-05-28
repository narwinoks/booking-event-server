<?php

namespace App\Services\Auth;

use App\Http\Resources\AuthResource;
use App\Interfaces\UserInterface;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    public function changePassword($data)
    {
        try {
            $user = Auth::user();
            if (Hash::check($data['old_password'], $user->password)) {
                $updateData = [
                    'password' => $data['new_password'],
                ];
                $updatePassword = $this->userInterface->update($user->id, $updateData);
                return $this->successResponse(new AuthResource($updatePassword), 200, "Successfully");
            }
            return $this->errorResponse("old password not match", 404);
        } catch (\Throwable $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }
    }
}
