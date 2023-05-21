<?php

namespace App\Repositories;

use App\Interfaces\data;
use App\Interfaces\OrderInterface;
use App\Models\Order;

class OrderRepository implements OrderInterface
{
    public function createOrder($data)
    {
        return Order::create($data);
    }
    public function updateOrder($id, $data)
    {
        $order = Order::where('id', $id);
        return $order->update($data);
    }
}
