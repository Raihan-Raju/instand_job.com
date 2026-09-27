<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_verifications', function (Blueprint $table) {
            $table->string('verification_method', 30)
                ->default('user_submission')
                ->after('verification_status');

            $table->index('verification_method');
        });
    }

    public function down(): void
    {
        Schema::table('user_verifications', function (Blueprint $table) {
            $table->dropIndex(['verification_method']);
            $table->dropColumn('verification_method');
        });
    }
};