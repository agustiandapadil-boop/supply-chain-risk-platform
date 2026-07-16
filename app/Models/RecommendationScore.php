<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommendationScore extends Model
{
    protected $fillable = [

        'country_id',
        'risk_component',
        'gdp_component',
        'export_component',
        'port_component',
        'recommendation_score'
    ];

    public function country()
    {
        return $this->belongsTo(
            Country::class
        );
    }
}