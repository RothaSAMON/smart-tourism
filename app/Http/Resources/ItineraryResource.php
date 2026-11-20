<?php

namespace App\Http\Resources;

use App\Models\Itinerary;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Itinerary
 */
class ItineraryResource extends JsonResource
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
            'user_id' => $this->user_id,
            'traveler' => $this->whenLoaded('user', fn () => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ]),
            'title' => $this->title,
            'total_days' => (int) $this->total_days,
            'budget' => (float) $this->budget,
            'items' => ItineraryItemResource::collection($this->whenLoaded('items')),
            'days' => $this->whenLoaded('items', function () {
                return $this->items
                    ->groupBy('day_number')
                    ->map(fn ($dayItems, $dayNumber) => [
                        'day_number' => (int) $dayNumber,
                        'destinations' => ItineraryItemResource::collection($dayItems),
                    ])
                    ->values();
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}

