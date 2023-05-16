<?php

namespace App\Services\Auth;

use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\Interface\AuthRepositoryInterface;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use JWTAuth;

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
    public function login($data)
    {
        try {

            if (!Auth::attempt($data)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $user = Auth::user();
            $access_token = JWTAuth::fromUser($user);
            $refresh_token = JWTAuth::refresh();

            return response()->json([
                'access_token' => $access_token,
                'refresh_token' => $refresh_token,
            ]);
            // return  $login;
        } catch (\Throwable $e) {
            Log::debug($e->getMessage());
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }
    }

    protected function createNewToken()
    {
    }
    protected function createRefreshToken()
    {
    }
}
