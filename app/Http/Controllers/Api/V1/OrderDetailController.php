<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateShowRequest;
use App\Http\Resources\CheckIn\CheckInResource;
use App\Responses\OrderDetail\OrderDetail;
use App\Services\Orders\OrderDetailService;
use Illuminate\Http\Request;
use function App\Helpers\success;

class OrderDetailController extends Controller
{
    protected OrderDetailService  $orderItemsService;
    public function __construct(OrderDetailService $orderItemsService)
    {
        $this->orderItemsService =$orderItemsService;
    }

    public function getOrderDetailList(ValidateShowRequest $request){
       $eventId         = $request->event_id;
       $search          = $request->search;
       $data            = $this->orderItemsService->getAllOrderDetail($eventId,$search);
       $response        = CheckInResource::collection($data);
       $tokenTransform  = json_decode($response->toResponse($request)->getContent(), true);
       return success(OrderDetail::GET_ORDER_SUCCESS,$tokenTransform);
    }
}
