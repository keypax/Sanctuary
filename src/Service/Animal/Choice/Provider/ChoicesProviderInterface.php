<?php

declare(strict_types=1);

namespace App\Service\Animal\Choice\Provider;

interface ChoicesProviderInterface
{
    public function getKey(): string;
    public function getChoices(): array;
    public function getKeyByValue(mixed $value): string;
}