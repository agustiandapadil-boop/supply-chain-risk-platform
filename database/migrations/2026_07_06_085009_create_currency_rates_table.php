<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currency_rates', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->char('currency_code', 3);

            $table->decimal('exchange_rate_usd', 18, 6);

            $table->decimal('currency_risk_score', 5, 2)
                ->default(0);

            $table->timestamp('fetched_at');

            $table->timestamp('api_last_synced_at')
                ->nullable();

            $table->timestamps();

            $table->unique('country_id');

            $table->index('currency_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currency_rates');
    }
};