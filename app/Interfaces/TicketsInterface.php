<?php

namespace App\Interfaces;


interface TicketsInterface
{
    public function getTicketByEvent($id);
    public function getTicketById($id);
    public function updateTicketSoldOut($id, $data);
}
