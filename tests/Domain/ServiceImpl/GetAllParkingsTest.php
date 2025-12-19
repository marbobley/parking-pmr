<?php

declare(strict_types=1);

namespace App\Tests\Domain\ServiceImpl;

use App\Domain\Model\ParkingModel;
use App\Domain\ProviderInterface\ParkingProviderInterface;
use App\Domain\ServiceImpl\GetAllParkings;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\TestCase;

final class GetAllParkingsTest extends TestCase
{
    #[AllowMockObjectsWithoutExpectations]
    public function testFindAllDelegatesToProviderAndReturnsResult(): void
    {
        $provider = $this->createMock(ParkingProviderInterface::class);

        $service = new GetAllParkings($provider);

        $expected = [
            new ParkingModel('1', 10.0, 20.0, 2, 'addr1'),
            new ParkingModel('2', 30.0, 40.0, 3, 'addr2'),
        ];

        $provider->expects(self::once())
            ->method('findAll')
            ->with()
            ->willReturn($expected);

        $result = $service->findAll();

        self::assertSame($expected, $result);
        self::assertCount(2, $result);
        self::assertInstanceOf(ParkingModel::class, $result[0]);
        self::assertInstanceOf(ParkingModel::class, $result[1]);
    }

    public function testFindAllReturnsEmptyArrayWhenProviderReturnsEmpty(): void
    {
        $provider = $this->createMock(ParkingProviderInterface::class);

        $service = new GetAllParkings($provider);

        $provider->expects(self::once())
            ->method('findAll')
            ->willReturn([]);

        $result = $service->findAll();

        self::assertIsArray($result);
        self::assertCount(0, $result);
    }
}
