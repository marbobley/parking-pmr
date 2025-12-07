<?php

namespace App\Controller;

use App\Domain\ServiceImpl\GetAllParkings;
use App\Domain\ServiceInterface\GetAllParkingsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Map\Bridge\Leaflet\LeafletOptions;
use Symfony\UX\Map\Bridge\Leaflet\Option\TileLayer;
use Symfony\UX\Map\InfoWindow;
use Symfony\UX\Map\Map;
use Symfony\UX\Map\Marker;
use Symfony\UX\Map\Point;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(GetAllParkingsInterface $getAllParkings): Response
    {
        $parkings = $getAllParkings->findAll();
        $map = (new Map('default'))
            ->center(new Point(43.62505, 3.862038))
            ->zoom(13)
            ->options((new LeafletOptions())
                ->tileLayer(new TileLayer(
                    url: 'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
                    options: ['maxZoom' => 19]
                ))
            );

        foreach ($parkings as $parking) {

            $url = $this->generateUrl('app_plus_info_index', ['latitude' => $parking->getLatitude(), 'longitude' => $parking->getLongitude()]);
            $map->addMarker(new Marker(
                position: new Point($parking->getLatitude(), $parking->getLongitude()),
                title: 'Place PMR',
                infoWindow: new InfoWindow(
                    headerContent: '<b>Place PMR</b>',
                    content: 'latitude: ' . $parking->getLatitude() . ' longitude: ' . $parking->getLongitude() . '<p><a href="'.$url.'">Plus d\'info</a></p>'
                )));
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'map' => $map,
            'parkings' => $parkings,
        ]);
    }
}
