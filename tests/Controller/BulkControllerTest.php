<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Domain\Model\AdresseProcheModel;
use App\Domain\Model\CoordinateModel;
use App\Domain\Model\ParkingModel;
use App\Domain\ProviderInterface\AdresseProcheOriginProviderInterface;
use App\Domain\ServiceInterface\BulkLoadAdresseProcheInterface;
use App\Domain\ServiceInterface\GetAllParkingsInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class BulkControllerTest extends WebTestCase
{
    public function testBulkLoad(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        $getAllParkings = $this->createMock(GetAllParkingsInterface::class);
        $bulkLoader = $this->createMock(BulkLoadAdresseProcheInterface::class);
        $originProvider = $this->createMock(AdresseProcheOriginProviderInterface::class);

        // Fake parkings returned
        $parkings = [
            new ParkingModel('p1', 43.61, 3.87, 10, 'Addr 1'),
            new ParkingModel('p2', 43.62, 3.88, 5, 'Addr 2'),
        ];
        $getAllParkings->method('findAll')->willReturn($parkings);

        // When bulk loading with the coordinates, return 2 adresse proches
        $expectedAdresseProches = [
            new AdresseProcheModel('Label 1', new CoordinateModel(43.61, 3.87)),
            new AdresseProcheModel('Label 2', new CoordinateModel(43.62, 3.88)),
        ];

        $bulkLoader->expects(self::once())
            ->method('findAll')
            ->with(self::callback(function (array $coordinates): bool {
                // Expect an array of CoordinateModel with same count as parkings
                if (count($coordinates) !== 2) {
                    return false;
                }
                foreach ($coordinates as $coord) {
                    if (!$coord instanceof CoordinateModel) {
                        return false;
                    }
                }
                return true;
            }))
            ->willReturn($expectedAdresseProches);

        $originProvider->expects(self::once())
            ->method('saveAll')
            ->with($expectedAdresseProches);

        // Override services in the test container
        $container->set(GetAllParkingsInterface::class, $getAllParkings);
        $container->set(BulkLoadAdresseProcheInterface::class, $bulkLoader);
        $container->set(AdresseProcheOriginProviderInterface::class, $originProvider);

        $client->request('GET', '/bulk/load');

        self::assertResponseIsSuccessful();
        $content = $client->getResponse()->getContent();
        self::assertIsString($content);
        self::assertStringContainsString('Load : 2', $content);
    }

    public function testBulkShow(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        $originProvider = $this->createMock(AdresseProcheOriginProviderInterface::class);
        $originProvider->method('findAll')->willReturn([
            new AdresseProcheModel('Alpha', new CoordinateModel(43.6, 3.8)),
            new AdresseProcheModel('Beta', new CoordinateModel(43.7, 3.9)),
        ]);

        $container->set(AdresseProcheOriginProviderInterface::class, $originProvider);

        $client->request('GET', '/bulk/show');

        self::assertResponseIsSuccessful();
        $content = $client->getResponse()->getContent();
        self::assertIsString($content);
        self::assertStringContainsString('Alpha', $content);
        self::assertStringContainsString('Beta', $content);
    }

    public function testBulkDelete(): void
    {
        $client = static::createClient();
        $container = static::getContainer();

        $originProvider = $this->createMock(AdresseProcheOriginProviderInterface::class);
        $originProvider->expects(self::once())
            ->method('deleteAll');

        $container->set(AdresseProcheOriginProviderInterface::class, $originProvider);

        $client->request('GET', '/bulk/delete');

        self::assertResponseIsSuccessful();
        $content = $client->getResponse()->getContent();
        self::assertIsString($content);
        self::assertStringContainsString('DELETE', $content);
    }
}
