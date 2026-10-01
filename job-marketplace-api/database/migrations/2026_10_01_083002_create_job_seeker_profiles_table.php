<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_seeker_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('professional_title', 150)
                ->nullable();

            $table->text('about')
                ->nullable();

            $table->unsignedInteger('experience_years')
                ->default(0);

            $table->decimal('hourly_rate', 12, 2)
                ->nullable();

            $table->decimal('daily_rate', 12, 2)
                ->nullable();

            $table->boolean('is_available')
                ->default(true);

            $table->boolean('status')
                ->default(true);

            $table->timestamps();

            $table->index('is_available');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_seeker_profiles');
    }
};