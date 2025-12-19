<?php

declare(strict_types=1);

namespace App\Tests\Domain\ServiceImpl;

use App\Domain\ProviderInterface\VisitorIncrementProviderInterface;
use App\Domain\ServiceImpl\VisitorIncrement;
use DateTimeImmutable;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\TestCase;

final class VisitorIncrementTest extends TestCase
{
    #[AllowMockObjectsWithoutExpectations]
    public function testGetCountDelegatesToProviderAndReturnsResult(): void
    {
        $provider = $this->createMock(VisitorIncrementProviderInterface::class);
        $service = new VisitorIncrement($provider);

        $provider->expects(self::once())
            ->method('get')
            ->with()
            ->willReturn(123);

        self::assertSame(123, $service->getCount());
    }

    public function testSaveVisitorConnexionDelegatesWithParams(): void
    {
        $provider = $this->createMock(VisitorIncrementProviderInterface::class);
        $service = new VisitorIncrement($provider);

        $ip = '203.0.113.42';
        $browser = 'Firefox/121.0';
        $date = new DateTimeImmutable('2025-01-01 12:34:56');

        $provider->expects(self::once())
            ->method('save')
            ->with(
                self::identicalTo($ip),
                self::identicalTo($browser),
                self::callback(function ($arg) use ($date) {
                    self::assertInstanceOf(DateTimeImmutable::class, $arg);
                    self::assertSame($date->getTimestamp(), $arg->getTimestamp());
                    return true;
                })
            );

        $service->saveVisitorConnexion($ip, $browser, $date);
    }

    public function testSaveVisitorConnexionAcceptsNulls(): void
    {
        $provider = $this->createMock(VisitorIncrementProviderInterface::class);
        $service = new VisitorIncrement($provider);

        $date = new DateTimeImmutable('now');

        $provider->expects(self::once())
            ->method('save')
            ->with(
                self::isNull(),
                self::isNull(),
                self::isInstanceOf(DateTimeImmutable::class)
            );

        $service->saveVisitorConnexion(null, null, $date);
    }
}
