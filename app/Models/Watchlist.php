<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Watchlist extends Model
{
    protected $fillable = [
        'user_id',
        'country_id',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(
            Country::class
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }
}