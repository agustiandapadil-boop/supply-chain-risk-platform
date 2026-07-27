<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RiskScoringService;
use App\Services\AlertService;

class CalculateRiskCommand extends Command
{

    protected $signature = 'risk:calculate';

    protected $description =
        'Calculate supply chain risk score and generate alerts for all countries';

    public function __construct(
        private RiskScoringService $riskScoringService,
        private AlertService $alertService
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('======================================');
        $this->info('SUPPLY CHAIN RISK CALCULATION STARTED');
        $this->info('======================================');

        $this->info('Calculating risk scores...');

        $countryCount =
            $this->riskScoringService
                ->calculateAllCountries();

        $this->info(
            "{$countryCount} countries risk calculated successfully."
        );
        $this->info('Generating alerts...');

        $alertCount =
            $this->alertService
                ->generateAlerts();

        $this->info(
            "{$alertCount} alerts generated successfully."
        );

        $this->info('======================================');
        $this->info('PROCESS COMPLETED');
        $this->info('======================================');

        return self::SUCCESS;
    }
}