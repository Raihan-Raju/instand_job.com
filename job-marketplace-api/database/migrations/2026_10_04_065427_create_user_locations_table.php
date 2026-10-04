<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_locations', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            |
            | One user will have one latest/current location record.
            |
            */

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | GPS Coordinates
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 7);

            $table->decimal('longitude', 10, 7);


            /*
            |--------------------------------------------------------------------------
            | GPS Information
            |--------------------------------------------------------------------------
            |
            | accuracy is normally received from device/browser GPS.
            | Unit: meters.
            |
            */

            $table->decimal('accuracy', 10, 2)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Location Update Time
            |--------------------------------------------------------------------------
            */

            $table->timestamp('location_updated_at')
                ->nullable();

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index([
                'latitude',
                'longitude',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_locations');
    }
};