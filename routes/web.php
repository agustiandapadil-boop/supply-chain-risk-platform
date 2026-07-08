<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\DashboardController;

use App\Http\Controllers\AuthViewController;

use App\Http\Controllers\DashboardViewController;
use App\Http\Controllers\CountryViewController;
use App\Http\Controllers\AnalyticsViewController;

use App\Http\Controllers\CountryController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\AnalyticsController;

Route::get(
    '/',
    fn () => redirect('/login')
);

Route::get(
    '/login',
    [AuthViewController::class, 'showLogin']
)->name('login');

Route::post(
    '/login',
    [AuthViewController::class, 'login']
);

Route::get(
    '/register',
    [AuthViewController::class, 'showRegister']
);

Route::post(
    '/register',
    [AuthViewController::class, 'register']
);

Route::post(
    '/logout',
    [AuthViewController::class, 'logout']
);

Route::get(
    '/dashboard',
    [DashboardController::class, 'index']
);

Route::get(
    '/dashboard/top-risk',
    [DashboardController::class, 'topRisk']
);

Route::get(
    '/dashboard/distribution',
    [DashboardController::class, 'distribution']
);

Route::get(
    '/dashboard/trend',
    [DashboardController::class, 'trend']
);

Route::get(
    '/countries/ranking',
    [DashboardController::class, 'ranking']
);

Route::get(
    '/countries/search',
    [CountryController::class, 'search']
);

Route::get(
    '/countries/{id}',
    [CountryController::class, 'show']
);

Route::get(
    '/analytics/risk/{countryId}',
    [AnalyticsController::class, 'risk']
);

Route::get(
    '/analytics/weather/{countryId}',
    [AnalyticsController::class, 'weather']
);

Route::get(
    '/analytics/economy/{countryId}',
    [AnalyticsController::class, 'economy']
);

Route::get(
    '/analytics/currency/{countryId}',
    [AnalyticsController::class, 'currency']
);

Route::get(
    '/analytics/news',
    [AnalyticsController::class, 'news']
);

Route::get(
    '/analytics/overview',
    [AnalyticsController::class, 'overview']
);

Route::middleware('auth')->group(function () {

    Route::get(
        '/ui/dashboard',
        [DashboardViewController::class, 'index']
    );

    
    Route::get(
        '/ui/countries/{id}',
        [CountryViewController::class, 'show']
    );


    Route::get(
        '/ui/analytics',
        [AnalyticsViewController::class, 'index']
    );

    Route::get(
        '/watchlist',
        [WatchlistController::class, 'index']
    );

    Route::post(
        '/watchlist/{countryId}',
        [WatchlistController::class, 'store']
    );

    Route::delete(
        '/watchlist/{countryId}',
        [WatchlistController::class, 'destroy']
    );

    Route::get(
        '/monitoring',
        [WatchlistController::class, 'monitoring']
    );
});