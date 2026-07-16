<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImportCountriesCommand extends Command
{
    protected $signature = 'import:countries';

    protected $description = 'Import countries from REST Countries API';

    public function handle(\App\Services\CountrySyncService $service): int
    {
        $this->info('Fetching countries from REST Countries API...');
        
        try {
            $count = $service->sync();
            $this->info("{$count} countries imported successfully.");
            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to import countries: ' . $e->getMessage());
            return self::FAILURE;
        }
    }
}