<?php

namespace App\Services\Auth;

use App\Http\Resources\AuthResource;
use App\Interfaces\UserInterface;
use App\Mail\SendMailVerification;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Firebase\JWT\JWT;


class AuthServices
{
    use ApiResponse;

    protected $userInterface;
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }
    public function register($token, $data)
    {
        try {
            $frontendUrl = env("FRONTEND_URL");
            $url = $frontendUrl . $token;

            $mailData = [
                'username' => $data['username'],
                'url' => $url
            ];
            Mail::to($data['email'])->send(new SendMailVerification($mailData));
            $response = ['activate' => $token];
            return $this->successResponse($response, 200, "Successfully");
        } catch (\Throwable $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }
    }

    public function verification($token)
    {
        try {
            if ($token == "Expired token") {
                return  $this->errorResponse("Expired token", 505);
            } else {
                $data = [
                    'username' => $token->username,
                    'email' => $token->email,
                    'password' => Hash::make($token->password),
                    'avatar' => $token->avatar,
                ];
                $user = $this->userInterface->create($data);
                $response = new AuthResource($user);
                return $this->successResponse($response, 200, "Successfully");
            }
        } catch (\Throwable $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }
    }

    public function login($data)
    {
        $user = $this->userInterface->getUserByEmail($data['email']);
        if ($user) {
            if (Hash::check($data['password'], $user->password)) {
                Auth::attempt($data);
                $response = [
                    'token' => $this->generateAccessToken($user),
                    'refresh_token' => $this->generateRefreshToken($user)
                ];
                return $this->successResponse($response, 200, "Successfully");
            } else {
                return $this->errorResponse("Password Not Match", 404);
            }
        } else {
            return $this->errorResponse("User Not Found", 404);
        }
    }

    protected function generateAccessToken($user)
    {
        $expirationTime = time() + env('ACCESS_TOKEN_EXPIRED');
        $secretKey = env('JWT_ACCESS_TOKEN_SECRET');
        $access_token = JWT::encode(['exp' => $expirationTime, 'sub' => $user], $secretKey, 'HS256');
        return $access_token;
    }

    protected function generateRefreshToken($user)
    {
        $expirationTime = time() + env('REFRESH_TOKEN_EXPIRED');
        $secretKey = env('JWT_REFRESH_TOKEN_SECRET');
        $refresh_token = JWT::encode(['exp' => $expirationTime, 'sub' => $user], $secretKey, 'HS256');
        return $refresh_token;
    }
    public function getRefreshToken()
    {
        try {
            $user = Auth::user();
            $response = [
                'token' => $this->generateAccessToken($user),
                'refresh_token' => $this->generateRefreshToken($user)
            ];
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
