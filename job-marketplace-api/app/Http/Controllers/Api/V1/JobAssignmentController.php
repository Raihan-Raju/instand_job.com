<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\JobAssignment;
use App\Models\MarketplaceJob;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JobAssignmentController extends Controller
{
    /**
     * Direct Hire Request.
     */
    public function store(Request $request, int $jobId): JsonResponse
    {
        $request->validate([
            'worker_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        try {
            $assignment = DB::transaction(function () use ($request, $jobId) {

                $hirerId = $request->user()->id;

                $job = MarketplaceJob::where('hirer_id', $hirerId)
                    ->whereIn('status', ['open', 'assigned'])
                    ->lockForUpdate()
                    ->find($jobId);

                if (!$job) {
                    abort(404, 'Marketplace job not found or unavailable.');
                }

                $worker = User::where('id', $request->worker_id)
                    ->lockForUpdate()
                    ->first();

                if (!$worker || $worker->id === $hirerId) {
                    abort(422, 'Invalid worker. Self-hiring is not allowed.');
                }

                if ((int) $worker->status !== 1) {
                    abort(422, 'Worker account is not active.');
                }

                $profile = $worker->jobSeekerProfile;

                if (!$profile || !$profile->status || !$profile->is_available) {
                    abort(422, 'Worker profile is unavailable.');
                }

                $verification = $worker->verification;

                if (!$verification || $verification->verification_status !== 'verified') {
                    abort(422, 'Worker KYC verification is not approved.');
                }

                $presence = $worker->presence;

                if (!$presence || !$presence->is_online) {
                    abort(422, 'Worker is currently offline.');
                }

                $categoryMatch = $profile->categories()
                    ->where('job_categories.id', $job->job_category_id)
                    ->exists();

                if (!$categoryMatch) {
                    abort(422, 'Worker does not belong to this job category.');
                }

                $location = $worker->location;

                if (!$location) {
                    abort(422, 'Worker location is unavailable.');
                }

                // Calculate distance using Haversine formula.
                $earthRadius = 6371;

                $lat1 = deg2rad((float) $job->latitude);
                $lat2 = deg2rad((float) $location->latitude);

                $latDifference = $lat2 - $lat1;

                $lonDifference = deg2rad(
                    (float) $location->longitude - (float) $job->longitude
                );

                $a = sin($latDifference / 2) ** 2
                    + cos($lat1) * cos($lat2)
                    * sin($lonDifference / 2) ** 2;

                $distance = $earthRadius * 2 * atan2(
                    sqrt($a),
                    sqrt(1 - $a)
                );

                if ($distance > (float) $job->search_radius_km) {
                    abort(422, 'Worker is outside the job search radius.');
                }

                $hasActiveJob = JobAssignment::where('worker_id', $worker->id)
                    ->whereIn('status', ['accepted', 'in_progress'])
                    ->exists();

                if ($hasActiveJob) {
                    abort(422, 'Worker is already busy with another job.');
                }

                $acceptedCount = JobAssignment::where(
                    'marketplace_job_id',
                    $job->id
                )
                    ->whereIn('status', ['accepted', 'in_progress'])
                    ->count();

                if ($acceptedCount >= $job->workers_required) {
                    abort(422, 'Required worker limit has already been reached.');
                }

                $existing = JobAssignment::where(
                    'marketplace_job_id',
                    $job->id
                )
                    ->where('worker_id', $worker->id)
                    ->lockForUpdate()
                    ->first();

                if ($existing && !in_array(
                    $existing->status,
                    ['rejected', 'expired', 'cancelled'],
                    true
                )) {
                    abort(422, 'An assignment request already exists for this worker.');
                }

                if ($existing) {
                    $existing->update([
                        'status' => 'pending',
                        'request_type' => 'direct',
                        'requested_at' => now(),
                        'responded_at' => null,
                        'expires_at' => now()->addMinutes(2),
                        'accepted_at' => null,
                        'rejected_at' => null,
                        'started_at' => null,
                        'completed_at' => null,
                        'rejection_reason' => null,
                        'cancellation_reason' => null,
                    ]);

                    return $existing->fresh();
                }

                return JobAssignment::create([
                    'marketplace_job_id' => $job->id,
                    'worker_id' => $worker->id,
                    'status' => 'pending',
                    'request_type' => 'direct',
                    'requested_at' => now(),
                    'expires_at' => now()->addMinutes(2),
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Direct hire request sent successfully.',
                'data' => [
                    'assignment' => $assignment,
                ],
            ], 201);

        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], $e->getStatusCode());

        } catch (\Throwable $e) {
            Log::error('Direct hire request failed.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to send hire request.',
                'data' => null,
            ], 500);
        }
    }


    /**
     * Worker accepts an assignment.
     */
    public function accept(Request $request, int $assignmentId): JsonResponse
    {
        try {
            $assignment = DB::transaction(function () use ($request, $assignmentId) {

                $assignment = JobAssignment::where(
                    'worker_id',
                    $request->user()->id
                )
                    ->lockForUpdate()
                    ->find($assignmentId);

                if (!$assignment) {
                    abort(404, 'Assignment request not found.');
                }

                if ($assignment->status !== 'pending') {
                    abort(422, 'This assignment is no longer pending.');
                }

                if (!$assignment->expires_at || $assignment->expires_at->isPast()) {
                    $assignment->update([
                        'status' => 'expired',
                        'responded_at' => now(),
                    ]);

                    abort(422, 'Assignment request has expired.');
                }

                $job = MarketplaceJob::lockForUpdate()
                    ->find($assignment->marketplace_job_id);

                if (!$job || !in_array($job->status, ['open', 'assigned'], true)) {
                    abort(422, 'This job is no longer available.');
                }

                $activeAssignment = JobAssignment::where(
                    'worker_id',
                    $request->user()->id
                )
                    ->whereIn('status', ['accepted', 'in_progress'])
                    ->lockForUpdate()
                    ->exists();

                if ($activeAssignment) {
                    abort(422, 'You are already busy with another job.');
                }

                $acceptedCount = JobAssignment::where(
                    'marketplace_job_id',
                    $job->id
                )
                    ->whereIn('status', ['accepted', 'in_progress'])
                    ->count();

                if ($acceptedCount >= $job->workers_required) {
                    abort(422, 'Required worker limit has already been reached.');
                }

                $assignment->update([
                    'status' => 'accepted',
                    'responded_at' => now(),
                    'accepted_at' => now(),
                ]);

                $job->update([
                    'status' => 'assigned',
                ]);

                return $assignment->fresh();
            });

            return response()->json([
                'success' => true,
                'message' => 'Job assignment accepted successfully.',
                'data' => [
                    'assignment' => $assignment,
                ],
            ], 200);

        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], $e->getStatusCode());

        } catch (\Throwable $e) {
            Log::error('Assignment acceptance failed.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to accept assignment.',
                'data' => null,
            ], 500);
        }
    }


    /**
     * Worker rejects an assignment.
     */
    public function reject(Request $request, int $assignmentId): JsonResponse
    {
        $request->validate([
            'rejection_reason' => ['nullable', 'string', 'max:1000'],
        ]);

        $assignment = JobAssignment::where(
            'worker_id',
            $request->user()->id
        )->find($assignmentId);

        if (!$assignment) {
            return response()->json([
                'success' => false,
                'message' => 'Assignment request not found.',
                'data' => null,
            ], 404);
        }

        if ($assignment->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This assignment is no longer pending.',
                'data' => null,
            ], 422);
        }

        $assignment->update([
            'status' => 'rejected',
            'responded_at' => now(),
            'rejected_at' => now(),
            'rejection_reason' => $request->input('rejection_reason'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Job assignment rejected successfully.',
            'data' => [
                'assignment' => $assignment->fresh(),
            ],
        ], 200);
    }
}
