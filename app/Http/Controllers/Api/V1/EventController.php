<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Events\EventServices;
use Illuminate\Http\Request;

class EventController extends Controller
{
    protected $eventServices;
    public function __construct(EventServices $eventServices)
    {
        $this->eventServices = $eventServices;
    }
    public function index(Request $request)
    {
        return $this->eventServices->getEvents($request->all());
    }
}
