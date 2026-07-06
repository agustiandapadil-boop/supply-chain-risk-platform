<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsSentiment extends Model
{
    protected $fillable = [
        'article_id',
        'positive_score',
        'negative_score',
        'neutral_score',
        'sentiment',
        'sentiment_score',
        'analyzed_at',
    ];

    protected $casts = [
        'analyzed_at' => 'datetime',
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(NewsArticle::class, 'article_id');
    }
}