<?php

declare(strict_types=1);

namespace App\Service\Animal\Choice\Provider;

abstract class ChoicesProviderAbstract implements ChoicesProviderInterface
{
    protected array $choices = [];
    /** @return array<string, int> */
    protected abstract function prepareChoices(): array;

    public function __construct() {
        $this->choices = $this->prepareChoices();
    }

    public function getChoices(): array
    {
        return $this->choices;
    }

    public function getKeyByValue(mixed $value): string
    {
        return array_search($value, $this->choices);
    }
}