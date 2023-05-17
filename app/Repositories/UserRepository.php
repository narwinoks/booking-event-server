<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\User;

class UserRepository  implements UserInterface
{
    public function  create($data)
    {
        return User::create($data);
    }
    public function getUserByEmail($email)
    {
        // return User::all();
        return User::where('email', $email)->first();
    }
}
