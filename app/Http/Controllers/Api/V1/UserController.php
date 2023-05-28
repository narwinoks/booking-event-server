<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\Auth\UserServices;
use App\Services\Upload\UploadServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userServices;
    protected $uploadServices;
    public function __construct(UserServices $userServices, UploadServices $uploadServices)
    {
        $this->userServices = $userServices;
        $this->uploadServices = $uploadServices;
    }
    public function profile(Request $request)
    {
        return $this->userServices->getUser();
    }

    public function updateAvatar(UpdateProfileRequest $request)
    {
        $user           = Auth::user();
        $this->uploadServices->deleteFile("assets/files/img/avatar/", $user->avatar);
        $data['avatar'] = $this->uploadServices->singleUpload("assets/files/img/avatar", $request->file('avatar'));
        return $this->userServices->changeAvatar($user->id, $data);
    }

    public function changePassword(Request $request)
    {
        $data = $request->only('old_password', 'new_password', 'password_confirm');
        return $this->userServices->changePassword($data);
    }
}
