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
use App\Http\Controllers\WatchlistViewController;
use App\Http\Controllers\IntelligenceController;
use App\Http\Controllers\CountryComparisonController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\PortManagementController;
use App\Http\Controllers\Admin\ArticleManagementController;
use App\Http\Controllers\NewsViewController;
use App\Http\Controllers\PortViewController;
use App\Http\Controllers\ArticleViewController;


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
    '/admin/login',
    [AuthViewController::class, 'showAdminLogin']
)->name('admin.login');

Route::post(
    '/admin/login',
    [AuthViewController::class, 'adminLogin']
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

Route::middleware([
    'auth',
    'admin'
])
->prefix('admin')
->group(function(){

    Route::get(
        '/',
        [AdminDashboardController::class,'index']
    );

    Route::resource(
        'users',
        UserManagementController::class
    );

    Route::resource(
        'ports',
        PortManagementController::class
    );

    Route::resource(
        'articles',
        ArticleManagementController::class
    );

});

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
        '/ui/analytics/weather-map-data',
        [AnalyticsViewController::class, 'weatherMapData']
    );

    Route::get(
        '/ui/analytics/currency-history-data',
        [AnalyticsViewController::class, 'currencyHistoryData']
    );

    Route::get(
        '/ui/news',
        [NewsViewController::class, 'index']
    );

    Route::get(
        '/ui/ports',
        [PortViewController::class, 'index']
    );

    Route::get(
        '/ui/ports/map-data',
        [PortViewController::class, 'mapData']
    );

    Route::get(
        '/ui/articles',
        [ArticleViewController::class, 'index']
    );

    Route::get(
        '/ui/articles/{slug}',
        [ArticleViewController::class, 'show']
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

    Route::middleware('auth')->group(function () {

    Route::get(
        '/watchlist',
        [WatchlistViewController::class, 'index']
    );

});
Route::get(
    '/ui/intelligence',
    [IntelligenceController::class, 'index']
);
Route::get(
    '/comparison/data',
    [CountryComparisonController::class,'compare']
);
