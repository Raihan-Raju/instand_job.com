<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_verifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('nid_number', 30)
                ->nullable();

            $table->string('nid_front_path')
                ->nullable();

            $table->string('nid_back_path')
                ->nullable();

            /*
            |--------------------------------------------------------------
            | Verification Status
            |--------------------------------------------------------------
            | pending  = Submitted, waiting for review
            | verified = Approved by admin
            | rejected = Rejected by admin
            */

            $table->string('verification_status', 20)
                ->default('pending');

            $table->text('rejection_reason')
                ->nullable();

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('verified_at')
                ->nullable();

            $table->timestamps();

            $table->index('verification_status');
            $table->index('nid_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_verifications');
    }
};