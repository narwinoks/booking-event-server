<?php

namespace App\Repositories;

use App\Interfaces\OrderDetailInterface;
use App\Models\OrderItem;

class OrderDetailRepository implements OrderDetailInterface
{
    public function createOrderDetail($orderId, $data)
    {
        foreach ($data as $key => $orderDetail) {
            OrderItem::create([
                'order_id' => $orderId,
                'ticket_id' => $orderDetail['ticket_id'],
                'title' => $orderDetail['title'],
                'name' => $orderDetail['name'],
                'email' => $orderDetail['email'],
                'phone_number' => $orderDetail['phone_number'] 
            ]);
        }
    }
}
