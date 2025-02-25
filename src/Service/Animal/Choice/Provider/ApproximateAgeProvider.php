<?php

namespace App\Service\Animal\Choice\Provider;

class ApproximateAgeProvider extends ChoicesProviderAbstract
{
    public function getKey(): string
    {
        return "approximate_age";
    }

    public function getChoices(): array
    {
        return [
            'approximate_age.less_than_week' => 0,
            'approximate_age.1_2_weeks' => 7,
            'approximate_age.2_4_weeks' => 14,
            'approximate_age.1_month' => 30,
            'approximate_age.2_months' => 60,
            'approximate_age.3_months' => 90,
            'approximate_age.4_months' => 120,
            'approximate_age.5_months' => 150,
            'approximate_age.6_months' => 180,
            'approximate_age.7_months' => 210,
            'approximate_age.8_months' => 240,
            'approximate_age.9_months' => 270,
            'approximate_age.10_months' => 300,
            'approximate_age.11_months' => 330,
            'approximate_age.1_year' => 365,
            'approximate_age.1_2_years' => 365,
            'approximate_age.2_3_years' => 730,
            'approximate_age.3_4_years' => 1095,
            'approximate_age.4_5_years' => 1460,
            'approximate_age.5_7_years' => 1825,
            'approximate_age.7_10_years' => 2555,
            'approximate_age.senior' => 3650,
        ];
    }
}