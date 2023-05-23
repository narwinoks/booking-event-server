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
        $order = Order::find($id);
        $order->update($data);
        return;
    }
    public function getOrderById($id)
    {
        return Order::where('id', $id)->first();
    }
    public function getOrderByUserId($userId)
    {
        return Order::where('user_id', $userId)->get();
    }
}
