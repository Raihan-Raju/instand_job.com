<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('districts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('division_id')
                ->constrained('divisions')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('name_en', 100);
            $table->string('name_bn', 150)->nullable();

            $table->string('code', 20)
                ->nullable()
                ->unique();

            $table->tinyInteger('status')
                ->default(1)
                ->index();

            $table->unsignedInteger('sort_order')
                ->default(0);

            $table->timestamps();

            $table->index([
                'division_id',
                'status',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('districts');
    }
};