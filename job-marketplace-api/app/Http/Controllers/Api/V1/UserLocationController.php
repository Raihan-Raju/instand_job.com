<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Location\UpdateUserLocationRequest;
use App\Models\UserLocation;
use Illuminate\Http\JsonResponse;
use Throwable;

class UserLocationController extends Controller
{
    /**
     * Get logged-in user's current GPS location.
     */
    public function show(): JsonResponse
    {
        $user = request()->user();

        $location = UserLocation::query()
            ->where('user_id', $user->id)
            ->first();

        if (!$location) {
            return response()->json([
                'success' => false,
                'message' => 'Current location not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Current location retrieved successfully.',
            'data' => [
                'latitude' => $location->latitude,
                'longitude' => $location->longitude,
                'accuracy' => $location->accuracy,
                'location_updated_at' => $location->location_updated_at,
            ],
        ], 200);
    }

    /**
     * Create or update logged-in user's current GPS location.
     */
    public function update(
        UpdateUserLocationRequest $request
    ): JsonResponse {
        $user = $request->user();

        try {
            $location = UserLocation::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'accuracy' => $request->input('accuracy'),
                    'location_updated_at' => now(),
                ]
            );

            $location->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Current location updated successfully.',
                'data' => [
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'accuracy' => $location->accuracy,
                    'location_updated_at' => $location->location_updated_at,
                ],
            ], 200);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update current location. Please try again.',
            ], 500);
        }
    }
}