<?php

namespace App\Services\Events;

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
        return $this->successResponse($data, 200, "Successfully");
    }
}
