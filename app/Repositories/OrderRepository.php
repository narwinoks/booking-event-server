<?php

namespace App\Repositories;

use App\Interfaces\OrderInterface;
use App\Models\Order;

class OrderRepository implements OrderInterface
{
    public function createOrder($data)
    {
        return Order::create($data);
    }
}
