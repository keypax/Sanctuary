<?php

namespace App\Tests\Service\Animal\Choice;

use App\Service\Animal\Choice\ChoicesService;
use App\Service\Animal\Choice\Exception\ChoicesProviderException;
use App\Service\Animal\Choice\Provider\ChoicesProviderInterface;
use PHPUnit\Framework\TestCase;

class ChoicesServiceTest extends TestCase
{
    public function testGetProviderByKeyReturnsProvider(): void
    {
        $mock = $this->createMock(ChoicesProviderInterface::class);
        $mock->expects($this->once())
            ->method('getKey')
            ->willReturn('provider_key');

        $service = new ChoicesService([$mock]);
        $result = $service->getProviderByKey('provider_key');

        $this->assertSame($mock, $result);
    }

    public function testIsKeySupportedReturnsTrue(): void
    {
        $mock = $this->createMock(ChoicesProviderInterface::class);
        $mock->expects($this->any())
            ->method('getKey')
            ->willReturn('provider_key');

        $service = new ChoicesService([$mock]);

        $this->assertTrue($service->isKeySupported('provider_key'));
    }

    public function testIsKeySupportedReturnsFalse(): void
    {
        $mock = $this->createMock(ChoicesProviderInterface::class);
        $mock->expects($this->any())
            ->method('getKey')
            ->willReturn('another_key');

        $service = new ChoicesService([$mock]);

        $this->assertFalse($service->isKeySupported('provider_key'));
    }

    public function testGetProviderByKeyThrowsExceptionWhenNotFound(): void
    {
        $this->expectException(ChoicesProviderException::class);
        $this->expectExceptionMessage('Provider with key missing_key not found');

        $mock = $this->createMock(ChoicesProviderInterface::class);
        $mock->expects($this->any())
            ->method('getKey')
            ->willReturn('another_key');

        $service = new ChoicesService([$mock]);

        $service->getProviderByKey('missing_key');
    }
}