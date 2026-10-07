<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ForgotPasswordController;
use App\Http\Controllers\Api\V1\LocationController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\KycController;
use App\Http\Controllers\Api\V1\JobCategoryController;
use App\Http\Controllers\Api\V1\JobSeekerProfileController;
use App\Http\Controllers\Api\V1\SkillController;
use App\Http\Controllers\Api\V1\EmployerProfileController;
use App\Http\Controllers\Api\V1\UserLocationController;
use App\Http\Controllers\Api\V1\UserPresenceController;
use App\Http\Controllers\Api\V1\WorkerAvailabilityController;
use App\Http\Controllers\Api\V1\MarketplaceJobController;

use App\Http\Controllers\Api\V1\Admin\KycController as AdminKycController;


Route::prefix('v1')->group(function ()
{

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
    | Public Job Categories
    |--------------------------------------------------------------------------
    |
    | Job Seeker / Job Hire উভয়েই category list দেখতে পারবে।
    | Login ছাড়াও category list load করা যাবে।
    |
    */

    Route::get('/job-categories', [
        JobCategoryController::class,
        'index'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Public Skills
    |--------------------------------------------------------------------------
    |
    | Job Seeker registration/profile form থেকে active skills
    | load করার জন্য এই API ব্যবহার হবে।
    |
    */

    Route::get('/skills', [
        SkillController::class,
        'index'
    ]);


    /*
    |--------------------------------------------------------------------------
    | Authenticated APIs
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->group(function ()
    {

        /*
        |--------------------------------------------------------------------------
        | Logged-in User
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | Common User Profile
        |--------------------------------------------------------------------------
        */

        Route::get('/profile', [
            ProfileController::class,
            'show'
        ]);


        Route::put('/profile', [
            ProfileController::class,
            'update'
        ]);


        Route::post('/profile/photo', [
            ProfileController::class,
            'uploadPhoto'
        ]);


        /*
        |--------------------------------------------------------------------------
        | NID / KYC
        |--------------------------------------------------------------------------
        */

        Route::post('/kyc/submit', [
            KycController::class,
            'submit'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Job Seeker Profile
        |--------------------------------------------------------------------------
        |
        | One authenticated user can create/update one Job Seeker Profile.
        | Multiple categories are saved through worker_categories.
        |
        */

        Route::post('/job-seeker/profile', [
            JobSeekerProfileController::class,
            'save'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Employer / Job Hire Profile
        |--------------------------------------------------------------------------
        |
        | Same authenticated user can also activate Job Hire mode.
        |
        | Individual:
        | employer_type = individual
        |
        | Business:
        | employer_type = business
        | business_name required
        |
        | status is controlled by Admin/System.
        |
        */

        Route::get('/employer/profile', [
            EmployerProfileController::class,
            'show'
        ]);


        Route::post('/employer/profile', [
            EmployerProfileController::class,
            'save'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Current GPS Location
        |--------------------------------------------------------------------------
        |
        | Same authenticated user's current/latest GPS location.
        |
        | Job Seeker:
        | Worker current location update.
        |
        | Job Hire:
        | Hirer's current location for Current Location search.
        |
        | Manual search location will NOT overwrite this location.
        |
        */

        Route::get('/location', [
            UserLocationController::class,
            'show'
        ]);


        Route::post('/location', [
            UserLocationController::class,
            'update'
        ]);


        /*
        |--------------------------------------------------------------------------
        | User Presence
        |--------------------------------------------------------------------------
        |
        | Unified account presence for both:
        | Job Seeker and Job Hire modes.
        |
        */

        Route::get('/presence', [
            UserPresenceController::class,
            'show'
        ]);


        Route::post('/presence/online', [
            UserPresenceController::class,
            'online'
        ]);


        Route::post('/presence/heartbeat', [
            UserPresenceController::class,
            'heartbeat'
        ]);


        Route::post('/presence/offline', [
            UserPresenceController::class,
            'offline'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Worker Availability
        |--------------------------------------------------------------------------
        |
        | This stores the Job Seeker's base/manual availability.
        |
        | is_available = true
        | Worker is willing to receive jobs.
        |
        | is_available = false
        | Worker does not want to receive jobs.
        |
        | IMPORTANT:
        | When a worker accepts an active job, Job Assignment will override
        | this availability and the worker will be BUSY in ALL categories.
        |
        | After the hired job is completed/cancelled/released, the worker
        | becomes eligible again according to the final assignment logic.
        |
        */

        Route::get('/job-seeker/availability', [
            WorkerAvailabilityController::class,
            'show'
        ]);


        Route::put('/job-seeker/availability', [
            WorkerAvailabilityController::class,
            'update'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Marketplace Jobs
        |--------------------------------------------------------------------------
        |
        | Authenticated user can create a marketplace job while acting
        | in Job Hire / Employer mode.
        |
        | hirer_id is NOT accepted from the client.
        | MarketplaceJobController will use the authenticated user's ID.
        |
        | Job location is stored as a snapshot in marketplace_jobs.
        | Manual search location does NOT overwrite user_locations.
        |
        */

        Route::post('/marketplace-jobs', [
            MarketplaceJobController::class,
            'store'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Admin APIs
        |--------------------------------------------------------------------------
        */

        Route::prefix('admin')
            ->middleware('admin')
            ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | KYC Management
            |--------------------------------------------------------------------------
            */

            Route::get('/kyc/pending', [
                AdminKycController::class,
                'pending'
            ]);


            Route::get('/kyc/{verificationId}', [
                AdminKycController::class,
                'show'
            ]);


            Route::get('/kyc/{verificationId}/document/{side}', [
                AdminKycController::class,
                'document'
            ])->where('side', 'front|back');


            Route::post('/kyc/{verificationId}/approve', [
                AdminKycController::class,
                'approve'
            ]);

        });

    });

});