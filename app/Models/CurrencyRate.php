<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurrencyRate extends Model
{
    protected $fillable = [
        'country_id',
        'currency_code',
        'exchange_rate_usd',
        'currency_risk_score',
        'fetched_at',
        'api_last_synced_at',
    ];

    protected $casts = [
        'fetched_at' => 'datetime',
        'api_last_synced_at' => 'datetime',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}