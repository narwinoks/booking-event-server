<?php

namespace App\Services\Token;

use Carbon\Carbon;
use Firebase\JWT\JWT;


class GenerateTokenServices
{
    public function accessToken($payload)
    {
        $expirationTime = time() + env('ACCESS_TOKEN_EXPIRED');
        $secretKey = env('JWT_ACCESS_TOKEN_SECRET');
        $access = JWT::encode(['exp' => $expirationTime] + $payload, $secretKey, 'HS256');
        return $access;
    }

    public function refreshToken($payload)
    {
    }
}
