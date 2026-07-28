<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('sync:currency')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('sync:economy')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('sync:news')->hourly()->runInBackground()->withoutOverlapping();
Schedule::command('ports:sync')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('sync:weather')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('ports:congestion')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('risk:calculate')->everyMinute()->runInBackground()->withoutOverlapping();
Schedule::command('alerts:generate')->everyMinute()->runInBackground()->withoutOverlapping();
