<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Port;
use App\Models\RiskScore;
use App\Models\RecommendationScore;

class RecommendationEngineService
{
    public function calculateAll()
    {
        $countries =
            Country::with([
                'economicIndicator',
                'riskScore'
            ])->get();
            
        $maxGDP =
            Country::join(
                'economic_indicators',
                'countries.id',
                '=',
                'economic_indicators.country_id'
            )
            ->max('gdp');

        $maxExport =
            Country::join(
                'economic_indicators',
                'countries.id',
                '=',
                'economic_indicators.country_id'
            )
            ->max('export_value');

        $maxPorts =
            Port::selectRaw(
                'count(*) as total'
            )
            ->groupBy(
                'country_id'
            )
            ->get()
            ->max('total');

        foreach ($countries as $country) {

            $risk =
                $country->riskScore
                ->total_score
                ?? 50;

            $riskComponent =
                (100 - $risk)
                * 0.4;

            $gdp =
                $country->economicIndicator
                ->gdp
                ?? 0;

            $gdpComponent =
                $maxGDP > 0
                ? (($gdp / $maxGDP) * 100) * 0.3
                : 0;

            $export =
                $country->economicIndicator
                ->export_value
                ?? 0;

            $exportComponent =
                $maxExport > 0
                ? (($export / $maxExport) * 100) * 0.2
                : 0;

            $portCount =
                Port::where(
                    'country_id',
                    $country->id
                )->count();

            $portComponent =
                $maxPorts > 0
                ? (($portCount / $maxPorts) * 100) * 0.1
                : 0;

            $score =
                round(

                    $riskComponent

                    +

                    $gdpComponent

                    +

                    $exportComponent

                    +

                    $portComponent,

                    2
                );

            RecommendationScore::updateOrCreate(

                [
                    'country_id' =>
                        $country->id
                ],

                [

                    'risk_component' =>
                        $riskComponent,
                    'gdp_component' =>
                        $gdpComponent,
                    'export_component' =>
                        $exportComponent,
                    'port_component' =>
                        $portComponent,
                    'recommendation_score' =>
                        $score
                ]
            );
        }
    }
}