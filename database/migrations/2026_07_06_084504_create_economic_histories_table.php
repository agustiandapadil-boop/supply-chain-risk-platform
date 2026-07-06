<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('economic_histories', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('indicator_type', [
                'GDP',
                'INFLATION',
                'EXPORT',
                'IMPORT'
            ]);

            $table->decimal('indicator_value', 18, 2);

            $table->year('year');

            $table->timestamps();

            $table->index([
                'country_id',
                'indicator_type',
                'year'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('economic_histories');
    }
};