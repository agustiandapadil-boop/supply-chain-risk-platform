<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\EconomicIndicator;
use App\Models\Port;
use App\Models\AnalysisArticle;

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
    public function weatherHistories(): HasMany
    {
        return $this->hasMany(WeatherHistory::class);
    }
    public function economicIndicator(): HasOne
    {
        return $this->hasOne(EconomicIndicator::class);
    }

    public function economicHistories(): HasMany
    {
        return $this->hasMany(EconomicHistory::class);
    }

    public function currencyRate(): HasOne
    {
        return $this->hasOne(CurrencyRate::class);
    }

    public function currencyHistories(): HasMany
    {
        return $this->hasMany(CurrencyHistory::class);
    }

    public function newsArticles(): HasMany
    {
        return $this->hasMany(NewsArticle::class);
    }

 

    public function ports(): HasMany
    {
        return $this->hasMany(Port::class);
    }

    public function riskScore(): HasOne
    {
        return $this->hasOne(RiskScore::class);
    }

    public function riskHistories(): HasMany
    {
        return $this->hasMany(RiskHistory::class);
    }
    public function alerts(): HasMany
    {
        return $this->hasMany(Alert::class);
    }

    public function analysisArticles(): HasMany
{
    return $this->hasMany(
        AnalysisArticle::class
    );
}
}