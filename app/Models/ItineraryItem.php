<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('table_itinerary_items')]
#[Fillable([
    'itinerary_id',
    'attraction_id',
    'day_number',
    'visit_order',
])]
class ItineraryItem extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'day_number' => 'integer',
            'visit_order' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Itinerary, $this>
     */
    public function itinerary(): BelongsTo
    {
        return $this->belongsTo(Itinerary::class);
    }

    /**
     * @return BelongsTo<Attraction, $this>
     */
    public function attraction(): BelongsTo
    {
        return $this->belongsTo(Attraction::class);
    }
}

