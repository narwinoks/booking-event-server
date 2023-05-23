<?php

namespace App\Services\Orders;

use App\Interfaces\TicketsInterface;
use App\Mail\SendAttachmentEmail;
use Illuminate\Support\Facades\Mail;

class SendMailServices
{
    protected $ticketsInterface;
    public function __construct(TicketsInterface $ticketsInterface)
    {
        $this->ticketsInterface = $ticketsInterface;
    }
    public function sendMailTicket($data)
    {
        $mailData = [
            'username' => "Wins",
            'url' => "http://localhost:8080",
        ];
        Mail::to($data['email'])->send(new SendAttachmentEmail($mailData));
    }
}
