<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create(
            'port_congestions',
            function (Blueprint $table) {

                $table->id();

                $table->foreignId('port_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->integer(
                    'waiting_vessel'
                )->default(0);

                $table->decimal(
                    'delay_hours',
                    8,
                    2
                )->default(0);

                $table->decimal(
                    'berth_utilization',
                    5,
                    2
                )->default(0);

                $table->string(
                    'risk_level'
                )->default('LOW');

                $table->timestamps();
            }
        );
    }

    public function down(): void
    {
        Schema::dropIfExists(
            'port_congestions'
        );
    }
};