<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\UserPresence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class UserPresenceController extends Controller
{
    /**
     * Get logged-in user's current presence.
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        $presence = UserPresence::query()
            ->where('user_id', $user->id)
            ->first();

        if (!$presence) {
            return response()->json([
                'success' => true,
                'message' => 'Presence retrieved successfully.',
                'data' => [
                    'is_online' => false,
                    'last_seen_at' => null,
                    'last_activity_at' => null,
                ],
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Presence retrieved successfully.',
            'data' => [
                'is_online' => $presence->is_online,
                'last_seen_at' => $presence->last_seen_at,
                'last_activity_at' => $presence->last_activity_at,
            ],
        ], 200);
    }

    /**
     * Mark logged-in user as online.
     *
     * Can be called when:
     * - app/web becomes active
     * - user logs in
     * - connection is restored
     */
    public function online(Request $request): JsonResponse
    {
        $user = $request->user();

        try {
            $presence = UserPresence::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'is_online' => true,
                    'last_activity_at' => now(),
                ]
            );

            $presence->refresh();

            return response()->json([
                'success' => true,
                'message' => 'User is now online.',
                'data' => [
                    'is_online' => $presence->is_online,
                    'last_seen_at' => $presence->last_seen_at,
                    'last_activity_at' => $presence->last_activity_at,
                ],
            ], 200);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update presence. Please try again.',
            ], 500);
        }
    }

    /**
     * Presence heartbeat.
     *
     * Called periodically while app/web is active.
     */
    public function heartbeat(Request $request): JsonResponse
    {
        $user = $request->user();

        try {
            $presence = UserPresence::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'is_online' => true,
                    'last_activity_at' => now(),
                ]
            );

            $presence->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Presence heartbeat updated successfully.',
                'data' => [
                    'is_online' => $presence->is_online,
                    'last_activity_at' => $presence->last_activity_at,
                ],
            ], 200);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update presence heartbeat. Please try again.',
            ], 500);
        }
    }

    /**
     * Mark logged-in user as offline.
     */
    public function offline(Request $request): JsonResponse
    {
        $user = $request->user();

        try {
            $now = now();

            $presence = UserPresence::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'is_online' => false,
                    'last_seen_at' => $now,
                    'last_activity_at' => $now,
                ]
            );

            $presence->refresh();

            return response()->json([
                'success' => true,
                'message' => 'User is now offline.',
                'data' => [
                    'is_online' => $presence->is_online,
                    'last_seen_at' => $presence->last_seen_at,
                    'last_activity_at' => $presence->last_activity_at,
                ],
            ], 200);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update presence. Please try again.',
            ], 500);
        }
    }
}