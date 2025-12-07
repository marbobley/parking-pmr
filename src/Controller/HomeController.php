<?php

namespace App\Controller;

use App\Domain\ServiceInterface\GetAllParkingsInterface;
use App\Domain\ServiceInterface\VisitorIncrementInterface;
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
    public function index( GetAllParkingsInterface $getAllParkings, VisitorIncrementInterface $visitorCounter): Response
    {
        // Incrémente le compteur de visiteurs à chaque affichage de la page d'accueil
        $visitorCounter->increment();
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
            
            $map->addMarker(new Marker(
                position: new Point($parking->getLatitude(), $parking->getLongitude()),
                title: 'Place PMR',
                infoWindow: new InfoWindow(
                    headerContent: '<b>Place PMR</b>',
                    content: 'latitude: ' . $parking->getLatitude() . ' longitude: ' . $parking->getLongitude() . $parking->getNombrePlaceDisponible()
                )));
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'map' => $map,
            'parkings' => $parkings,
        ]);
    }
}
