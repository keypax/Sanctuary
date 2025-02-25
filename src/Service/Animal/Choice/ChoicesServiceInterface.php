<?php

namespace App\Service\Animal\Choice;

use App\Service\Animal\Choice\Exception\ChoicesProviderException;
use App\Service\Animal\Choice\Provider\ChoicesProviderInterface;

interface ChoicesServiceInterface
{
    /**
     * @param string $key
     * @throws ChoicesProviderException if provider with given key not found
     * @return ChoicesProviderInterface
     */
    public function getProviderByKey(string $key): ChoicesProviderInterface;

    /**
     * @param string $key
     * @return bool - returns true if there is provider with given key, false otherwise
     */
    public function isKeySupported(string $key): bool;
}