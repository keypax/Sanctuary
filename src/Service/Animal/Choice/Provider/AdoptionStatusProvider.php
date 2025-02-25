<?php

namespace App\Service\Animal\Choice\Provider;

class AdoptionStatusProvider extends ChoicesProviderAbstract
{

    public function getKey(): string
    {
        return "adoption_status";
    }

    public function getChoices(): array
    {
        return [
            'adoption_status.available' => 0,
            'adoption_status.pending_adoption' => 1,
            'adoption_status.adopted' => 2,
            'adoption_status.on_hold' => 3,
            'adoption_status.unavailable' => 4,
            'adoption_status.deceased' => 5,
        ];
    }
}