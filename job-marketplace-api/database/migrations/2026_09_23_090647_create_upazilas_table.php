<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('upazilas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('district_id')
                ->constrained('districts')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name_en', 120);
            $table->string('name_bn', 150)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Administrative Type
            |--------------------------------------------------------------------------
            |
            | upazila
            | thana
            |
            */

            $table->string('type', 20)
                ->default('upazila');

            $table->string('code', 30)
                ->nullable()
                ->unique();

            $table->tinyInteger('status')
                ->default(1)
                ->index();

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->timestamps();

            $table->index([
                'district_id',
                'status',
            ]);

            $table->index([
                'district_id',
                'type',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('upazilas');
    }
};