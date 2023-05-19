<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetEventRequest;
use App\Services\Events\EventServices;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventServices;
    public function __construct(EventServices $eventServices)
    {
        $this->eventServices = $eventServices;
    }
    public function index(GetEventRequest $request)
    {
        return $this->eventServices->getEvents($request);
    }

    public function show($slug)
    {
        return $this->eventServices->showEvent($slug);
    }
}
