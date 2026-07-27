<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('sync:currency')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('sync:economy')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('sync:news')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('sync:ports')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('sync:weather')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('generate:port-congestion')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('risk:calculate')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('generate:alerts')->everyMinute()->runInBackground()->withoutOverlapping();
