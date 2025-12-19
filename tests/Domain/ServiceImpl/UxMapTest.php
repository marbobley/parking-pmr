<?php

declare(strict_types=1);

namespace App\Tests\Domain\ServiceImpl;

use App\Domain\Model\ParkingModel;
use App\Domain\ServiceImpl\UxMap;
use App\Domain\Util\SvgIcon as AppSvgIconUtil;
use PHPUnit\Framework\TestCase;

final class UxMapTest extends TestCase
{
    public function testGenerateCreatesMarkersWithCorrectIconsAndInfoWindow(): void
    {
        $uxMap = new UxMap(new AppSvgIconUtil());

        $p1 = new ParkingModel('p1', 43.6, 3.88, -1, 'addr bleu');
        $p2 = new ParkingModel('p2', 43.61, 3.89, 0, 'addr rouge');
        $p3 = new ParkingModel('p3', 43.62, 3.9, 2, 'addr vert');

        $map = $uxMap->generate([$p1, $p2, $p3]);

        $asArray = $map->toArray();

        // Vérifications de base sur la carte
        self::assertIsArray($asArray);
        self::assertSame(13.0, $asArray['zoom']);
        self::assertIsArray($asArray['center']);
        self::assertArrayHasKey('lat', $asArray['center']);
        self::assertArrayHasKey('lng', $asArray['center']);

        // Markers
        $markers = $asArray['markers'];
        self::assertIsArray($markers);
        self::assertCount(3, $markers);

        // 1) -1 -> BLUE
        $m1 = $markers[0];
        self::assertSame(['lat' => 43.6, 'lng' => 3.88], $m1['position']);
        self::assertSame('Place PMR', $m1['title']);
        self::assertSame('adresse : addr bleu', $m1['infoWindow']['content']);
        self::assertIsArray($m1['icon']);
        self::assertSame('svg', $m1['icon']['type']);
        self::assertIsString($m1['icon']['html']);
        self::assertStringContainsString('#0000FF', $m1['icon']['html']); // BLUE

        // 2) 0 -> RED
        $m2 = $markers[1];
        self::assertSame(['lat' => 43.61, 'lng' => 3.89], $m2['position']);
        self::assertSame('Place PMR', $m2['title']);
        self::assertSame('adresse : addr rouge', $m2['infoWindow']['content']);
        self::assertSame('svg', $m2['icon']['type']);
        self::assertStringContainsString('#FF0000', $m2['icon']['html']); // RED

        // 3) >0 -> GREEN
        $m3 = $markers[2];
        self::assertSame(['lat' => 43.62, 'lng' => 3.9], $m3['position']);
        self::assertSame('Place PMR', $m3['title']);
        self::assertSame('adresse : addr vert', $m3['infoWindow']['content']);
        self::assertSame('svg', $m3['icon']['type']);
        self::assertStringContainsString('#06402B', $m3['icon']['html']); // GREEN
    }

    public function testGenerateWithEmptyArrayProducesMapWithNoMarkers(): void
    {
        $uxMap = new UxMap(new AppSvgIconUtil());

        $map = $uxMap->generate([]);
        $asArray = $map->toArray();

        self::assertSame(13.0, $asArray['zoom']);
        self::assertIsArray($asArray['center']);
        self::assertIsArray($asArray['markers']);
        self::assertCount(0, $asArray['markers']);
    }
}
