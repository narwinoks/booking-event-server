<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentLog;
use App\Services\Orders\WebhookServices;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WebHookController extends Controller
{
    protected $webHookServices;
    public function __construct(WebhookServices $webHookServices)
    {
        $this->webHookServices = $webHookServices;
    }
    public function webhook(Request $request)
    {
        $data = $request->all();
        return  $this->webHookServices->changeStatusOrder($data);
    }


    public function midtransHandler(Request $request)
    {
        try {
            //code...
            $data = $request->all();
            $signatureKey = $data['signature_key'];
            $orderId = $data['order_id'];
            $statusCode = $data['status_code'];
            $grossAmount = $data['gross_amount'];
            $serverKey = env('MIDTRANS_SERVER_KEY');

            $mySignature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
            $transactionStatus = $data['transaction_status'];
            $type = $data['payment_type'];
            $fraudStatus = $data['fraud_status'];

            // dd(json_encode($data));

            if ($signatureKey !== $mySignature) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid Signature Key'
                ], Response::HTTP_BAD_REQUEST);
            }
            return response()->json([
                'success' => 'oke',
            ]);
        } catch (\Throwable $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }

        // // check order id on database
        // $realOrderId = explode('-', $orderId);
        // // return $realOrderId[0];
        // $fixOrderId = $realOrderId[0];
        // $order = Order::find($realOrderId[0]);
        // // dd($order);

        // // return response()->json([
        // //     'data' =>$order
        // // ]);
        // if (!$order) {
        //     return response()->json([
        //         'success' => 'error',
        //         'message' => 'User not found'
        //     ], Response::HTTP_BAD_REQUEST);
        // }
        // if ($order->status == 'success') {
        //     return response()->json([
        //         'success' => 'error',
        //         'message' => 'Operation not permitted'
        //     ], 405);
        // }

        // // check transaction status
        // if ($transactionStatus == 'capture') {
        //     if ($fraudStatus == 'challenge') {
        //         // TODO set transaction status on your database to 'challenge'
        //         // and response with 200 OK
        //         $order->status = 'challenge';
        //     } else if ($fraudStatus == 'accept') {
        //         // TODO set transaction status on your database to 'success'
        //         // and response with 200 OK
        //         $order->status = 'success';
        //     }
        // } else if ($transactionStatus == 'settlement') {
        //     // TODO set transaction status on your database to 'success'
        //     // and response with 200 OK
        //     $order->status = 'success';
        // } else if (
        //     $transactionStatus == 'cancel' ||
        //     $transactionStatus == 'deny' ||
        //     $transactionStatus == 'expire'
        // ) {
        //     // TODO set transaction status on your database to 'failure'
        //     // and response with 200 OK
        //     $order->status = 'failure';
        // } else if ($transactionStatus == 'pending') {
        //     // TODO set transaction status on your database to 'pending' / waiting payment
        //     // and response with 200 OK
        //     $order->status = 'pending';
        // }


        // $logData = [
        //     'status' => $transactionStatus,
        //     'raw_response' => json_encode($data),
        //     'order_id' => $realOrderId[0],
        //     'payment_type' => $type,

        // ];
        // PaymentLog::create($logData);
        // $order->save();
        // // dd($order);
        // if ($order->status == 'success') {
        //     // $test = createPremiumAccess([
        //     //     'user_id' => $order->user_id,
        //     //     'course_id' => $order->course_id,
        //     // ]);
        // }


    }
}
