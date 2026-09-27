<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Kyc\SubmitKycRequest;
use App\Models\UserVerification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class KycController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Submit KYC
    |--------------------------------------------------------------------------
    |
    | Normal authenticated user submits:
    | - NID Number
    | - NID Front Image
    | - NID Back Image
    |
    | KYC documents are stored in PRIVATE storage.
    |
    */

    public function submit(SubmitKycRequest $request): JsonResponse
    {
        $user = $request->user();

        $existingVerification = UserVerification::where(
            'user_id',
            $user->id
        )->first();

        /*
        |--------------------------------------------------------------------------
        | Do Not Allow Verified KYC To Be Replaced
        |--------------------------------------------------------------------------
        */

        if (
            $existingVerification &&
            $existingVerification->verification_status === 'verified'
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Your identity is already verified.',
            ], 422);
        }

        $nidFrontPath = null;
        $nidBackPath = null;

        try {

            /*
            |--------------------------------------------------------------------------
            | Store Documents Privately
            |--------------------------------------------------------------------------
            */

            $nidFrontPath = $request
                ->file('nid_front')
                ->store(
                    'kyc/' . $user->id,
                    'local'
                );

            $nidBackPath = $request
                ->file('nid_back')
                ->store(
                    'kyc/' . $user->id,
                    'local'
                );

            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | Create / Update KYC
            |--------------------------------------------------------------------------
            */

            $verification = UserVerification::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'nid_number' => $request->nid_number,
                    'nid_front_path' => $nidFrontPath,
                    'nid_back_path' => $nidBackPath,

                    'verification_status' => 'pending',
                    'verification_method' => 'user_submission',

                    'rejection_reason' => null,
                    'verified_by' => null,
                    'verified_at' => null,
                ]
            );

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | Delete Previous Documents After Successful Update
            |--------------------------------------------------------------------------
            */

            if ($existingVerification) {

                if (
                    $existingVerification->nid_front_path &&
                    $existingVerification->nid_front_path !== $nidFrontPath
                ) {
                    Storage::disk('local')->delete(
                        $existingVerification->nid_front_path
                    );
                }

                if (
                    $existingVerification->nid_back_path &&
                    $existingVerification->nid_back_path !== $nidBackPath
                ) {
                    Storage::disk('local')->delete(
                        $existingVerification->nid_back_path
                    );
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'KYC submitted successfully and is pending verification.',
                'data' => [
                    'verification_status' =>
                        $verification->verification_status,

                    'verification_method' =>
                        $verification->verification_method,

                    'submitted_at' =>
                        $verification->updated_at,
                ],
            ], 200);

        } catch (Throwable $e) {

            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            /*
            |--------------------------------------------------------------------------
            | Remove Newly Uploaded Files If Submission Fails
            |--------------------------------------------------------------------------
            */

            if ($nidFrontPath) {
                Storage::disk('local')->delete($nidFrontPath);
            }

            if ($nidBackPath) {
                Storage::disk('local')->delete($nidBackPath);
            }

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to submit KYC. Please try again.',
            ], 500);
        }
    }
}