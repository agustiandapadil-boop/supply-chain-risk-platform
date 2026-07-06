<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();

            $table->char('iso2', 2)->unique();
            $table->char('iso3', 3)->unique();

            $table->string('slug')->unique();

            $table->string('country_name');

            $table->string('capital')->nullable();

            $table->string('region')->nullable();

            $table->string('subregion')->nullable();

            $table->char('currency_code', 3)->nullable();

            $table->string('currency_name')->nullable();

            $table->string('language')->nullable();

            $table->unsignedBigInteger('population')->nullable();

            $table->decimal('latitude', 10, 7)->nullable();

            $table->decimal('longitude', 10, 7)->nullable();

            $table->text('flag_url')->nullable();

            $table->timestamp('api_last_synced_at')->nullable();

            $table->timestamps();

            $table->index('country_name');
            $table->index('region');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};