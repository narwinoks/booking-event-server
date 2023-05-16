<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\AuthServices;
use App\Services\Upload\ServiceUpload;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authServices;
    protected $uploadService;
    public function  __construct(AuthServices $authServices, ServiceUpload $uploadService)
    {
        $this->uploadService = $uploadService;
        $this->authServices = $authServices;
    }
    public function register(RegisterRequest $request)
    {
        // get form request
        $data = $request->only('username', 'email', 'password');
        // upload avatar
        $upload = $this->uploadService->singleUpload("/assets/files/img/avatar/", $request->file('avatar'));
        $data['avatar'] = $upload;
        $data['role'] = UserRole::USER;
        // make new user
        return $this->authServices->register($data);
    }
    public function login(Request $request)
    {
    }
}
