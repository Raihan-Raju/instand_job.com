<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\JobSeeker\SaveJobSeekerProfileRequest;
use App\Models\JobSeekerProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class JobSeekerProfileController extends Controller
{
    public function save(
        SaveJobSeekerProfileRequest $request
    ): JsonResponse
    {
        $user = $request->user();

        try {
            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | Create / Update Job Seeker Profile
            |--------------------------------------------------------------------------
            */

            $jobSeekerProfile = JobSeekerProfile::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'professional_title' =>
                        $request->input('professional_title'),

                    'about' =>
                        $request->input('about'),

                    'experience_years' =>
                        $request->integer('experience_years'),

                    'hourly_rate' =>
                        $request->input('hourly_rate'),

                    'daily_rate' =>
                        $request->input('daily_rate'),
                ]
            );


            /*
            |--------------------------------------------------------------------------
            | Sync Multiple Categories
            |--------------------------------------------------------------------------
            */

            $jobSeekerProfile
                ->categories()
                ->sync($request->input('category_ids'));


            /*
            |--------------------------------------------------------------------------
            | Sync Multiple Skills
            |--------------------------------------------------------------------------
            */

            $jobSeekerProfile
                ->skills()
                ->sync($request->input('skill_ids'));


            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | Load Categories + Skills
            |--------------------------------------------------------------------------
            */

            $jobSeekerProfile->load([
                'categories' => function ($query) {
                    $query
                        ->select([
                            'job_categories.id',
                            'job_categories.name',
                            'job_categories.slug',
                            'job_categories.icon',
                        ])
                        ->orderBy('job_categories.sort_order')
                        ->orderBy('job_categories.name');
                },

                'skills' => function ($query) {
                    $query
                        ->select([
                            'skills.id',
                            'skills.name',
                            'skills.slug',
                        ])
                        ->orderBy('skills.sort_order')
                        ->orderBy('skills.name');
                },
            ]);


            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' => true,
                'message' => 'Job seeker profile saved successfully.',

                'data' => [
                    'id' =>
                        $jobSeekerProfile->id,

                    'user_id' =>
                        $jobSeekerProfile->user_id,

                    'professional_title' =>
                        $jobSeekerProfile->professional_title,

                    'about' =>
                        $jobSeekerProfile->about,

                    'experience_years' =>
                        $jobSeekerProfile->experience_years,

                    'hourly_rate' =>
                        $jobSeekerProfile->hourly_rate,

                    'daily_rate' =>
                        $jobSeekerProfile->daily_rate,

                    'is_available' =>
                        $jobSeekerProfile->is_available,

                    'status' =>
                        $jobSeekerProfile->status,

                    'categories' =>
                        $jobSeekerProfile->categories,

                    'skills' =>
                        $jobSeekerProfile->skills,
                ],
            ], 200);

        } catch (Throwable $e) {

            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            report($e);

            return response()->json([
                'success' => false,
                'message' =>
                    'Unable to save job seeker profile. Please try again.',
            ], 500);
        }
    }
}