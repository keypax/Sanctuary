<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class PrintEmptyVariableExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('empty_placeholder_for_print', [$this, 'emptyPlaceholder'], ['is_safe' => ['html']]),
        ];
    }

    public function emptyPlaceholder(mixed $value): string
    {
        if (empty($value)) {
            return '___________________________';
        }

        return (string) $value;
    }
}