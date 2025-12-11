<?php

namespace App\Domain\ServiceImpl;

use App\Domain\ServiceInterface\UxMapInterface;
use Symfony\UX\Map\Bridge\Leaflet\LeafletOptions;
use Symfony\UX\Map\Bridge\Leaflet\Option\TileLayer;
use Symfony\UX\Map\Icon\Icon;
use Symfony\UX\Map\InfoWindow;
use Symfony\UX\Map\Map;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\Point;

readonly class UxMap implements UxMapInterface
{


    public function __construct(private SvgIcon $svgIcon){

    }


    public function generate(array $parkings) : Map
    {
        $map = $this->initializeMap();

        $iconRed = $this->svgIcon->getParkingIcon(SvgIcon::RED );
        $iconGreen = $this->svgIcon->getParkingIcon(SvgIcon::GREEN);
        $iconBlue = $this->svgIcon->getParkingIcon(SvgIcon::BLUE);

        foreach ($parkings as $parking) {

            if($parking->getNombrePlaceDisponible() === -1) {
                $icon = $iconBlue;
            }elseif($parking->getNombrePlaceDisponible() === 0) {
                $icon = $iconRed;
            }else {
                $icon = $iconGreen;
            }

            $map->addMarker(new Marker(
                position: new Point($parking->getLatitude(), $parking->getLongitude()),
                title: 'Place PMR',
                infoWindow: new InfoWindow(
                    headerContent: '<b>Place PMR</b>',
                    content: 'latitude: ' . $parking->getLatitude() . ' longitude: ' . $parking->getLongitude() . $parking->getNombrePlaceDisponible()
                ),
                icon: $icon));
        }
        return $map;
    }

    /** Par défaut, crée une map centrée sur montpellier
     * @param float $latitude
     * @param float $longitude
     * @return Map
     */
    public function initializeMap( float $latitude = 43.62505, float $longitude = 3.862038): Map
    {
        return (new Map('default'))
            ->center(new Point($latitude, $longitude))
            ->zoom(13)
            ->options((new LeafletOptions())
                ->tileLayer(new TileLayer(
                    url: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    options: ['maxZoom' => 19]
                ))
            );
    }
}
