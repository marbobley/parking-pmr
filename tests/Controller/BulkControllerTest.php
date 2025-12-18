<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Domain\ServiceInterface\BulkLoadAdresseProcheInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class BulkControllerTest extends WebTestCase
{
    public function testBulkLoad(): void
    {
        $client = BulkControllerTest::createClient();
        $container = BulkControllerTest::getContainer();

        $bulkLoader = $this->createMock(BulkLoadAdresseProcheInterface::class);

        $expectedAdresseProches = 2;

        $bulkLoader->expects(self::once())
            ->method('loadAndSave')
            ->willReturn($expectedAdresseProches);

        // Override services in the test container
        $container->set(BulkLoadAdresseProcheInterface::class, $bulkLoader);

        $client->request('GET', '/bulk/load');

        self::assertResponseIsSuccessful();
        $content = $client->getResponse()->getContent();
        self::assertIsString($content);
        self::assertStringContainsString('Load : 2', $content);
    }

    /*
    public function testBulkShow(): void
    {
        $client = BulkControllerTest::createClient();
        $container = BulkControllerTest::getContainer();

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
        }*/
}
