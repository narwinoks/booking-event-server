<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\AuthServices;
use App\Services\Upload\ServiceUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller

{
    protected $authServices;
    protected $uploadService;
    public function  __construct(AuthServices $authServices, ServiceUpload $uploadService)
    {
        $this->uploadService = $uploadService;
        $this->authServices = $authServices;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function register(RegisterRequest $request)
    {
        // get form request
        $data = $request->only('username', 'email');
        $data['password'] = Hash::make($request->password);
        // upload avatar
        $upload = $this->uploadService->singleUpload("/assets/files/img/avatar/", $request->file('avatar'));
        $data['avatar'] = $upload;
        $data['role'] = UserRole::USER;
        // make new user
        return $this->authServices->register($data);
    }
    public function login(LoginRequest $request)
    {
        $data = $request->only('email', 'password');
        return $this->authServices->login($data);
    }
}
