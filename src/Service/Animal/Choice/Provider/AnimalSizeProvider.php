<?php

declare(strict_types=1);

namespace App\Service\Animal\Choice\Provider;

class AnimalSizeProvider extends ChoicesProviderAbstract
{

    public function getKey(): string
    {
        return 'size';
    }

    protected function prepareChoices(): array
    {
        return [
            'animal.size.very_small' => 0,
            'animal.size.small' => 1,
            'animal.size.medium' => 2,
            'animal.size.large' => 3,
            'animal.size.very_large' => 4,
        ];
    }
}