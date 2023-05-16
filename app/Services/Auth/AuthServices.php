<?php

namespace App\Services\Auth;

use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\Interface\AuthRepositoryInterface;
use App\Traits\ApiResponse;
use Exception;

class AuthServices
{
    use ApiResponse;
    protected $authRepositoryInterface;
    public function __construct(AuthRepositoryInterface $authRepositoryInterface)
    {
        $this->authRepositoryInterface = $authRepositoryInterface;
    }
    public function register($data)
    {
        try {

            $user = $this->authRepositoryInterface->register($data);
            $response = new UserResource($user);
            return  $this->successResponse($response, 200, "successfully");
        } catch (Exception $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }
    }


    protected function createRefreshToken()
    {
    }
}
