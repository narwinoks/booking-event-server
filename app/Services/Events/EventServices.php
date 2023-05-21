<?php

namespace App\Services\Events;

use App\Http\Resources\Events\EventsCollection;
use App\Http\Resources\Ticket\TicketResource;
use App\Interfaces\EventInterface;
use App\Traits\ApiResponse;

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
}
