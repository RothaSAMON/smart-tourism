<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreItineraryItemRequest;
use App\Http\Requests\Api\UpdateItineraryItemRequest;
use App\Http\Resources\ItineraryItemResource;
use App\Models\Itinerary;
use App\Models\ItineraryItem;
use Illuminate\Http\JsonResponse;

class ItineraryItemController extends Controller
{
    /**
     * Add a destination item to an itinerary.
     */
    public function store(StoreItineraryItemRequest $request, Itinerary $itinerary): JsonResponse
    {
        $item = $itinerary->items()
            ->create($request->validated())
            ->load('attraction');

        return (new ItineraryItemResource($item))
            ->additional(['message' => 'Destination added to itinerary successfully.'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Update a destination item inside an itinerary.
     */
    public function update(
        UpdateItineraryItemRequest $request,
        Itinerary $itinerary,
        ItineraryItem $item
    ): ItineraryItemResource {
        $item->update($request->validated());

        return (new ItineraryItemResource($item->fresh('attraction')))
            ->additional(['message' => 'Itinerary destination updated successfully.']);
    }

    /**
     * Remove a destination item from an itinerary.
     */
    public function destroy(Itinerary $itinerary, ItineraryItem $item): JsonResponse
    {
        $item->delete();

        return response()->json([
            'message' => 'Destination removed from itinerary successfully.',
        ]);
    }
}

