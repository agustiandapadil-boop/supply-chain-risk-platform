<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PortSyncService;

class SyncPortsCommand extends Command
{
    protected $signature =
        'ports:sync';

    protected $description =
        'Import World Port Index';

    public function handle(
        PortSyncService $service
    )
    {
        $count =
            $service->sync();

        $this->info(
            "{$count} ports imported."
        );

        return self::SUCCESS;
    }
}