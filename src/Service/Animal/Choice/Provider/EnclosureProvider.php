<?php

declare(strict_types=1);

namespace App\Service\Animal\Choice\Provider;

use App\Repository\EnclosureRepositoryInterface;

class EnclosureProvider extends ChoicesProviderAbstract
{
    public function __construct(
        private readonly EnclosureRepositoryInterface $enclosureRepository
    ) {
        parent::__construct();
    }

    public function getKey(): string
    {
        return 'enclosure';
    }

    protected function prepareChoices(): array
    {
        $enclosures = $this->enclosureRepository->findAll();
        $choices = [];
        foreach ($enclosures as $enclosure) {
            $choices[$enclosure->getEnclosureName()] = $enclosure->getId();
        }

        return $choices;
    }
}