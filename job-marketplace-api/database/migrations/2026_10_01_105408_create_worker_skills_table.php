<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worker_skills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_seeker_profile_id')
                ->constrained('job_seeker_profiles')
                ->cascadeOnDelete();

            $table->foreignId('skill_id')
                ->constrained('skills')
                ->cascadeOnDelete();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Prevent duplicate skill
            |--------------------------------------------------------------------------
            |
            | একই Job Seeker-এর একই skill একাধিকবার save হতে পারবে না।
            |
            */

            $table->unique([
                'job_seeker_profile_id',
                'skill_id'
            ], 'worker_skill_unique');

            /*
            |--------------------------------------------------------------------------
            | Search Index
            |--------------------------------------------------------------------------
            */

            $table->index('skill_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_skills');
    }
};