<?php

namespace App\Services;

use App\Models\Alert;
use App\Models\Country;

class AlertService
{
    public function generateAlerts(): int
    {
        Alert::query()->delete();

        $count = 0;

        $countries = Country::with([
            'riskScore',
            'weatherRecord',
            'currencyRate',
        ])->get();

        foreach ($countries as $country) {

            $count += $this->generateCountryAlerts(
                $country
            );
        }

        return $count;
    }

    private function generateCountryAlerts(
        Country $country
    ): int
    {
        $created = 0;

        $risk = $country->riskScore;

        if (!$risk) {
            return 0;
        }


        if ($risk->risk_level === 'HIGH') {

            $this->createAlert(
                $country->id,
                'Risk',
                'High',
                "Overall country risk score is {$risk->total_score}"
            );

            $created++;
        }

        if ($risk->weather_score >= 70) {

            $this->createAlert(
                $country->id,
                'Weather',
                'High',
                'Extreme weather risk detected'
            );

            $created++;
        }

        if ($risk->inflation_score >= 60) {

            $this->createAlert(
                $country->id,
                'Inflation',
                'Medium',
                'High inflation risk detected'
            );

            $created++;
        }


        if ($risk->currency_score >= 70) {

            $this->createAlert(
                $country->id,
                'Currency',
                'Medium',
                'Currency instability detected'
            );

            $created++;
        }

        return $created;
    }

    private function createAlert(
        int $countryId,
        string $type,
        string $severity,
        string $message
    ): void
    {
        Alert::create([
            'country_id'   => $countryId,
            'title'        => $type . ' Alert',
            'message'      => $message,
            'severity'     => $severity,
            'alert_type'   => $type,
            'is_active'    => true,
            'triggered_at' => now(),
        ]);
    }
}