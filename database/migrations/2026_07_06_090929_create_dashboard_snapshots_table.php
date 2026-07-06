<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dashboard_snapshots', function (Blueprint $table) {

            $table->id();

            $table->unsignedInteger('monitored_countries')
                ->default(0);

            $table->decimal('average_risk_score', 5, 2)
                ->default(0);

            $table->foreignId('highest_risk_country_id')
                ->nullable()
                ->constrained('countries')
                ->nullOnDelete();

            $table->foreignId('lowest_risk_country_id')
                ->nullable()
                ->constrained('countries')
                ->nullOnDelete();

            $table->timestamp('generated_at');

            $table->timestamps();

            $table->index('generated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_snapshots');
    }
};