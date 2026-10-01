<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('worker_categories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('job_seeker_profile_id')
                ->constrained('job_seeker_profiles')
                ->cascadeOnDelete();

            $table->foreignId('job_category_id')
                ->constrained('job_categories')
                ->cascadeOnDelete();

            $table->timestamps();

            $table->unique([
                'job_seeker_profile_id',
                'job_category_id'
            ], 'worker_category_unique');

            $table->index('job_category_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('worker_categories');
    }
};