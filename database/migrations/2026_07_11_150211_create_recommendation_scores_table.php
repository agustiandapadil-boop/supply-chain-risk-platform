<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'recommendation_scores',
            function (Blueprint $table) {

                $table->id();

                $table->foreignId('country_id')
                    ->unique()
                    ->constrained()
                    ->cascadeOnDelete();

                $table->decimal(
                    'risk_component',
                    10,
                    2
                );

                $table->decimal(
                    'gdp_component',
                    10,
                    2
                );

                $table->decimal(
                    'export_component',
                    10,
                    2
                );

                $table->decimal(
                    'port_component',
                    10,
                    2
                );

                $table->decimal(
                    'recommendation_score',
                    10,
                    2
                );

                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'recommendation_scores'
        );
    }
};