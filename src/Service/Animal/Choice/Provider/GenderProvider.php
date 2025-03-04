<?php

declare(strict_types=1);

namespace App\Service\Animal\Choice\Provider;

class GenderProvider extends ChoicesProviderAbstract
{
    public function getKey(): string
    {
        return "gender";
    }

    protected function prepareChoices(): array
    {
        return [
            'gender.unknown' => 0,
            'gender.male' => 1,
            'gender.female' => 2,
        ];
    }
}