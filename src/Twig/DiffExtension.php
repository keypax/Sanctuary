<?php

declare(strict_types=1);

namespace App\Twig;

use FineDiff\Diff;
use FineDiff\Exceptions\GranularityCountException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DiffExtension extends AbstractExtension
{
    public function __construct(
        private readonly Diff $differ
    ) {

    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('diff', [$this, 'diff'], ['is_safe' => ['html']]),
        ];
    }

    public function diff(string $before, string $after): string
    {
        try {
            return $this->differ->render($before, $after);
        } catch (GranularityCountException) {
            return $after;
        }
    }
}