<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RiskScoringService;
use App\Services\AlertService;

class CalculateRiskCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'risk:calculate';

    /**
     * The console command description.
     */
    protected $description =
        'Calculate supply chain risk score and generate alerts for all countries';

    public function __construct(
        private RiskScoringService $riskScoringService,
        private AlertService $alertService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('======================================');
        $this->info('SUPPLY CHAIN RISK CALCULATION STARTED');
        $this->info('======================================');

        /*
        |--------------------------------------------------------------------------
        | Calculate Risk Scores
        |--------------------------------------------------------------------------
        */
        $this->info('Calculating risk scores...');

        $countryCount =
            $this->riskScoringService
                ->calculateAllCountries();

        $this->info(
            "{$countryCount} countries risk calculated successfully."
        );

        /*
        |--------------------------------------------------------------------------
        | Generate Alerts
        |--------------------------------------------------------------------------
        */
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