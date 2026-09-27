<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
   {
        DB::statement("
            ALTER TABLE user_profiles
            MODIFY gender VARCHAR(20) NULL
        ");
    }

    public function down(): void
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->unsignedTinyInteger('gender')
                ->nullable()
                ->change();
        });
    }
};