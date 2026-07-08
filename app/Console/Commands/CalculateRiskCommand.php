<?php

namespace App\Console\Commands;

use App\Services\RiskScoringService;
use Illuminate\Console\Command;

class CalculateRiskCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'risk:calculate';

    /**
     * The console command description.
     */
    protected $description = 'Calculate supply chain risk score for all countries';

    public function __construct(
        private RiskScoringService $riskScoringService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Calculating risk scores...');

        $count =
            $this->riskScoringService
                ->calculateAllCountries();

        $this->info(
            "{$count} countries risk calculated successfully."
        );

        return self::SUCCESS;
    }
}