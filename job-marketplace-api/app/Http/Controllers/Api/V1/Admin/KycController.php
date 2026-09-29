<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class KycController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Pending KYC List
    |--------------------------------------------------------------------------
    */

    public function pending(): JsonResponse
    {
        $verifications = UserVerification::query()
            ->with([
                'user:id,mobile,status,user_type',
                'user.profile:user_id,full_name,profile_photo',
            ])
            ->where('verification_status', 'pending')
            ->where('verification_method', 'user_submission')
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'message' => 'Pending KYC list retrieved successfully.',
            'data' => $verifications,
        ], 200);
    }


    /*
    |--------------------------------------------------------------------------
    | KYC Details
    |--------------------------------------------------------------------------
    */

    public function show(int $verificationId): JsonResponse
    {
        $verification = UserVerification::query()
            ->with([
                'user:id,mobile,status,user_type',
                'user.profile:user_id,full_name,profile_photo,date_of_birth,gender,division_id,district_id,upazila_id,present_address,permanent_address',
            ])
            ->find($verificationId);

        if (!$verification) {
            return response()->json([
                'success' => false,
                'message' => 'KYC verification record not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'KYC details retrieved successfully.',
            'data' => [
                'id' => $verification->id,
                'user_id' => $verification->user_id,

                'nid_number' => $verification->nid_number,

                'verification_status' =>
                    $verification->verification_status,

                'verification_method' =>
                    $verification->verification_method,

                'rejection_reason' =>
                    $verification->rejection_reason,

                'verified_by' =>
                    $verification->verified_by,

                'verified_at' =>
                    $verification->verified_at,

                'submitted_at' =>
                    $verification->created_at,

                'user' => $verification->user,

                'documents' => [
                    'nid_front_available' =>
                        !empty($verification->nid_front_path),

                    'nid_back_available' =>
                        !empty($verification->nid_back_path),
                ],
            ],
        ], 200);
    }


    /*
    |--------------------------------------------------------------------------
    | Secure KYC Document
    |--------------------------------------------------------------------------
    */

    public function document(
        int $verificationId,
        string $side
    ): StreamedResponse|JsonResponse
    {
        if (!in_array($side, ['front', 'back'], true)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid NID document side.',
            ], 422);
        }

        $verification = UserVerification::find($verificationId);

        if (!$verification) {
            return response()->json([
                'success' => false,
                'message' => 'KYC verification record not found.',
            ], 404);
        }

        $path = $side === 'front'
            ? $verification->nid_front_path
            : $verification->nid_back_path;

        if (!$path) {
            return response()->json([
                'success' => false,
                'message' => 'NID document not found.',
            ], 404);
        }

        if (!Storage::disk('local')->exists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'NID document file not found.',
            ], 404);
        }

        return Storage::disk('local')->response($path);
    }


    /*
    |--------------------------------------------------------------------------
    | Approve KYC
    |--------------------------------------------------------------------------
    */

    public function approve(
        Request $request,
        int $verificationId
    ): JsonResponse
    {
        $verification = UserVerification::find($verificationId);

        if (!$verification) {
            return response()->json([
                'success' => false,
                'message' => 'KYC verification record not found.',
            ], 404);
        }

        if ($verification->verification_method !== 'user_submission') {
            return response()->json([
                'success' => false,
                'message' => 'Only user submitted KYC can be approved through this endpoint.',
            ], 422);
        }

        if ($verification->verification_status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Only pending KYC can be approved.',
            ], 422);
        }

        $verification->verification_status = 'verified';
        $verification->rejection_reason = null;
        $verification->verified_by = $request->user()->id;
        $verification->verified_at = now();

        $verification->save();

        return response()->json([
            'success' => true,
            'message' => 'KYC approved successfully.',
            'data' => [
                'id' => $verification->id,
                'user_id' => $verification->user_id,
                'verification_status' =>
                    $verification->verification_status,
                'verification_method' =>
                    $verification->verification_method,
                'verified_by' =>
                    $verification->verified_by,
                'verified_at' =>
                    $verification->verified_at,
            ],
        ], 200);
    }
}