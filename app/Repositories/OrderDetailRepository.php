<?php

namespace App\Repositories;

use App\Interfaces\OrderDetailInterface;
use App\Models\OrderItem;

class OrderDetailRepository implements OrderDetailInterface
{
    public function createOrderDetail($orderId, $data)
    {
        $orderData = [];
        foreach ($data as $key => $orderDetail) {
            $orderData[] =  OrderItem::create([
                'order_id' => $orderId,
                'no_ktp' => $orderDetail['no_ktp'],
                'ticket_id' => $orderDetail['ticket_id'],
                'title' => $orderDetail['title'],
                'name' => $orderDetail['name'],
                'email' => $orderDetail['email'],
                'phone_number' => $orderDetail['phone_number']
            ]);
        }

        return $orderData;
    }

    public function updateOrderItem($id, $data)
    {
        $orderItem = OrderItem::find($id);
        return $orderItem->update($data);
    }
}
