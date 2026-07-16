<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RecommendationEngineService;

class CalculateRecommendationsCommand
    extends Command
{
    protected $signature =
        'recommendation:calculate';

    protected $description =
        'Calculate recommendation score';

    public function handle(
        RecommendationEngineService $service
    )
    {
        $service->calculateAll();

        $this->info(
            'Recommendation updated'
        );
    }
}