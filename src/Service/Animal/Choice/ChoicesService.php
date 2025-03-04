<?php

namespace App\Service\Animal\Choice;

use App\Service\Animal\Choice\Exception\ChoicesProviderException;
use App\Service\Animal\Choice\Provider\ChoicesProviderInterface;

readonly class ChoicesService implements ChoicesServiceInterface
{
    /**
     * @param ChoicesProviderInterface[] $choicesProviders
     */
    public function __construct(private iterable $choicesProviders) {}

    public function getProviderByKey(string $key): ChoicesProviderInterface
    {
        foreach ($this->choicesProviders as $provider) {
            if ($provider->getKey() === $key) {
                return $provider;
            }
        }

        throw new ChoicesProviderException(sprintf("Provider with key %s not found", $key));
    }

    public function isKeySupported(string $key): bool
    {
        foreach ($this->choicesProviders as $provider) {
            if ($provider->getKey() === $key) {
                return true;
            }
        }

        return false;
    }
}