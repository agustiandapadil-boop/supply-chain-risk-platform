<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ports', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('port_name');

            $table->string('harbor_size')
                ->nullable();

            $table->string('harbor_type')
                ->nullable();

            $table->decimal('latitude', 10, 7);

            $table->decimal('longitude', 10, 7);

            $table->timestamps();

            $table->index('country_id');
            $table->index('port_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ports');
    }
};