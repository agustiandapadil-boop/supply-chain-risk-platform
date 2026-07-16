<?php

namespace App\Services;

use App\Models\Port;
use App\Models\Country;

class PortSyncService
{
    public function sync(): int
{
    $path = storage_path(
        'app/world_port_index.csv'
    );

    if (!file_exists($path)) {

        throw new \Exception(
            'world_port_index.csv not found'
        );
    }

    $file = fopen($path, 'r');

    $count = 0;
    fgetcsv($file);

    while (
        ($row = fgetcsv($file))
        !== false
    ) {

        $iso2 =
            strtoupper(
                trim($row[6])
            );

        $country =
            Country::where(
                'iso2',
                $iso2
            )->first();

        if (!$country) {

            continue;
        }

        Port::updateOrCreate(

            [

                'country_id' =>
                    $country->id,

                'port_name' =>
                    trim($row[5])

            ],

            [

                'latitude' =>
                    $row[7],

                'longitude' =>
                    $row[8],

                'harbor_size' =>
                    $row[17],

                'harbor_type' =>
                    $row[18]

            ]
        );

        $count++;
    }

    fclose($file);

    return $count;
}
}