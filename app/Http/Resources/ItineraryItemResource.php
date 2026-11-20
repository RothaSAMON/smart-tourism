<?php

namespace App\Http\Resources;

use App\Models\ItineraryItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin ItineraryItem
 */
class ItineraryItemResource extends JsonResource
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
            'itinerary_id' => $this->itinerary_id,
            'attraction_id' => $this->attraction_id,
            'day_number' => (int) $this->day_number,
            'visit_order' => (int) $this->visit_order,
            'attraction' => $this->whenLoaded('attraction', fn () => [
                'id' => $this->attraction->id,
                'name' => $this->attraction->name,
                'address' => $this->attraction->address,
                'entrance_fee' => (float) $this->attraction->entrance_fee,
                'average_rating' => (float) $this->attraction->average_rating,
                'image_url' => $this->attraction->image
                    ? (str_starts_with($this->attraction->image, 'http')
                        ? $this->attraction->image
                        : Storage::disk('public')->url($this->attraction->image))
                    : null,
            ]),
        ];
    }
}

