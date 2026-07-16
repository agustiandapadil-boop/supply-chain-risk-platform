<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnalysisArticle extends Model
{
    protected $fillable = [

        'title',

        'slug',

        'country_id',

        'category',

        'summary',

        'content',

        'author',

        'status',

        'published_at'
    ];

    protected $casts = [

        'published_at' => 'datetime'
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(
            Country::class
        );
    }
}