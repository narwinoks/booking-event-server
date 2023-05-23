<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateOrderRequest;
use App\Services\Orders\OrderServices;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderServices;
    public function  __construct(OrderServices $orderServices)
    {
        $this->orderServices = $orderServices;
    }
    public function createOrder(CreateOrderRequest $request)
    {
        return $this->orderServices->createOrder($request->all());
    }

    public function getOrder(Request $request)
    {
        return $this->orderServices->getOrderUser();
    }
}
