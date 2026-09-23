<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->id();

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

            $table->index('name_en');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('divisions');
    }
};