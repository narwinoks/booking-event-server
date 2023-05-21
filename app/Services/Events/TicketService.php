<?php

namespace App\Services\Events;

use App\Http\Resources\Ticket\TicketDetailResource;
use App\Repositories\EventRepository;
use App\Repositories\TicketsRepository;
use App\Traits\ApiResponse;

class TicketService
{
    use ApiResponse;
    protected $eventRepository;
    protected $ticketsRepository;
    public function __construct(EventRepository $eventRepository, TicketsRepository $ticketsRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->ticketsRepository = $ticketsRepository;
    }
    public function getTicketBySlugEvent($request)
    {

        try {
            $slug = $request->get('slug');
            $event = $this->eventRepository->showEvent($slug);
            $eventId = $event->id;
            $date = $event->date;
            $tickets = $this->ticketsRepository->getTicketByEvent($eventId);
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
