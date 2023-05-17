<?php

namespace App\Services\Auth;

use App\Http\Resources\AuthResource;
use App\Interfaces\UserInterface;
use App\Mail\SendMailVerification;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
}
