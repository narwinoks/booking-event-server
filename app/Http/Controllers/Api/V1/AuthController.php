<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\AuthServices;
use App\Services\Token\GenerateTokenServices;
use App\Services\Token\VerifyTokenServices;
use App\Services\Upload\UploadServices;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $generateTokenServices;
    protected $authServices;
    protected $verifyTokenServices;
    protected $uploadServices;
    public function __construct(GenerateTokenServices $generateTokenServices, AuthServices $authServices, VerifyTokenServices $verifyTokenServices, UploadServices $uploadServices)
    {
        $this->generateTokenServices = $generateTokenServices;
        $this->authServices = $authServices;
        $this->verifyTokenServices = $verifyTokenServices;
        $this->uploadServices = $uploadServices;
    }
    public function register(RegisterRequest $request)
    {
        $data = $request->only('username', 'password', 'email');
        $data['avatar'] = $this->uploadServices->singleUpload("assets/files/img/avatar", $request->file('avatar'));
        $token = $this->generateTokenServices->accessToken($data);
        return $this->authServices->register($token, $request->all());
    }

    public function verification(Request $request)
    {
        $token =  $this->verifyTokenServices->verifyToken($request->activation_token);
        return $this->authServices->verification($token);
    }

    public function login(LoginRequest $request)
    {
        return $this->authServices->login($request->all());
    }

    public function refreshToken(Request $request)
    {
        return $this->authServices->getRefreshToken();
    }
    public function logout(Request $request)
    {
        return $this->authServices->logout();
    }
}
