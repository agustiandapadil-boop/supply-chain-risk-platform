<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EconomicHistory extends Model
{
    protected $fillable = [
        'country_id',
        'indicator_type',
        'indicator_value',
        'year',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}