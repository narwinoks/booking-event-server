<?php

namespace App\Interfaces;

interface OrderDetailInterface
{
    public function createOrderDetail($orderId, $data);
    public function updateOrderItem($id, $data);
    public function getOrderDetailWithOrderTicket($id);
    public function getOrderByCode($code);
    public function getAllOrderItems($request);
    public  function getAllOrderItemsByEvent($event,$search);
}
