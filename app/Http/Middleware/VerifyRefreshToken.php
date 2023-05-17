<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Firebase\JWT\Key;
use Firebase\JWT\JWT;

class VerifyRefreshToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = str_replace('Bearer ', '', $token);
        try {
            $secretKey = env('JWT_REFRESH_TOKEN_SECRET');
            $decodedToken = JWT::decode($token, new Key($secretKey, 'HS256'));
            Auth::loginUsingId($decodedToken->sub->id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
        return $next($request);
    }
}
