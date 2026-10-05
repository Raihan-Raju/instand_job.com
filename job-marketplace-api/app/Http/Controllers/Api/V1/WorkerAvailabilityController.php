<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\JobSeekerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class WorkerAvailabilityController extends Controller
{
    /**
     * Get logged-in Job Seeker's availability.
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        $jobSeekerProfile = JobSeekerProfile::query()
            ->where('user_id', $user->id)
            ->first();

        if (!$jobSeekerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Job Seeker profile not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Availability retrieved successfully.',
            'data' => [
                'is_available' => $jobSeekerProfile->is_available,
                'availability_status' =>
                    $jobSeekerProfile->is_available
                        ? 'available'
                        : 'not_available',
            ],
        ], 200);
    }

    /**
     * Update logged-in Job Seeker's manual availability.
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'is_available' => [
                'required',
                'boolean',
            ],
        ]);

        $user = $request->user();

        $jobSeekerProfile = JobSeekerProfile::query()
            ->where('user_id', $user->id)
            ->first();

        if (!$jobSeekerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Job Seeker profile not found.',
                'data' => null,
            ], 404);
        }

        try {
            $jobSeekerProfile->is_available =
                $request->boolean('is_available');

            $jobSeekerProfile->save();

            $jobSeekerProfile->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Availability updated successfully.',
                'data' => [
                    'is_available' =>
                        $jobSeekerProfile->is_available,

                    'availability_status' =>
                        $jobSeekerProfile->is_available
                            ? 'available'
                            : 'not_available',
                ],
            ], 200);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' =>
                    'Unable to update availability. Please try again.',
            ], 500);
        }
    }
}