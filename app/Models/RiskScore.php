<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskScore extends Model
{
    protected $fillable = [

    'country_id',
    'weather_score',
    'inflation_score',
    'currency_score',
    'news_score',
    'port_score',
    'total_score',
    'risk_level',
    'calculated_at',
];

    protected $casts = [
        'calculated_at' => 'datetime',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    public function disruptionLevel()
{
    $score = 0;

    $score += $this->weather_score ?? 0;
    $score += $this->currency_score ?? 0;
    $score += $this->inflation_score ?? 0;
    $score += $this->news_score ?? 0;
    $score += $this->port_score ?? 0;

    if ($score >= 120) {
        return 'CRITICAL';
    }

    if ($score >= 80) {
        return 'HIGH';
    }

    if ($score >= 40) {
        return 'MEDIUM';
    }

    return 'LOW';
}

public function disruptionProbability()
{
    $score = 0;

    $score += $this->weather_score ?? 0;
    $score += $this->currency_score ?? 0;
    $score += $this->inflation_score ?? 0;
    $score += $this->news_score ?? 0;
    $score += $this->port_score ?? 0;

    return min(
        100,
        round(
            $score / 2,
            0
        )
    );
}

}