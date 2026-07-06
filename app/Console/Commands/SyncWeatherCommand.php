<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;

class SyncWeatherCommand extends Command
{
    protected $signature =
        'sync:weather';

    protected $description =
        'Sync weather data from Open-Meteo';

    public function handle(
        WeatherService $weatherService
    ): int
    {
        $this->info(
            'Syncing weather data...'
        );

        $count =
            $weatherService
                ->syncAllCountries();

        $this->info(
            "{$count} countries synced."
        );

        return self::SUCCESS;
    }
}