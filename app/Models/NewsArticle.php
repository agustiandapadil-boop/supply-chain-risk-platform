<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NewsArticle extends Model
{
    protected $fillable = [
        'country_id',
        'title',
        'description',
        'source_name',
        'source_url',
        'article_url',
        'image_url',
        'category',
        'published_at',
        'api_last_synced_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'api_last_synced_at' => 'datetime',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function sentiment(): HasOne
    {
        return $this->hasOne(NewsSentiment::class, 'article_id');
    }
}