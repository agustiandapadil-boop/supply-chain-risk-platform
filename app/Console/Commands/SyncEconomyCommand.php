<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WorldBankService;

class SyncEconomyCommand extends Command
{
    protected $signature =
        'sync:economy';

    protected $description =
        'Sync economic indicators from World Bank';

    public function handle(
        WorldBankService $worldBankService
    ): int
    {
        $this->info(
            'Syncing economic indicators...'
        );

        $count =
            $worldBankService
                ->syncAllCountries();

        $this->info(
            "{$count} countries synced."
        );

        return self::SUCCESS;
    }
}