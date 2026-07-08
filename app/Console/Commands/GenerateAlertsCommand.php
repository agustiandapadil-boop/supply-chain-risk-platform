<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AlertService;

class GenerateAlertsCommand extends Command
{
    protected $signature =
        'alerts:generate';

    protected $description =
        'Generate supply chain alerts';

    public function handle(
        AlertService $service
    ): int
    {
        $this->info(
            'Generating alerts...'
        );

        $count =
            $service->generateAlerts();

        $this->info(
            "{$count} alerts generated."
        );

        return self::SUCCESS;
    }
}