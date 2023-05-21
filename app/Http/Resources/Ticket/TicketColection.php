<?php

namespace App\Http\Resources\Ticket;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TicketColection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Successfully',
            'data' => $this->collection
        ];
    }
}
