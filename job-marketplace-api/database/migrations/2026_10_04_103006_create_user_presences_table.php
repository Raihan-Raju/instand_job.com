<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_presences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Online / Offline Presence
            |--------------------------------------------------------------------------
            |
            | true  = Online
            | false = Offline
            |
            */

            $table->boolean('is_online')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Last Seen
            |--------------------------------------------------------------------------
            |
            | Updated when the user goes offline / last activity is recorded.
            |
            */

            $table->timestamp('last_seen_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Last Activity
            |--------------------------------------------------------------------------
            |
            | Tracks the latest presence heartbeat/activity received from
            | Android or Web.
            |
            */

            $table->timestamp('last_activity_at')
                ->nullable();

            $table->timestamps();

            $table->index('is_online');
            $table->index('last_seen_at');
            $table->index('last_activity_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_presences');
    }
};