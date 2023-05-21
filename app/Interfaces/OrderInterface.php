<?php

namespace App\Interfaces;

interface OrderInterface
{
    public function createOrder($data);
    public function updateOrder($id, $data);
}
