<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Port extends Model
{
    protected $fillable = [
        'country_id',
        'port_name',
        'harbor_size',
        'harbor_type',
        'latitude',
        'longitude',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function congestion(): HasOne
{
    return $this->hasOne(
        PortCongestion::class
    );
}

}