<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Port;
use App\Models\PortCongestion;

class GeneratePortCongestionCommand extends Command
{
    protected $signature =
        'ports:congestion';

    protected $description =
        'Generate port congestion';

    public function handle()
    {
        $count = 0;

        foreach (
            Port::all()
            as $port
        ) {

            $waiting =
                rand(0,50);

            $delay =
                rand(0,72);

            $utilization =
                rand(20,100);

            $risk = 'LOW';

            if (
                $utilization >= 80
                ||
                $delay >= 48
            ) {
                $risk = 'HIGH';
            }

            elseif (
                $utilization >= 60
            ) {
                $risk = 'MEDIUM';
            }

            PortCongestion::updateOrCreate(

                [
                    'port_id' =>
                        $port->id
                ],

                [
                    'waiting_vessel' =>
                        $waiting,

                    'delay_hours' =>
                        $delay,

                    'berth_utilization' =>
                        $utilization,

                    'risk_level' =>
                        $risk
                ]
            );

            $count++;
        }
        
        $this->info(
            "{$count} ports updated"
        );

        return self::SUCCESS;
    }
}