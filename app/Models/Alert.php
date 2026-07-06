<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alert extends Model
{
    protected $fillable = [
        'country_id',
        'title',
        'message',
        'severity',
        'alert_type',
        'is_active',
        'triggered_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'triggered_at' => 'datetime',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}