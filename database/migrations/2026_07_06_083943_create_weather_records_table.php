<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather_records', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('temperature', 5, 2)->nullable();

            $table->decimal('rainfall', 6, 2)->nullable();

            $table->decimal('wind_speed', 6, 2)->nullable();

            $table->string('weather_code')->nullable();

            $table->decimal('weather_risk_score', 5, 2)
                ->default(0);

            $table->timestamp('recorded_at');

            $table->timestamp('api_last_synced_at')
                ->nullable();

            $table->timestamps();

            $table->unique('country_id');

            $table->index('recorded_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather_records');
    }
};