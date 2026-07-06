<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeatherRecord extends Model
{
    protected $fillable = [
        'country_id',
        'temperature',
        'rainfall',
        'wind_speed',
        'weather_code',
        'weather_risk_score',
        'recorded_at',
        'api_last_synced_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
        'api_last_synced_at' => 'datetime',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}