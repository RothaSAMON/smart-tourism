<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBusinessRequest;
use App\Http\Requests\Api\UpdateBusinessRequest;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BusinessController extends Controller
{
    /**
     * Display a listing of businesses.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Business::query()
            ->with('user')
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('category')) {
            $query->where('category', $request->string('category')->toString());
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $perPage = min(max($request->integer('per_page', 10), 1), 100);

        return BusinessResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created business (always defaults to pending for admin approval).
     */
    public function store(StoreBusinessRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['status'] = 'pending';

        $business = Business::create($data)->load('user');

        return (new BusinessResource($business))
            ->additional(['message' => 'Business submitted successfully and is pending approval.'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified business.
     */
    public function show(Business $business): BusinessResource
    {
        return new BusinessResource($business->load('user'));
    }

    /**
     * Update the specified business.
     */
    public function update(UpdateBusinessRequest $request, Business $business): BusinessResource
    {
        $business->update($request->validated());

        return (new BusinessResource($business->fresh('user')))
            ->additional(['message' => 'Business updated successfully.']);
    }

    /**
     * Remove the specified business.
     */
    public function destroy(Business $business): JsonResponse
    {
        $business->delete();

        return response()->json([
            'message' => 'Business deleted successfully.',
        ]);
    }
}

