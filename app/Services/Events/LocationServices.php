<?php

namespace App\Services\Events;

use App\Interfaces\EventInterface;
use App\Traits\ApiResponse;

class LocationServices
{
    use ApiResponse;
    protected $eventInterface;
    public function __construct(EventInterface $eventInterface)
    {
        $this->eventInterface = $eventInterface;
    }
    public function getLocation()
    {
        $locations = $this->eventInterface->getLocation();
        return $this->successResponse($locations, 200, "Successfully");
    }
}
