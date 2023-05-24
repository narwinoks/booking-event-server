<?php

namespace App\Interfaces;

interface OrderDetailInterface
{
    public function createOrderDetail($orderId, $data);
    public function updateOrderItem($id, $data);
    public function getOrderDetailWithOrderTicket($id);
}
