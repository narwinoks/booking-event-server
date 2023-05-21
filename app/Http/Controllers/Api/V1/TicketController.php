<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetTicketRequest;
use App\Services\Events\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected $ticketServices;
    public function __construct(TicketService $ticketService)
    {
        $this->ticketServices = $ticketService;
    }
    public function getTicketEvent(GetTicketRequest $request)
    {
        return  $this->ticketServices->getTicketBySlugEvent($request);
    }
}
