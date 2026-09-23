<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ForgotPasswordController;
use App\Http\Controllers\Api\V1\LocationController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Bangladesh Locations
    |--------------------------------------------------------------------------
    */

    Route::prefix('locations')->group(function () {

        Route::get('/divisions', [
            LocationController::class,
            'divisions'
        ]);

        Route::get('/divisions/{divisionId}/districts', [
            LocationController::class,
            'districts'
        ]);

        Route::get('/districts/{districtId}/upazilas', [
            LocationController::class,
            'upazilas'
        ]);
    });


    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    */

    Route::prefix('auth')->group(function () {

        Route::post('/register', [
            AuthController::class,
            'register'
        ])->middleware('throttle:10,1');


        Route::post('/login', [
            AuthController::class,
            'login'
        ])->middleware('throttle:10,1');


        /*
        |--------------------------------------------------------------------------
        | Forgot Password
        |--------------------------------------------------------------------------
        */

        Route::prefix('forgot-password')->group(function () {

            Route::post('/send-otp', [
                ForgotPasswordController::class,
                'sendOtp'
            ])->middleware('throttle:3,1');


            Route::post('/verify-otp', [
                ForgotPasswordController::class,
                'verifyOtp'
            ])->middleware('throttle:5,1');


            Route::post('/reset', [
                ForgotPasswordController::class,
                'reset'
            ])->middleware('throttle:5,1');
        });
    });


    /*
    |--------------------------------------------------------------------------
    | Authenticated APIs
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/me', [
            AuthController::class,
            'me'
        ]);

        Route::post('/auth/logout', [
            AuthController::class,
            'logout'
        ]);

        Route::post('/auth/logout-all', [
            AuthController::class,
            'logoutAll'
        ]);
    });

});