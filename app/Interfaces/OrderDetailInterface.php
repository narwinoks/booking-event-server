<?php

namespace App\Interfaces;

interface OrderDetailInterface
{
    public function createOrderDetail($orderId, $data);
}
