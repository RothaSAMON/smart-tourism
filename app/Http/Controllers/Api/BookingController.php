<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreBookingRequest;
use App\Http\Requests\Api\UpdateBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BookingController extends Controller
{
    /**
     * Display a listing of bookings.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Booking::query()
            ->with(['user', 'business'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        if ($request->filled('business_id')) {
            $query->where('business_id', $request->integer('business_id'));
        }

        if ($request->filled('booking_date')) {
            $query->whereDate('booking_date', $request->string('booking_date')->toString());
        }

        $perPage = min(max($request->integer('per_page', 10), 1), 100);

        return BookingResource::collection($query->paginate($perPage));
    }

    /**
     * Store a newly created booking (always defaults to pending).
     */
    public function store(StoreBookingRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['status'] = 'pending';

        $booking = Booking::create($data)->load(['user', 'business']);

        return (new BookingResource($booking))
            ->additional(['message' => 'Booking created successfully and is pending confirmation.'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking): BookingResource
    {
        return new BookingResource($booking->load(['user', 'business']));
    }

    /**
     * Update the specified booking.
     */
    public function update(UpdateBookingRequest $request, Booking $booking): BookingResource
    {
        $booking->update($request->validated());

        return (new BookingResource($booking->fresh(['user', 'business'])))
            ->additional(['message' => 'Booking updated successfully.']);
    }

    /**
     * Remove the specified booking.
     */
    public function destroy(Booking $booking): JsonResponse
    {
        $booking->delete();

        return response()->json([
            'message' => 'Booking deleted successfully.',
        ]);
    }
}

