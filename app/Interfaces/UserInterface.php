<?php

namespace App\Interfaces;

interface UserInterface
{
    public function create($data);
    public function getUserByEmail($email);
}
