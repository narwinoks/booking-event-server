<?php

namespace App\Interfaces;

interface OrderInterface
{
    public function createOrder($data);
    public function updateOrder($id, $data);
    public function getOrderById($id);
    public function getOrderByUserId($userId, $startDate, $endDate);
    public function getOrderWithDetailTicket($orderId);
    public function getOrderItem($orderId);
}
