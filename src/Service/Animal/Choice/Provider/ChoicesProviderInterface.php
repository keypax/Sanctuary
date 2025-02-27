<?php

declare(strict_types=1);

namespace App\Service\Animal\Choice\Provider;

interface ChoicesProviderInterface
{
    public function getKey(): string;
    /**
     * @return array<string, int>
     */
    public function getChoices(): array;
    public function getKeyByValue(mixed $value): string;
}