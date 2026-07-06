<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');

            $table->text('message');

            $table->enum('severity', [
                'Low',
                'Medium',
                'High',
                'Critical'
            ]);

            $table->enum('alert_type', [
                'Weather',
                'Inflation',
                'Currency',
                'News',
                'Risk'
            ]);

            $table->boolean('is_active')
                ->default(true);

            $table->timestamp('triggered_at');

            $table->timestamps();

            $table->index('severity');
            $table->index('alert_type');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};