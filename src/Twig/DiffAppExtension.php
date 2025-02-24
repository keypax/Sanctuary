<?php

declare(strict_types=1);

namespace App\Twig;

use FineDiff\Diff;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DiffAppExtension extends AbstractExtension
{
    public function __construct(
        private Diff $differ
    ) {

    }

    public function getFilters()
    {
        return [
            new TwigFilter('diff', [$this, 'diff'], ['is_safe' => ['html']]),
        ];
    }

    public function diff(string $before, string $after): string
    {
        return $this->differ->render($before, $after);
    }
}