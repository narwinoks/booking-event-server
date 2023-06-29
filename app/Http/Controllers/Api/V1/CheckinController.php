<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Checkin\CheckinService;

class CheckinController extends Controller
{
    protected  CheckinService $checkinService;
    public  function __construct(CheckinService $checkinService)
    {
        $this->checkinService = $checkinService;
    }

    public function checkin(Request $request)
    {
        $orderId = $request->order_item_id;
        $data = $this->checkinService->Checkin($orderId);
        return  $data;
    }
}
