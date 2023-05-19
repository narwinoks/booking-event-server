<?php

namespace App\Repositories;

use App\Interfaces\EventInterface;
use App\Models\Event;

class EventRepository implements EventInterface
{
    public function getEvent($request)
    {
        return Event::all();
    }
}
