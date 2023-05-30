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
    public function getOrderByUserId($userId, $startDate, $endDate)
    {
        return Order::where('user_id', $userId)->with('orderItem.ticket.event')->whereBetween('created_at', [$startDate, $endDate])->get();
    }
    public function getOrderWithDetailTicket($orderId)
    {
        return Order::where('id', $orderId)->with('orderItem')->first();
    }
    public function getOrderItem($orderId)
    {
        return Order::where('id', $orderId)->with('orderItem.ticket.event')->first();
    }
}
