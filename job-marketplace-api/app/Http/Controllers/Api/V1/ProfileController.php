<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Profile\UpdateProfileRequest;
use App\Http\Requests\Api\V1\Profile\UploadProfilePhotoRequest;
use App\Models\District;
use App\Models\Upazila;
use App\Models\UserProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Get My Profile
    |--------------------------------------------------------------------------
    */

    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        $user->load([
            'profile.division',
            'profile.district',
            'profile.upazila',
        ]);

        $profile = $user->profile;

        return response()->json([
            'success' => true,
            'data' => [
                'user_id' => $user->id,
                'mobile' => $user->mobile,
                'mobile_verified_at' => $user->mobile_verified_at,
                'status' => $user->status,

                'profile' => $profile ? [
                    'full_name' => $profile->full_name,

                    'profile_photo' => $profile->profile_photo
                        ? asset(
                            'storage/' .
                            $profile->profile_photo
                        )
                        : null,

                    'date_of_birth' => $profile->date_of_birth
                        ? $profile->date_of_birth->format('Y-m-d')
                        : null,

                    'gender' => $profile->gender,

                    'division' => $profile->division ? [
                        'id' => $profile->division->id,
                        'name_en' => $profile->division->name_en,
                        'name_bn' => $profile->division->name_bn,
                    ] : null,

                    'district' => $profile->district ? [
                        'id' => $profile->district->id,
                        'name_en' => $profile->district->name_en,
                        'name_bn' => $profile->district->name_bn,
                    ] : null,

                    'upazila' => $profile->upazila ? [
                        'id' => $profile->upazila->id,
                        'name_en' => $profile->upazila->name_en,
                        'name_bn' => $profile->upazila->name_bn,
                        'type' => $profile->upazila->type,
                    ] : null,

                    'present_address' =>
                        $profile->present_address,

                    'permanent_address' =>
                        $profile->permanent_address,

                ] : null,
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Update My Profile
    |--------------------------------------------------------------------------
    */

    public function update(
        UpdateProfileRequest $request
    ): JsonResponse {
        $user = $request->user();

        $data = $request->validated();


        /*
        |--------------------------------------------------------------------------
        | Validate Division -> District Relationship
        |--------------------------------------------------------------------------
        */

        if (
            !empty($data['district_id']) &&
            empty($data['division_id'])
        ) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Division is required when district is selected.',
            ], 422);
        }


        if (
            !empty($data['division_id']) &&
            !empty($data['district_id'])
        ) {
            $districtExists = District::query()
                ->where(
                    'id',
                    $data['district_id']
                )
                ->where(
                    'division_id',
                    $data['division_id']
                )
                ->where('status', 1)
                ->exists();

            if (!$districtExists) {
                return response()->json([
                    'success' => false,
                    'message' =>
                        'Selected district does not belong to the selected division.',
                ], 422);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Validate District -> Upazila Relationship
        |--------------------------------------------------------------------------
        */

        if (
            !empty($data['upazila_id']) &&
            empty($data['district_id'])
        ) {
            return response()->json([
                'success' => false,
                'message' =>
                    'District is required when upazila/thana is selected.',
            ], 422);
        }


        if (
            !empty($data['district_id']) &&
            !empty($data['upazila_id'])
        ) {
            $upazilaExists = Upazila::query()
                ->where(
                    'id',
                    $data['upazila_id']
                )
                ->where(
                    'district_id',
                    $data['district_id']
                )
                ->where('status', 1)
                ->exists();

            if (!$upazilaExists) {
                return response()->json([
                    'success' => false,
                    'message' =>
                        'Selected upazila/thana does not belong to the selected district.',
                ], 422);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Create / Update Profile
        |--------------------------------------------------------------------------
        */

        $profile = UserProfile::updateOrCreate(
            [
                'user_id' => $user->id,
            ],
            [
                'full_name' =>
                    $data['full_name'],

                'date_of_birth' =>
                    $data['date_of_birth'] ?? null,

                'gender' =>
                    $data['gender'] ?? null,

                'division_id' =>
                    $data['division_id'] ?? null,

                'district_id' =>
                    $data['district_id'] ?? null,

                'upazila_id' =>
                    $data['upazila_id'] ?? null,

                'present_address' =>
                    $data['present_address'] ?? null,

                'permanent_address' =>
                    $data['permanent_address'] ?? null,
            ]
        );


        $profile->load([
            'division',
            'district',
            'upazila',
        ]);


        return response()->json([
            'success' => true,
            'message' =>
                'Profile updated successfully.',

            'data' => [
                'user_id' => $user->id,
                'mobile' => $user->mobile,

                'profile' => [
                    'full_name' =>
                        $profile->full_name,

                    'profile_photo' =>
                        $profile->profile_photo
                            ? asset(
                                'storage/' .
                                $profile->profile_photo
                            )
                            : null,

                    'date_of_birth' =>
                        $profile->date_of_birth
                            ? $profile->date_of_birth
                                ->format('Y-m-d')
                            : null,

                    'gender' =>
                        $profile->gender,

                    'division' =>
                        $profile->division,

                    'district' =>
                        $profile->district,

                    'upazila' =>
                        $profile->upazila,

                    'present_address' =>
                        $profile->present_address,

                    'permanent_address' =>
                        $profile->permanent_address,
                ],
            ],
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Upload Profile Photo
    |--------------------------------------------------------------------------
    */

    public function uploadPhoto(
        UploadProfilePhotoRequest $request
    ): JsonResponse {
        $user = $request->user();

        $profile = UserProfile::firstOrCreate([
            'user_id' => $user->id,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Delete Previous Photo
        |--------------------------------------------------------------------------
        */

        if (
            $profile->profile_photo &&
            Storage::disk('public')->exists(
                $profile->profile_photo
            )
        ) {
            Storage::disk('public')->delete(
                $profile->profile_photo
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Store New Photo
        |--------------------------------------------------------------------------
        */

        $path = $request
            ->file('profile_photo')
            ->store(
                'profile-photos/' . $user->id,
                'public'
            );


        $profile->update([
            'profile_photo' => $path,
        ]);


        return response()->json([
            'success' => true,
            'message' =>
                'Profile photo uploaded successfully.',

            'data' => [
                'profile_photo' =>
                    asset('storage/' . $path),
            ],
        ]);
    }
}