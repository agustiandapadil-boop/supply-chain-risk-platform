<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortCongestion extends Model
{
    protected $fillable = [

        'port_id',
        'waiting_vessel',
        'delay_hours',
        'berth_utilization',
        'risk_level'
    ];

    public function port(): BelongsTo
    {
        return $this->belongsTo(
            Port::class
        );
    }
}