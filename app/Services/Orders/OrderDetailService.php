<?php

namespace App\Services\Orders;
use App\Interfaces\OrderDetailInterface;
use App\Responses\OrderDetail\OrderDetail;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use function App\Helpers\error;


class OrderDetailService
{
    use ApiResponse;

    protected OrderDetailInterface $orderDetailInterface;
    public function __construct(OrderDetailInterface $orderDetailInterface)
    {
        $this->orderDetailInterface = $orderDetailInterface;
    }
    public function getAllOrderDetail($eventId,$search){
//        try {
            $data = $this->orderDetailInterface->getAllOrderItemsByEvent($eventId,$search);
//            if(count($data) <=0){
//                throw new HttpResponseException(error(OrderDetail::GET_ORDER_NOT_FOUND,404));
//            }
//        }catch (\Exception $exception){
//            throw new HttpResponseException(error(OrderDetail::GET_ORDER_NOT_FOUND));
//        }
        return $data;
    }
}
?>
