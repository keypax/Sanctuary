<?php

namespace App\Service\Animal\Choice\Provider;

use App\Repository\EnclosureRepositoryInterface;

readonly class EnclosureProvider implements ChoicesProviderInterface
{
    public function __construct(
        private EnclosureRepositoryInterface $enclosureRepository
    ) {}
    public function getKey(): string
    {
        return 'enclosure';
    }

    public function getChoices(): array
    {
        $enclosures = $this->enclosureRepository->findAll();
        $choices = [];
        foreach ($enclosures as $enclosure) {
            $choices[$enclosure->getEnclosureName()] = $enclosure->getId();
        }

        return $choices;
    }

    public function getKeyByValue(mixed $value): string
    {
        // TODO: Implement getKeyByValue() method.
    }
}