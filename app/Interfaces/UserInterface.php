<?php

namespace App\Interfaces;

interface UserInterface
{
    public function create($data);
    public function update($id, $data);
    public function getUserByEmail($email);
}
