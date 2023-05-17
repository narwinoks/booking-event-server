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
        $frontendUrl = env("FRONTEND_URL");
        $url = $frontendUrl . $token;

        $mailData = [
            'username' => $data['username'],
            'url' => $url
        ];
        Mail::to($data['email'])->send(new SendMailVerification($mailData));
        $response = ['activate' => $token];
        return $this->successResponse($response, 200, "Successfully");
    }

    public function verification($token)
    {
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
    }

    public function login($data)
    {
        $user = $this->userInterface->getUserByEmail($data['email']);
        if ($user) {
            if (Hash::check($data['password'], $user->password)) {
                Auth::attempt($data);
                $response = [
                    'token' => $this->generateAccessToken($user->id),
                    'refresh_token' => $this->generateRefreshToken($user->id)
                ];
                return $this->successResponse($response, 200, "Successfully");
            } else {
                return $this->errorResponse("Password Not Match", 404);
            }
        } else {
            return $this->errorResponse("User Not Found", 404);
        }
    }

    protected function generateAccessToken($userId)
    {
        $payload = [
            'sub' => $userId,
            'exp' => time() + env('ACCESS_TOKEN_EXPIRED '),
        ];

        $secretKey = env('JWT_ACCESS_TOKEN_SECRET');
        $algorithm = 'HS256';

        $token = JWT::encode($payload, $secretKey, $algorithm);
        return $token;
    }

    protected function generateRefreshToken($userId)
    {
        $payload = [
            'sub' => $userId,
            'exp' => time() + env('REFRESH_TOKEN_EXPIRED  '),
        ];

        $secretKey = env('JWT_ACCESS_TOKEN_SECRET');
        $algorithm = 'HS256';

        $token = JWT::encode($payload, $secretKey, $algorithm);
        return $token;
    }
}
