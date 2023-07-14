<?php

namespace App\Http\Resources\CheckIn;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckInResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>$this->id,
            'event_name' =>$this->ticket->event->name,
            'event_at'=>$this->ticket->event->date,
            'ticket_type' =>$this->ticket->name,
            'order_name' =>$this->name,
            'order_code' =>$this->code,
            'nik' =>$this->no_ktp,
            'checkIn'=>$this->check_in ? false :   true
        ];
    }
}
