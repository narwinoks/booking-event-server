<?php

namespace App\Services\Events;

use App\Http\Resources\Events\EventsCollection;
use App\Http\Resources\Ticket\TicketResource;
use App\Http\Resources\TicketEventResource;
use App\Interfaces\EventInterface;
use App\Responses\OrderDetail\OrderDetail;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use function App\Helpers\error;

class EventServices
{
    use ApiResponse;
    protected $eventInterface;
    public function __construct(EventInterface $eventInterface)
    {
        $this->eventInterface = $eventInterface;
    }
    public function getEvents($request)
    {
        $data = $this->eventInterface->getEvent($request);
        return new EventsCollection($data);
    }

    public function showEvent($slug)
    {
        $data = $this->eventInterface->showEvent($slug);
        $response = new TicketResource($data);
        return $response;
    }

    public function getEventByTicket($ticketId)
    {
        try {
            $event = $this->eventInterface->getEventByTicket($ticketId);
            // return $event;
            if ($event) {
                return $this->successResponse(new TicketEventResource($event), 200, "successfully");
            } else {
                return $this->errorResponse("data not found", 404);
            }
        } catch (\Throwable $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }
    }

    public  function getEventActive(){
        try {
            $data =$this->eventInterface->getEventActive();
        }catch (Exception $exception) {
            $error =array_merge(OrderDetail::GET_ORDER_FAILED,['stack'=>$exception->getMessage()]);
            throw new HttpResponseException(error($error));
        }
        return $data;
    }
}
