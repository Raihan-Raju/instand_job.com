<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('marketplace_jobs', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Job Creator / Hirer
            |--------------------------------------------------------------------------
            |
            | Same unified user account থেকে Job Hire mode ব্যবহার করে
            | যে user job create করবে।
            |
            */
            $table->foreignId('hirer_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Job Category
            |--------------------------------------------------------------------------
            |
            | Find Worker flow-তে location/radius select করার পরে
            | category LAST select হবে।
            |
            */
            $table->foreignId('job_category_id')
                ->constrained('job_categories')
                ->cascadeOnUpdate()
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Job Information
            |--------------------------------------------------------------------------
            */

            $table->string('title', 150);

            $table->text('description')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Job Type
            |--------------------------------------------------------------------------
            |
            | instant   = এখনই worker দরকার
            | scheduled = নির্দিষ্ট date/time
            |
            */
            $table->enum('job_type', [
                'instant',
                'scheduled'
            ])->default('instant');


            /*
            |--------------------------------------------------------------------------
            | Payment / Rate Type
            |--------------------------------------------------------------------------
            |
            | hourly   = প্রতি ঘণ্টা
            | daily    = দৈনিক
            | fixed    = সম্পূর্ণ কাজের fixed amount
            |
            */
            $table->enum('rate_type', [
                'hourly',
                'daily',
                'fixed'
            ]);

            $table->decimal('rate_amount', 12, 2);


            /*
            |--------------------------------------------------------------------------
            | Required Workers
            |--------------------------------------------------------------------------
            */

            $table->unsignedSmallInteger('workers_required')
                ->default(1);


            /*
            |--------------------------------------------------------------------------
            | Hiring Mode
            |--------------------------------------------------------------------------
            |
            | manual = map pin/profile থেকে Direct Hire
            | auto   = nearest-first Auto Hire
            |
            */
            $table->enum('hire_mode', [
                'manual',
                'auto'
            ]);


            /*
            |--------------------------------------------------------------------------
            | Search Mode
            |--------------------------------------------------------------------------
            |
            | current = Hirer's current GPS
            | manual  = Hirer map-এ manually location select করেছে
            |
            */
            $table->enum('search_mode', [
                'current',
                'manual'
            ]);


            /*
            |--------------------------------------------------------------------------
            | Job / Search Location
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            | Manual search location user_locations table overwrite করবে না।
            | Job-এর selected location এখানে snapshot হিসেবে থাকবে।
            |
            */
            $table->decimal('latitude', 10, 7);

            $table->decimal('longitude', 10, 7);

            $table->decimal('search_radius_km', 6, 2)
                ->default(5.00);

            $table->string('location_address', 500)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Scheduled Job
            |--------------------------------------------------------------------------
            |
            | Instant job হলে scheduled_at NULL থাকবে।
            |
            */
            $table->dateTime('scheduled_at')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Job Lifecycle
            |--------------------------------------------------------------------------
            |
            | open        = worker search/request চলতে পারে
            | assigned    = worker assigned/accepted
            | in_progress = actual কাজ শুরু হয়েছে
            | completed   = কাজ শেষ
            | cancelled   = job cancel
            |
            */
            $table->enum('status', [
                'open',
                'assigned',
                'in_progress',
                'completed',
                'cancelled'
            ])->default('open');


            /*
            |--------------------------------------------------------------------------
            | Work Time
            |--------------------------------------------------------------------------
            */

            $table->dateTime('started_at')
                ->nullable();

            $table->dateTime('completed_at')
                ->nullable();

            $table->unsignedInteger('worked_minutes')
                ->default(0);


            /*
            |--------------------------------------------------------------------------
            | Cancellation
            |--------------------------------------------------------------------------
            */

            $table->dateTime('cancelled_at')
                ->nullable();

            $table->text('cancellation_reason')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'job_category_id',
                'status'
            ]);

            $table->index([
                'latitude',
                'longitude'
            ]);

            $table->index([
                'hirer_id',
                'status'
            ]);

            $table->index('scheduled_at');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketplace_jobs');
    }
};