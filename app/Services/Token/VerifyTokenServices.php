<?php

namespace App\Services\Token;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;



class VerifyTokenServices
{
    public function  verifyToken($token)
    {
        try {
            $secretKey = env('JWT_ACCESS_TOKEN_SECRET');
            $decodedToken = JWT::decode($token, new Key($secretKey, 'HS256'));
            return $decodedToken;
        } catch (\Exception $e) {
            return  $e->getMessage();
        }
    }
}
