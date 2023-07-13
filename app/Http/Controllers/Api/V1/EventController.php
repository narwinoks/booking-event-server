<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetEventRequest;
use App\Http\Resources\CheckIn\CheckInResource;
use App\Http\Resources\Events\EventActiveResource;
use App\Responses\ServerResponse;
use App\Services\Events\EventServices;
use Illuminate\Http\Request;
use function App\Helpers\success;

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

    public function getEventByTicket(Request $request, $ticketId)
    {
        return $this->eventServices->getEventByTicket($ticketId);
    }
    public  function getEventActive(Request $request){
        $data = $this->eventServices->getEventActive();
        $response        = EventActiveResource::collection($data);
        $responseTransform  = json_decode($response->toResponse($request)->getContent(), true);
        return success(ServerResponse::SUCCESS_RESPONSE,$responseTransform);
    }
}
