<?php

declare(strict_types=1);

namespace App\Tests\Domain\ServiceImpl;

use App\Domain\Model\AdresseProcheModel;
use App\Domain\Model\CoordinateModel;
use App\Domain\Model\ParkingModel;
use App\Domain\ProviderInterface\AdresseProcheOriginProviderInterface;
use App\Domain\ProviderInterface\AdresseProcheProviderInterface;
use App\Domain\ServiceImpl\BulkLoadAdresseProche;
use App\Domain\ServiceInterface\GetAllParkingsInterface;
use PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations;
use PHPUnit\Framework\TestCase;

final class BulkLoadAdresseProcheTest extends TestCase
{
    #[AllowMockObjectsWithoutExpectations]
    public function testFindAllDelegatesToProviderAndReturnsResult(): void
    {
        $provider = $this->createMock(AdresseProcheProviderInterface::class);
        $getAllParkings = $this->createMock(GetAllParkingsInterface::class);
        $originProvider = $this->createMock(AdresseProcheOriginProviderInterface::class);

        $service = new BulkLoadAdresseProche($provider, $getAllParkings, $originProvider);

        $coords = [new CoordinateModel(1.1, 2.2), new CoordinateModel(3.3, 4.4)];
        $expected = [
            new AdresseProcheModel('a', $coords[0]),
            new AdresseProcheModel('b', $coords[1]),
        ];

        $provider->expects(self::once())
            ->method('findAll')
            ->with(self::callback(function (array $arg) use ($coords) {
                self::assertCount(2, $arg);
                self::assertInstanceOf(CoordinateModel::class, $arg[0]);
                self::assertInstanceOf(CoordinateModel::class, $arg[1]);
                self::assertSame($coords[0]->getLatitude(), $arg[0]->getLatitude());
                self::assertSame($coords[0]->getLongitude(), $arg[0]->getLongitude());
                self::assertSame($coords[1]->getLatitude(), $arg[1]->getLatitude());
                self::assertSame($coords[1]->getLongitude(), $arg[1]->getLongitude());
                return true;
            }))
            ->willReturn($expected);

        $result = $service->findAll($coords);

        self::assertSame($expected, $result);
    }

    public function testLoadAndSaveNominal(): void
    {
        $provider = $this->createMock(AdresseProcheProviderInterface::class);
        $getAllParkings = $this->createMock(GetAllParkingsInterface::class);
        $originProvider = $this->createMock(AdresseProcheOriginProviderInterface::class);

        $service = new BulkLoadAdresseProche($provider, $getAllParkings, $originProvider);

        // Arrange parkings -> coordinates
        $p1 = new ParkingModel('1', 10.0, 20.0, 2, 'addr1');
        $p2 = new ParkingModel('2', 30.0, 40.0, 3, 'addr2');
        $getAllParkings->expects(self::once())
            ->method('findAll')
            ->willReturn([$p1, $p2]);

        $coords = [$p1->getCoordinate(), $p2->getCoordinate()];
        $adresseProches = [
            new AdresseProcheModel('label1', $coords[0]),
            new AdresseProcheModel('label2', $coords[1]),
        ];

        $provider->expects(self::once())
            ->method('findAll')
            ->with(self::callback(function (array $arg) use ($coords) {
                self::assertCount(2, $arg);
                self::assertInstanceOf(CoordinateModel::class, $arg[0]);
                self::assertInstanceOf(CoordinateModel::class, $arg[1]);
                // Verify coordinates values
                self::assertSame($coords[0]->getLatitude(), $arg[0]->getLatitude());
                self::assertSame($coords[0]->getLongitude(), $arg[0]->getLongitude());
                self::assertSame($coords[1]->getLatitude(), $arg[1]->getLatitude());
                self::assertSame($coords[1]->getLongitude(), $arg[1]->getLongitude());
                return true;
            }))
            ->willReturn($adresseProches);

        $originProvider->expects(self::once())
            ->method('saveAll')
            ->with(self::callback(function (array $arg) use ($adresseProches) {
                self::assertCount(2, $arg);
                self::assertInstanceOf(AdresseProcheModel::class, $arg[0]);
                self::assertInstanceOf(AdresseProcheModel::class, $arg[1]);
                self::assertSame($adresseProches[0]->getLabel(), $arg[0]->getLabel());
                self::assertSame($adresseProches[1]->getLabel(), $arg[1]->getLabel());
                return true;
            }));

        $count = $service->loadAndSave();

        self::assertSame(2, $count);
    }

    public function testLoadAndSaveWithNoParkings(): void
    {
        $provider = $this->createMock(AdresseProcheProviderInterface::class);
        $getAllParkings = $this->createMock(GetAllParkingsInterface::class);
        $originProvider = $this->createMock(AdresseProcheOriginProviderInterface::class);

        $service = new BulkLoadAdresseProche($provider, $getAllParkings, $originProvider);

        $getAllParkings->expects(self::once())
            ->method('findAll')
            ->willReturn([]);

        $provider->expects(self::once())
            ->method('findAll')
            ->with(self::callback(function (array $arg) {
                self::assertIsArray($arg);
                self::assertCount(0, $arg);
                return true;
            }))
            ->willReturn([]);

        $originProvider->expects(self::once())
            ->method('saveAll')
            ->with(self::callback(function (array $arg) {
                self::assertIsArray($arg);
                self::assertCount(0, $arg);
                return true;
            }));

        $count = $service->loadAndSave();

        self::assertSame(0, $count);
    }
}
