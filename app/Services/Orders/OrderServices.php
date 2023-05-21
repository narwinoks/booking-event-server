<?php

namespace App\Services\Orders;

use App\Interfaces\OrderDetailInterface;
use App\Interfaces\OrderInterface;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class OrderServices
{
    use ApiResponse;
    protected $orderDetailInterface;
    protected $orderInterface;
    public function __construct(OrderDetailInterface $orderDetailInterface, OrderInterface $orderInterface)
    {
        $this->orderDetailInterface = $orderDetailInterface;
        $this->orderInterface = $orderInterface;
    }
    public function createOrder($data)
    {
        // create order
        $orderData = $data['order'];
        $orderData['user_id'] = Auth::user()->id;
        $orderDetailData = $data['order_items'];
        $order = $this->orderInterface->createOrder($orderData);
        $orderData = $this->orderDetailInterface->createOrderDetail($order->id, $orderDetailData);
        $response = [
            'order' => $order,
            'order_detail' => $orderDetailData
        ];
        return $response;
    }
}
