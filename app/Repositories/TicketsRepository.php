<?php

namespace App\Repositories;

use App\Interfaces\TicketsInterface;
use App\Models\Ticket;

class TicketsRepository  implements TicketsInterface
{
    public function getTicketByEvent($id)
    {
        return Ticket::where('event_id', $id)->get();
    }
}
