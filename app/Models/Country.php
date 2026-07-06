<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Country extends Model
{
    protected $fillable = [
        'iso2',
        'iso3',
        'slug',
        'country_name',
        'capital',
        'region',
        'subregion',
        'currency_code',
        'currency_name',
        'language',
        'population',
        'latitude',
        'longitude',
        'flag_url',
        'api_last_synced_at',
    ];

    public function watchlists(): HasMany
    {
        return $this->hasMany(Watchlist::class);
    }

    public function weatherRecord(): HasOne
{
    return $this->hasOne(WeatherRecord::class);
}

    public function economicIndicators()
{
    return $this->hasMany(EconomicIndicator::class);
}

public function economicHistories()
{
    return $this->hasMany(EconomicHistory::class);
}

public function currencyRate()
{
    return $this->hasOne(CurrencyRate::class);
}

public function currencyHistories()
{
    return $this->hasMany(CurrencyHistory::class);
}

public function newsArticles()
{
    return $this->hasMany(NewsArticle::class);
}
 
public function ports()
{
    return $this->hasMany(Port::class);
}

public function riskScore()
{
    return $this->hasOne(RiskScore::class);
}

public function riskHistories()
{
    return $this->hasMany(RiskHistory::class);
}

public function alerts()
{
    return $this->hasMany(Alert::class);
}

}