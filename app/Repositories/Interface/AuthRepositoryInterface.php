<?php

namespace App\Repositories\Interface;

interface AuthRepositoryInterface
{
    public function register($data);
    public function getUserByEmail($email);
}
