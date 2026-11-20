<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreItineraryRequest;
use App\Http\Requests\Api\UpdateItineraryRequest;
use App\Http\Resources\ItineraryResource;
use App\Models\Itinerary;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class ItineraryController extends Controller
{
    /**
     * Display a listing of itineraries.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Itinerary::query()
            ->with(['user', 'items.attraction'])
            ->latest();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where('title', 'like', "%{$search}%");
        }

        $perPage = min(max($request->integer('per_page', 15), 1), 100);

        return ItineraryResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created itinerary (with optional items).
     */
    public function store(StoreItineraryRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $items = $validated['items'] ?? [];
        unset($validated['items']);

        $itinerary = DB::transaction(function () use ($validated, $items): Itinerary {
            $itinerary = Itinerary::create($validated);

            if (count($items) > 0) {
                $itinerary->items()->createMany($items);
            }

            return $itinerary;
        });

        $itinerary->load(['user', 'items.attraction']);

        return (new ItineraryResource($itinerary))
            ->additional(['message' => 'Itinerary created successfully.'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified itinerary with its day-by-day destinations.
     */
    public function show(Itinerary $itinerary): ItineraryResource
    {
        return new ItineraryResource($itinerary->load(['user', 'items.attraction']));
    }

    /**
     * Update the specified itinerary (and optionally replace its items).
     */
    public function update(UpdateItineraryRequest $request, Itinerary $itinerary): ItineraryResource
    {
        $validated = $request->validated();
        $hasItems = array_key_exists('items', $validated);
        $items = $validated['items'] ?? [];
        unset($validated['items']);

        DB::transaction(function () use ($itinerary, $validated, $hasItems, $items): void {
            if (count($validated) > 0) {
                $itinerary->update($validated);
            }

            if ($hasItems) {
                $itinerary->items()->delete();
                if (count($items) > 0) {
                    $itinerary->items()->createMany($items);
                }
            }
        });

        return (new ItineraryResource($itinerary->fresh(['user', 'items.attraction'])))
            ->additional(['message' => 'Itinerary updated successfully.']);
    }

    /**
     * Remove the specified itinerary.
     */
    public function destroy(Itinerary $itinerary): JsonResponse
    {
        $itinerary->delete();

        return response()->json([
            'message' => 'Itinerary deleted successfully.',
        ]);
    }
}

