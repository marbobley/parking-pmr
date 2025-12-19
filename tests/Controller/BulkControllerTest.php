<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Domain\ProviderInterface\AdresseProcheOriginProviderInterface;
use App\Domain\ServiceInterface\BulkLoadAdresseProcheInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\InMemoryUser;

final class BulkControllerTest extends WebTestCase
{
    public function testBulkLoad_adminLogged(): void
    {
        $client = BulkControllerTest::createClient();
        $container = BulkControllerTest::getContainer();

        $testUser = new InMemoryUser('admin', 'password', ['ROLE_ADMIN']);
        $client->loginUser($testUser);

        $bulkLoader = $this->createMock(BulkLoadAdresseProcheInterface::class);

        $expectedAdresseProches = 2;

        $bulkLoader->expects(self::once())
            ->method('loadAndSave')
            ->willReturn($expectedAdresseProches);

        // Override services in the test container
        $container->set(BulkLoadAdresseProcheInterface::class, $bulkLoader);

        $client->request('GET', '/admin/bulk/load');

        self::assertResponseIsSuccessful();
        $content = $client->getResponse()->getContent();
        self::assertIsString($content);
        self::assertStringContainsString('Load : 2', $content);
    }

    public function testBulkLoad_userLogged(): void
    {
        $client = BulkControllerTest::createClient();
        $container = BulkControllerTest::getContainer();

        $testUser = new InMemoryUser('user', 'password', ['ROLE_USER']);
        $client->loginUser($testUser);

        $bulkLoader = $this->createMock(BulkLoadAdresseProcheInterface::class);

        $expectedAdresseProches = 2;

        $bulkLoader->expects(self::exactly(0))
            ->method('loadAndSave')
            ->willReturn($expectedAdresseProches);

        // Override services in the test container
        $container->set(BulkLoadAdresseProcheInterface::class, $bulkLoader);

        $client->request('GET', '/admin/bulk/load');

        self::assertResponseStatusCodeSame(403);
    }

    public function testBulkLoad_notLogged(): void
    {
        $client = BulkControllerTest::createClient();
        $container = BulkControllerTest::getContainer();

        $bulkLoader = $this->createMock(BulkLoadAdresseProcheInterface::class);

        $expectedAdresseProches = 2;

        $bulkLoader->expects(self::exactly(0))
            ->method('loadAndSave')
            ->willReturn($expectedAdresseProches);

        // Override services in the test container
        $container->set(BulkLoadAdresseProcheInterface::class, $bulkLoader);

        $client->request('GET', '/admin/bulk/load');

        self::assertResponseRedirects();
        $content = $client->getResponse()->getContent();
        self::assertIsString($content);
        self::assertStringContainsString('login', $content);
    }

    public function testBulkDelete_adminLogged(): void
    {
        $client = BulkControllerTest::createClient();
        $container = BulkControllerTest::getContainer();

        $testUser = new InMemoryUser('admin', 'password', ['ROLE_ADMIN']);
        $client->loginUser($testUser);

        $originProvider = $this->createMock(AdresseProcheOriginProviderInterface::class);
        $originProvider->expects(self::once())
            ->method('deleteAll');

        $container->set(AdresseProcheOriginProviderInterface::class, $originProvider);

        $client->request('GET', '/admin/bulk/delete');

        self::assertResponseIsSuccessful();
        $content = $client->getResponse()->getContent();
        self::assertIsString($content);
        self::assertStringContainsString('DELETE', $content);
    }

    public function testBulkDelete_userLogged(): void
    {
        $client = BulkControllerTest::createClient();
        $container = BulkControllerTest::getContainer();

        $testUser = new InMemoryUser('user', 'password', ['ROLE_USER']);
        $client->loginUser($testUser);

        $originProvider = $this->createMock(AdresseProcheOriginProviderInterface::class);
        $originProvider->expects(self::exactly(0))
            ->method('deleteAll');

        $container->set(AdresseProcheOriginProviderInterface::class, $originProvider);

        $client->request('GET', '/admin/bulk/delete');

        self::assertResponseStatusCodeSame(403);
    }

    public function testBulkDelete_notLogged(): void
    {
        $client = BulkControllerTest::createClient();
        $container = BulkControllerTest::getContainer();

        $originProvider = $this->createMock(AdresseProcheOriginProviderInterface::class);
        $originProvider->expects(self::exactly(0))
            ->method('deleteAll');

        $container->set(AdresseProcheOriginProviderInterface::class, $originProvider);

        $client->request('GET', '/admin/bulk/delete');

        self::assertResponseRedirects();
        $content = $client->getResponse()->getContent();
        self::assertIsString($content);
        self::assertStringContainsString('login', $content);
    }
}
