<?php

namespace App\Interfaces;

interface EventInterface
{
    public function getEvent($request);
    public function showEvent($slug);
    public function getLocation();
    public function getEventByTicket($ticketId);
    public function getEventActive();
}
