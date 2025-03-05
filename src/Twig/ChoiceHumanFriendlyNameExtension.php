<?php

declare(strict_types=1);

namespace App\Twig;

use App\Service\Animal\Choice\ChoicesServiceInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ChoiceHumanFriendlyNameExtension extends AbstractExtension
{
    public function __construct(
        private ChoicesServiceInterface $choicesService,
        private TranslatorInterface $translator
    ) {}

    public function getFilters(): array
    {
        return [
            new TwigFilter('choice_human_friendly_name', [$this, 'getHumanFriendlyName'], ['is_safe' => ['html']]),
        ];
    }

    public function getHumanFriendlyName(mixed $value, string $key): string
    {
        if (!$this->choicesService->isKeySupported($key)) {
            return (string) $value;
        }

        try {
            return $this->translator->trans($this->choicesService->getProviderByKey($key)->getKeyByValue($value));
        } catch (\InvalidArgumentException) {
            return (string) $value;
        }
    }
}
