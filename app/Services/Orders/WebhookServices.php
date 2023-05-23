<?php

namespace App\Services\Orders;

use App\Interfaces\OrderInterface;
use App\Interfaces\PaymentLogInterface;
use App\Traits\ApiResponse;

class WebhookServices
{
    use ApiResponse;
    protected $orderInterface;
    protected $paymentLogInterface;
    protected $sendMailServices;
    public function __construct(OrderInterface $orderInterface, PaymentLogInterface $paymentLogInterface, SendMailServices $sendMailServices)
    {
        $this->orderInterface = $orderInterface;
        $this->sendMailServices = $sendMailServices;
        $this->paymentLogInterface = $paymentLogInterface;
    }
    public function createLog($data)
    {
    }

    public function changeStatusOrder($data)
    {
        $signatureKey   = $data['signature_key'];
        $orderId        = $data['order_id'];
        $statusCode     = $data['status_code'];
        $grossAmount    = $data['gross_amount'];
        $serverKey      = env('MIDTRANS_SERVER_KEY');

        $mySignature        = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
        $transactionStatus  = $data['transaction_status'];
        $type               = $data['payment_type'];
        $fraudStatus        = $data['fraud_status'];

        if ($signatureKey !== $mySignature) {
            return $this->errorResponse("Invalid Signature Key", 400);
        }


        $realOrderId = explode('-', $orderId);
        $fixOrderId = $realOrderId[0];
        $order = $this->orderInterface->getOrderById($fixOrderId);
        if (!$order) {
            return $this->errorResponse("Order not found", 404);
        }

        $orderUpdate = [];
        if ($order->status == 'success') {
            return $this->errorResponse("Operation not permitted", 404);
        }

        // check transaction status
        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'challenge') {
                $orderUpdate['status'] = 'challenge';
            } else if ($fraudStatus == 'accept') {
                $orderUpdate['status'] = 'success';
            }
        } else if ($transactionStatus == 'settlement') {
            $orderUpdate['status'] = 'success';
        } else if (
            $transactionStatus == 'cancel' ||
            $transactionStatus == 'deny' ||
            $transactionStatus == 'expire'
        ) {
            $orderUpdate['status'] = 'failure';
        } else if ($transactionStatus == 'pending') {
            $orderUpdate['status'] = 'pending';
        }

        $this->orderInterface->updateOrder($order->id, $orderUpdate);
        $logData = [
            'status' => $transactionStatus,
            'raw_response' => json_encode($data),
            'order_id' => $realOrderId[0],
            'payment_type' => $type,
        ];

        $$this->paymentLogInterface->createPaymentLog($logData);
        $test = ["name" => "name", "email" => "narnowin00@gmail.com"];
        $this->sendMailServices->sendMailTicket($order);
        return response()->json([
            'success' => 'oke',
        ]);
    }
}
