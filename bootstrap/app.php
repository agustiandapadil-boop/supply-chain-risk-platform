<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    ->withSchedule(function (
    Schedule $schedule
) {

    $schedule
        ->command('sync:countries')
        ->daily();


    $schedule
        ->command('sync:economy')
        ->dailyAt('00:00');


    $schedule
        ->command('sync:currency')
        ->hourly();


    $schedule
        ->command('sync:weather')
        ->everyThirtyMinutes();


    $schedule
        ->command('sync:news')
        ->hourly();


    $schedule
        ->command(
            'app:calculate-risk-command'
        )
        ->hourly();



    $schedule
        ->command(
            'alerts:generate'
        )
        ->hourly();

    })
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
