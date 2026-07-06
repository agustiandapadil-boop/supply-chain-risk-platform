<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_articles', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('title');

            $table->longText('description')
                ->nullable();

            $table->string('source_name')
                ->nullable();

            $table->text('source_url')
                ->nullable();

            $table->text('article_url')
                ->nullable();

            $table->text('image_url')
                ->nullable();

            $table->enum('category', [
                'economy',
                'trade',
                'shipping',
                'logistics'
            ]);

            $table->timestamp('published_at');

            $table->timestamp('api_last_synced_at')
                ->nullable();

            $table->timestamps();

            $table->index('country_id');
            $table->index('category');
            $table->index('published_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_articles');
    }
};