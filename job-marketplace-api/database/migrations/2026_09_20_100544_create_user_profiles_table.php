<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('full_name', 150)->nullable();

            $table->string('profile_photo')->nullable();

            $table->date('date_of_birth')->nullable();

            /*
            | 1 = Male
            | 2 = Female
            | 3 = Other
            */

            $table->tinyInteger('gender')->nullable();

            $table->text('present_address')->nullable();

            $table->text('permanent_address')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};