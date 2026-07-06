<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardSnapshot extends Model
{
    protected $fillable = [
        'monitored_countries',
        'average_risk_score',
        'highest_risk_country_id',
        'lowest_risk_country_id',
        'generated_at',
    ];

    protected $casts = [
        'generated_at' => 'datetime',
    ];

    public function highestRiskCountry(): BelongsTo
    {
        return $this->belongsTo(
            Country::class,
            'highest_risk_country_id'
        );
    }

    public function lowestRiskCountry(): BelongsTo
    {
        return $this->belongsTo(
            Country::class,
            'lowest_risk_country_id'
        );
    }
}