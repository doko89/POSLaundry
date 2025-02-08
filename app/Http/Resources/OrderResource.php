<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'service' => [
                'id' => $this->service->id,
                'name' => $this->service->name,
                'price' => $this->service->price,
            ],
            'weight' => $this->weight,
            'priority' => $this->priority,
            'status' => $this->status,
            'total' => $this->total,
            'notes' => $this->notes,
            'estimated_completion_time' => $this->estimated_completion_time,
            'completed_at' => $this->completed_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'timeline' => TimelineResource::collection($this->whenLoaded('timeline')),
        ];
    }
} 