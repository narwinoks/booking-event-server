<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'date' => Carbon::createFromFormat('Y-m-d', $this->date)->format('d M Y'),
            'location' => $this->location,
            'price' => $this->ticket->min('price'),
            'thumbnail' => asset('assets/files/img/thumbnail/' . $this->thumbnail)
        ];
    }
}
