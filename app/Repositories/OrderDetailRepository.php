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
                'title' => $orderDetail['title'] ?? "mr",
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

    public function getOrderDetailWithOrderTicket($id)
    {
        $data = OrderItem::with('order', 'ticket.event')->where('id', $id)->first();
        return $data;
    }
    public function getOrderByCode($code)
    {
        $data = OrderItem::where('code')->first();
        return $data;
    }

    public function getAllOrderItems($request)
    {
        $data = OrderItem::with('ticket.event')->get();
        return $data;
    }

    public  function getAllOrderItemsByEvent($event,$search){
        $data = OrderItem::with('ticket.event')
            ->whereHas('ticket.event', function ($query) use ($event) {
                $query->where('id', $event);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%$search%")
                        ->orWhere('no_ktp', 'LIKE', "%$search%")
                        ->orWhere('code', 'LIKE', "%$search%");
                });
            })
            ->where('code', '!=' ,null)
            ->get();
        return $data;
    }
}
