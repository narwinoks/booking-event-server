<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\UserOrderItemResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserOrderDetailResource extends JsonResource
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
            'status' => $this->status,
            'date' => Carbon::parse($this->created_at)->format('d M Y'),
            'items' => UserOrderItemResource::collection($this->orderItem)
        ];
    }
}
