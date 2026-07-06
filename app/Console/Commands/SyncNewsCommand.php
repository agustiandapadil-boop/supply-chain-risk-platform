<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NewsService;

class SyncNewsCommand extends Command
{
    protected $signature =
        'sync:news';

    protected $description =
        'Sync news articles';

    public function handle(
        NewsService $service
    ): int
    {
        $this->info(
            'Syncing news...'
        );

        $count =
            $service->syncNews();

        $this->info(
            "{$count} news synced."
        );

        return self::SUCCESS;
    }
}