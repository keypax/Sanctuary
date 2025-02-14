<?php

namespace App\Service\BreedsProvider;

interface BreedsProviderInterface
{
    public function getBreeds(string $species): array;
}