<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ticket_id' => $this->id,
            'thumbnail' => asset('assets/files/img/thumbnail/'.$this->event->thumbnail),
            'event_name' => $this->event->name,
            'event_date' =>Carbon::createFromFormat('Y-m-d', $this->event->date)->format('d M Y'),
            'ticket_type' => $this->name,
            "price" => $this->price,
        ];
    }
}
