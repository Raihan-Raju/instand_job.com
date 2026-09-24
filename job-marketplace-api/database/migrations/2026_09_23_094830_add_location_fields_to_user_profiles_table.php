<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {

            $table->foreignId('division_id')
                ->nullable()
                ->after('gender')
                ->constrained('divisions')
                ->nullOnDelete();

            $table->foreignId('district_id')
                ->nullable()
                ->after('division_id')
                ->constrained('districts')
                ->nullOnDelete();

            $table->foreignId('upazila_id')
                ->nullable()
                ->after('district_id')
                ->constrained('upazilas')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropForeign(['upazila_id']);
            $table->dropForeign(['district_id']);
            $table->dropForeign(['division_id']);

            $table->dropColumn([
                'upazila_id',
                'district_id',
                'division_id',
            ]);
        });
    }
};