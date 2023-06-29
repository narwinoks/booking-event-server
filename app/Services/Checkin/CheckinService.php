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
    public function Checkin($orderId)
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
