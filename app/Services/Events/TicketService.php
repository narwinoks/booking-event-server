<?php

namespace App\Services\Events;

use App\Http\Resources\Ticket\TicketDetailResource;
use App\Interfaces\EventInterface;
use App\Interfaces\TicketsInterface;
use App\Traits\ApiResponse;

class TicketService
{
    use ApiResponse;
    protected $eventInterface;
    protected $ticketsInterface;
    public function __construct(EventInterface $eventInterface, TicketsInterface $ticketsInterface)
    {
        $this->eventInterface = $eventInterface;
        $this->ticketsInterface = $ticketsInterface;
    }
    public function getTicketBySlugEvent($request)
    {

        try {
            $slug = $request->get('slug');
            $event = $this->eventInterface->showEvent($slug);
            $eventId = $event->id;
            $date = $event->date;
            $tickets = $this->ticketsInterface->getTicketByEvent($eventId);
            $ticketsData = $tickets->map(function ($ticket) use ($date) {
                $ticket['date'] = $date;
                return $ticket;
            });
            $response = TicketDetailResource::collection($ticketsData);
            return $this->successResponse($response, 200, "Successfully");
        } catch (\Throwable $e) {
            $result = [
                'status' => $e->getCode(),
                'message' => $e->getMessage()
            ];
            return $this->errorResponse($result['message'], 500);
        }
    }
}
