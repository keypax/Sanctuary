<?php

declare(strict_types=1);

namespace App\Tests\Service\Animal\Choice\Provider;

use PHPUnit\Framework\TestCase;
use App\Service\Animal\Choice\Provider\ChoicesProviderAbstract;

class ChoicesProviderAbstractTest extends TestCase
{
    public function testGetKeyByValueReturnsCorrectKey(): void
    {
        $provider = new class extends ChoicesProviderAbstract {
            public function getKey(): string
            {
                return 'dummy';
            }

            public function getChoices(): array
            {
                return [
                    'option.one' => 10,
                    'option.two' => 20,
                    'option.three' => 30,
                ];
            }
        };

        $this->assertSame('option.one', $provider->getKeyByValue(10));
        $this->assertSame('option.two', $provider->getKeyByValue(20));
        $this->assertSame('option.three', $provider->getKeyByValue(30));
    }

    public function testGetKey(): void
    {
        $provider = new class extends ChoicesProviderAbstract {
            public function getKey(): string
            {
                return 'dummy_provider';
            }
            public function getChoices(): array
            {
                return [];
            }
        };

        $this->assertSame('dummy_provider', $provider->getKey());
    }

    public function testGetKeyByValueWithNonExistingValueThrowsTypeError(): void
    {
        $provider = new class extends ChoicesProviderAbstract {
            public function getKey(): string
            {
                return 'dummy';
            }
            public function getChoices(): array
            {
                return ['option.one' => 10];
            }
        };

        $this->expectException(\TypeError::class);
        $provider->getKeyByValue(999);
    }
}
