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
        $jwtWithExpiration = JWT::encode(['exp' => $expirationTime] + $payload, $secretKey, 'HS256');
        return $jwtWithExpiration;
    }

    public function refreshToken($payload)
    {
    }
}
