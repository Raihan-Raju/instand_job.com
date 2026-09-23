<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\ResetPasswordRequest;
use App\Http\Requests\Api\V1\Auth\SendForgotPasswordOtpRequest;
use App\Http\Requests\Api\V1\Auth\VerifyForgotPasswordOtpRequest;
use App\Models\PasswordResetToken;
use App\Models\User;
use App\Services\OtpService;
use App\Services\SmsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendOtp(
        SendForgotPasswordOtpRequest $request,
        OtpService $otpService,
        SmsService $smsService
    ): JsonResponse {

        $mobile = $request->validated()['mobile'];

        $user = User::where('mobile', $mobile)
            ->where('status', 1)
            ->first();

        /*
        | Account enumeration কমানোর জন্য generic response।
        */
        if (!$user) {
            return response()->json([
                'success' => true,
                'message' =>
                    'If the mobile number is registered, an OTP has been sent.',
            ]);
        }

        $otp = $otpService->generate(
            $mobile,
            'forgot_password'
        );

        $smsService->sendOtp(
            $mobile,
            $otp
        );

        return response()->json([
            'success' => true,
            'message' =>
                'If the mobile number is registered, an OTP has been sent.',
        ]);
    }


    public function verifyOtp(
        VerifyForgotPasswordOtpRequest $request,
        OtpService $otpService
    ): JsonResponse {

        $data = $request->validated();

        $verified = $otpService->verify(
            $data['mobile'],
            $data['otp'],
            'forgot_password'
        );

        if (!$verified) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Invalid, expired or maximum-attempt OTP.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | Invalidate previous reset tokens
        |--------------------------------------------------------------------------
        */

        PasswordResetToken::where(
            'mobile',
            $data['mobile']
        )
            ->whereNull('used_at')
            ->delete();


        /*
        |--------------------------------------------------------------------------
        | Temporary Reset Token
        |--------------------------------------------------------------------------
        */

        $plainToken = Str::random(64);

        PasswordResetToken::create([
            'mobile' => $data['mobile'],
            'token_hash' => Hash::make($plainToken),
            'expires_at' => now()->addMinutes(15),
        ]);


        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully.',
            'data' => [
                'reset_token' => $plainToken,
                'expires_in_minutes' => 15,
            ],
        ]);
    }


    public function reset(
        ResetPasswordRequest $request
    ): JsonResponse {

        $data = $request->validated();

        $user = User::where(
            'mobile',
            $data['mobile']
        )->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password reset request.',
            ], 422);
        }


        $resetRecord = PasswordResetToken::where(
            'mobile',
            $data['mobile']
        )
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->latest('id')
            ->first();


        if (
            !$resetRecord ||
            !Hash::check(
                $data['reset_token'],
                $resetRecord->token_hash
            )
        ) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Invalid or expired reset token.',
            ], 422);
        }


        DB::transaction(function () use (
            $user,
            $resetRecord,
            $data
        ) {

            $user->update([
                'password' => $data['password'],
            ]);

            $resetRecord->update([
                'used_at' => now(),
            ]);

            /*
            | Password change হলে existing login sessions/tokens revoke.
            */
            $user->tokens()->delete();
        });


        return response()->json([
            'success' => true,
            'message' =>
                'Password reset successfully. Please login again.',
        ]);
    }
}