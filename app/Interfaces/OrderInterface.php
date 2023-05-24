<?php

namespace App\Interfaces;

interface OrderInterface
{
    public function createOrder($data);
    public function updateOrder($id, $data);
    public function getOrderById($id);
    public function getOrderByUserId($userId);
    public function getOrderWithDetailTicket($orderId);
}
