<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Employer\SaveEmployerProfileRequest;
use App\Models\EmployerProfile;
use Illuminate\Http\JsonResponse;
use Throwable;

class EmployerProfileController extends Controller
{
    /**
     * Get logged-in user's Employer / Job Hire profile.
     */
    public function show(): JsonResponse
    {
        $user = request()->user();

        $employerProfile = EmployerProfile::query()
            ->where('user_id', $user->id)
            ->first();

        if (!$employerProfile) {
            return response()->json([
                'success' => false,
                'message' => 'Employer profile not found.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Employer profile retrieved successfully.',
            'data' => [
                'id' => $employerProfile->id,
                'user_id' => $employerProfile->user_id,
                'employer_type' => $employerProfile->employer_type,
                'business_name' => $employerProfile->business_name,
                'business_type' => $employerProfile->business_type,
                'business_description' => $employerProfile->business_description,
                'status' => $employerProfile->status,
            ],
        ], 200);
    }

    /**
     * Create or update logged-in user's Employer / Job Hire profile.
     */
    public function save(
        SaveEmployerProfileRequest $request
    ): JsonResponse {
        $user = $request->user();

        try {
            $employerType = $request->input('employer_type');

            $employerProfile = EmployerProfile::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'employer_type' => $employerType,

                    'business_name' =>
                        $employerType === 'business'
                            ? $request->input('business_name')
                            : null,

                    'business_type' =>
                        $employerType === 'business'
                            ? $request->input('business_type')
                            : null,

                    'business_description' =>
                        $employerType === 'business'
                            ? $request->input('business_description')
                            : null,
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Refresh Employer Profile
            |--------------------------------------------------------------------------
            |
            | Database default values যেমন status = 1 নতুন record create হওয়ার
            | পরে current Eloquent model-এ সাথে সাথে নাও আসতে পারে।
            | তাই database থেকে fresh record reload করছি।
            |
            */

            $employerProfile->refresh();

            return response()->json([
                'success' => true,
                'message' => 'Employer profile saved successfully.',
                'data' => [
                    'id' => $employerProfile->id,
                    'user_id' => $employerProfile->user_id,
                    'employer_type' => $employerProfile->employer_type,
                    'business_name' => $employerProfile->business_name,
                    'business_type' => $employerProfile->business_type,
                    'business_description' => $employerProfile->business_description,
                    'status' => $employerProfile->status,
                ],
            ], 200);

        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to save employer profile. Please try again.',
            ], 500);
        }
    }
}