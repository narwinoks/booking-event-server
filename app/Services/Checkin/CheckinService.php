<?php

namespace App\Services\Checkin;

use App\Enums\CheckInStatus;
use app\Interfaces\CheckinInterface;
use App\Interfaces\OrderDetailInterface;
use App\Traits\ApiResponse;
use Carbon\Carbon;

class CheckinService
{
    use ApiResponse;
    protected $checkRepository;
    protected $orderItemRepository;
    public function __construct(CheckinInterface $checkinInterface, OrderDetailInterface $orderItemRepository)
    {
        $this->checkRepository = $checkinInterface;
        $this->orderItemRepository = $orderItemRepository;
    }
    public function Checkin($code)
    {
        try {
            $orderItem = $this->orderItemRepository->getOrderByCode($code);
            if (!$orderItem){
                return  $this->errorResponse("data not found", 404);
            }

            $data = [
                'check_in' => CheckInStatus::CHECKIN,
            ];
            $result = $this->orderItemRepository->updateOrderItem($orderItem->id, $data);
            return  $this->successResponse($result,200,"successfully" );
        }catch (\Throwable $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];

            return $this->errorResponse($result['message'], 500);
        }
    }
    public function Checkin2($orderId)
    {

        try {
            $data = [
                'order_item_id' => $orderId,
                'status' => CheckInStatus::CHECKIN,
                'time' => Carbon::now()
            ];
            $data = $this->checkRepository->checkin($data);
            return  $this->successResponse($data, 200, "successfully");
        } catch (\Throwable $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }
    }
}
