<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Login Information
            |--------------------------------------------------------------------------
            */

            $table->string('mobile', 20)->unique();

            $table->string('password');

            $table->timestamp('mobile_verified_at')->nullable();


            /*
            |--------------------------------------------------------------------------
            | Account Status
            |--------------------------------------------------------------------------
            |
            | 0 = Inactive
            | 1 = Active
            | 2 = Suspended
            | 3 = Blocked
            |
            */

            $table->tinyInteger('status')->default(1);

            $table->timestamp('last_login_at')->nullable();

            $table->rememberToken();

            $table->timestamps();
        });


        /*
        |--------------------------------------------------------------------------
        | Sessions
        |--------------------------------------------------------------------------
        */

        Schema::create('sessions', function (Blueprint $table) {
            // $table->string('id')->primary();
             $table->string('id', 191)->primary();

            $table->foreignId('user_id')
                ->nullable()
                ->index();

            $table->string('ip_address', 45)
                ->nullable();

            $table->text('user_agent')
                ->nullable();

            $table->longText('payload');

            $table->integer('last_activity')
                ->index();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('sessions');

        Schema::dropIfExists('users');
    }
};