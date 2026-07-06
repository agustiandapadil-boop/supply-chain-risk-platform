<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currency_histories', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->decimal('exchange_rate_usd', 18, 6);

            $table->timestamp('fetched_at');

            $table->timestamps();

            $table->index([
                'country_id',
                'fetched_at'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('currency_histories');
    }
};