<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employer_profiles', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            |
            | One user can have only one Employer Profile.
            |
            */

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Employer / Business Information
            |--------------------------------------------------------------------------
            */

            $table->string('employer_type', 30)
                ->default('individual');

            $table->string('business_name', 200)
                ->nullable();

            $table->string('business_type', 100)
                ->nullable();

            $table->text('business_description')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Employer Profile Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('status')
                ->default(true);

            $table->timestamps();


            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('employer_type');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employer_profiles');
    }
};