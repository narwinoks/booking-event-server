<?php

namespace App\Http\Resources\Ticket;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'categories' => $this->category->name,
            'name' => $this->name,
            'slug' => $this->slug,
            'date' => Carbon::createFromFormat('Y-m-d', $this->date)->format('d M Y'),
            'location' => $this->location,
            'thumbnail' => asset('assets/files/img/thumbnail/' . $this->thumbnail),
            'description' => $this->description,
            'other' => $this->other,
            'highlight' => $this->highlight,
            'ticket' => TicketDetailResource::collection($this->ticket)
        ];
    }
}
