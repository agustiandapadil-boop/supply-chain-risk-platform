<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$c = app(\App\Services\RestCountriesService::class)->fetchCountries()[0];
dump($c['capitals'] ?? null);
dump($c['flag'] ?? null);
