<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreAttractionRequest;
use App\Http\Requests\Api\UpdateAttractionRequest;
use App\Http\Resources\AttractionResource;
use App\Models\Attraction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class AttractionController extends Controller
{
    /**
     * Display a listing of attractions.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Attraction::query()
            ->with(['province', 'category'])
            ->latest();

        if ($request->filled('province_id')) {
            $query->where('province_id', $request->integer('province_id'));
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->integer('category_id'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $perPage = min(max($request->integer('per_page', 10), 1), 100);

        return AttractionResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created attraction.
     */
    public function store(StoreAttractionRequest $request): JsonResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('attractions', 'public');
        }

        $attraction = Attraction::create($data)->load(['province', 'category']);

        return (new AttractionResource($attraction))
            ->additional(['message' => 'Attraction created successfully.'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified attraction.
     */
    public function show(Attraction $attraction): AttractionResource
    {
        return new AttractionResource($attraction->load(['province', 'category']));
    }

    /**
     * Update the specified attraction.
     */
    public function update(UpdateAttractionRequest $request, Attraction $attraction): AttractionResource
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($attraction->image && ! str_starts_with($attraction->image, 'http')) {
                Storage::disk('public')->delete($attraction->image);
            }

            $data['image'] = $request->file('image')->store('attractions', 'public');
        }

        $attraction->update($data);

        return (new AttractionResource($attraction->fresh(['province', 'category'])))
            ->additional(['message' => 'Attraction updated successfully.']);
    }

    /**
     * Remove the specified attraction.
     */
    public function destroy(Attraction $attraction): JsonResponse
    {
        if ($attraction->image && ! str_starts_with($attraction->image, 'http')) {
            Storage::disk('public')->delete($attraction->image);
        }

        $attraction->delete();

        return response()->json([
            'message' => 'Attraction deleted successfully.',
        ]);
    }
}
