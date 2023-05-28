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
    public function update($id, $data)
    {
        $user = User::where('id', $id)->first();
        $user->update($data);
        return $user;
    }
}
