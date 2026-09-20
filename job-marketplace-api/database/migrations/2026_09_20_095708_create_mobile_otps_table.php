<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobile_otps', function (Blueprint $table) {
            $table->id();

            $table->string('mobile', 20)->index();

            $table->string('otp_hash');

            $table->string('purpose', 30);

            $table->timestamp('expires_at');

            $table->timestamp('verified_at')->nullable();

            $table->unsignedTinyInteger('attempt_count')->default(0);

            $table->timestamp('last_attempt_at')->nullable();

            $table->timestamps();

            $table->index([
                'mobile',
                'purpose'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobile_otps');
    }
};