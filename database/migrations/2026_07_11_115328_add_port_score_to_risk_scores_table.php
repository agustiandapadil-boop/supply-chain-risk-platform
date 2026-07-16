<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table(
        'risk_scores',
        function ($table) {

            $table->decimal(
                'port_score',
                8,
                2
            )
            ->default(0)
            ->after('news_score');

        }
    );
}
    public function down(): void
    {
        Schema::table('risk_scores', function (Blueprint $table) {
        });
    }
};
