<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_sentiments', function (Blueprint $table) {

            $table->id();

            $table->foreignId('article_id')
                ->unique()
                ->constrained('news_articles')
                ->cascadeOnDelete();

            $table->unsignedInteger('positive_score')
                ->default(0);

            $table->unsignedInteger('negative_score')
                ->default(0);

            $table->unsignedInteger('neutral_score')
                ->default(0);

            $table->enum('sentiment', [
                'Positive',
                'Neutral',
                'Negative'
            ]);

            $table->decimal('sentiment_score', 5, 2)
                ->default(0);

            $table->timestamp('analyzed_at');

            $table->timestamps();

            $table->index('sentiment');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_sentiments');
    }
};