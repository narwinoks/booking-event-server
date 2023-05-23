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
    protected $midtransServices;
    protected $transactionDetailServices;
    public function __construct(OrderDetailInterface $orderDetailInterface, OrderInterface $orderInterface, MidtransServices $midtransServices, TransactionDetailServices $transactionDetailServices)
    {
        $this->orderDetailInterface = $orderDetailInterface;
        $this->orderInterface = $orderInterface;
        $this->midtransServices = $midtransServices;
        $this->transactionDetailServices = $transactionDetailServices;
    }
    public function createOrder($data)
    {
        // create order
        $user                   = Auth::user();
        $orderData              = $data['order'];
        $orderData['user_id']   = $user->id;
        $orderDetailData        = $data['order_items'];
        $order                  = $this->orderInterface->createOrder($orderData);
        $orderData              = $this->orderDetailInterface->createOrderDetail($order->id, $orderDetailData);
        $paramsMidtrans         = $this->transactionDetailServices->makeDetailTransaction($order, $orderData, $user);
        $snapUrl                = $this->midtransServices->getSnapshotUrl($paramsMidtrans);
        $updated                = $this->orderInterface->updateOrder($order->id, ['snap_url' => $snapUrl]);
        $response = [
            'message'       => 'Successfully',
            'snap_url'      => $snapUrl,
        ];
        return $response;
    }

    public function getOrderUser()
    {
        try {
            $userId = Auth::user()->id;
            $orders = $this->orderInterface->getOrderByUserId($userId);
            return $this->successResponse($orders, 200, "Successfully");
        } catch (\Throwable $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }
    }
}
