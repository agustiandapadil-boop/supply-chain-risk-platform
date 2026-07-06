<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('economic_indicators', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->unsignedBigInteger('gdp')->nullable();

            $table->decimal('inflation_rate', 8, 2)
                ->nullable();

            $table->decimal('export_value', 18, 2)
                ->nullable();

            $table->decimal('import_value', 18, 2)
                ->nullable();

            $table->year('year');

            $table->timestamp('api_last_synced_at')
                ->nullable();

            $table->timestamps();

            $table->unique([
                'country_id',
                'year'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('economic_indicators');
    }
};