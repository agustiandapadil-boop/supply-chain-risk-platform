<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CurrencyService;

class SyncCurrencyCommand extends Command
{
    protected $signature =
        'sync:currency';

    protected $description =
        'Sync exchange rates';

    public function handle(
        CurrencyService $service
    ): int
    {
        $this->info(
            'Syncing currency rates...'
        );

        $count =
            $service->syncRates();

        $this->info(
            "{$count} currencies synced."
        );

        return self::SUCCESS;
    }
}