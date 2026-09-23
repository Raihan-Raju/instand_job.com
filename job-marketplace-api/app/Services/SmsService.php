<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class SmsService
{
    public function sendOtp(
        string $mobile,
        string $otp
    ): bool {

        /*
        |--------------------------------------------------------------------------
        | Local Development
        |--------------------------------------------------------------------------
        |
        | এখন real SMS gateway নেই।
        | তাই OTP laravel.log-এ লিখছি।
        |
        | Production-এ এটা remove/disable থাকবে।
        |
        */

        if (app()->environment('local')) {

            Log::info('Development OTP', [
                'mobile' => $mobile,
                'otp' => $otp,
            ]);

            return true;
        }


        /*
        |--------------------------------------------------------------------------
        | Production SMS Gateway
        |--------------------------------------------------------------------------
        |
        | পরে Bangladesh SMS gateway integration এখানে হবে।
        |
        */

        return false;
    }
}