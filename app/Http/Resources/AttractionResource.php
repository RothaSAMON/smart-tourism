<?php

namespace App\Http\Resources;

use App\Models\Attraction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Attraction
 */
class AttractionResource extends JsonResource
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
            'province_id' => $this->province_id,
            'category_id' => $this->category_id,
            'province' => $this->whenLoaded('province', fn () => [
                'id' => $this->province->id,
                'name' => $this->province->name,
            ]),
            'category' => $this->whenLoaded('category', fn () => [
                'id' => $this->category->id,
                'name' => $this->category->name,
            ]),
            'name' => $this->name,
            'description' => $this->description,
            'latitude' => $this->latitude !== null ? (float) $this->latitude : null,
            'longitude' => $this->longitude !== null ? (float) $this->longitude : null,
            'address' => $this->address,
            'opening_hour' => $this->opening_hour,
            'closing_hour' => $this->closing_hour,
            'entrance_fee' => (float) $this->entrance_fee,
            'average_rating' => (float) $this->average_rating,
            'image' => $this->image,
            'image_url' => $this->image
                ? (str_starts_with($this->image, 'http') ? $this->image : Storage::disk('public')->url($this->image))
                : null,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
