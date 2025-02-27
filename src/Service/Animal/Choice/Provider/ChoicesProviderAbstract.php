<?php

declare(strict_types=1);

namespace App\Service\Animal\Choice\Provider;

abstract class ChoicesProviderAbstract implements ChoicesProviderInterface
{
    protected array $choices = [];

    public function __construct() {
        $this->choices = $this->getChoices();
    }

    public function getKeyByValue(mixed $value): string
    {
        return array_search($value, $this->choices);
    }
}