<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\EconomicIndicator;

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

    /*
    |--------------------------------------------------------------------------
    | Watchlists
    |--------------------------------------------------------------------------
    */

    public function watchlists(): HasMany
    {
        return $this->hasMany(Watchlist::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Weather
    |--------------------------------------------------------------------------
    */

    public function weatherRecord(): HasOne
    {
        return $this->hasOne(WeatherRecord::class);
    }

    public function weatherHistories(): HasMany
    {
        return $this->hasMany(WeatherHistory::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Economy
    |--------------------------------------------------------------------------
    */

    public function economicIndicator(): HasOne
    {
        return $this->hasOne(EconomicIndicator::class);
    }

    public function economicHistories(): HasMany
    {
        return $this->hasMany(EconomicHistory::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    */

    public function currencyRate(): HasOne
    {
        return $this->hasOne(CurrencyRate::class);
    }

    public function currencyHistories(): HasMany
    {
        return $this->hasMany(CurrencyHistory::class);
    }

    /*
    |--------------------------------------------------------------------------
    | News
    |--------------------------------------------------------------------------
    */

    public function newsArticles(): HasMany
    {
        return $this->hasMany(NewsArticle::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Ports
    |--------------------------------------------------------------------------
    */

    public function ports(): HasMany
    {
        return $this->hasMany(Port::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Risk
    |--------------------------------------------------------------------------
    */

    public function riskScore(): HasOne
    {
        return $this->hasOne(RiskScore::class);
    }

    public function riskHistories(): HasMany
    {
        return $this->hasMany(RiskHistory::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Alerts
    |--------------------------------------------------------------------------
    */

    public function alerts(): HasMany
    {
        return $this->hasMany(Alert::class);
    }
}