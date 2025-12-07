<?php

namespace App\Controller;

use App\Domain\ServiceInterface\GetAllParkingsInterface;
use App\Domain\ServiceInterface\VisitorIncrementInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\UX\Map\Bridge\Leaflet\LeafletOptions;
use Symfony\UX\Map\Bridge\Leaflet\Option\TileLayer;
use Symfony\UX\Map\Icon\Icon;
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
        $iconRed = Icon::svg('<svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 96 96"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#FF0000" stroke="#000" d="M48 88s32 -24 32 -50c0 -16.568 -14.326 -30 -32 -30S16 21.432 16 38c0 26 32 50 32 50Z" stroke-width="2"/><path stroke="#000000" stroke-linecap="round" d="M42 28v32" stroke-width="2"/><path fill="#FFFFFF" stroke="#000000" d="M42 28h12a8 8 0 0 1 0 16H42z" stroke-width="2"/></g></svg>');
        $iconBlue = Icon::svg('<svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 96 96"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#0000FF" stroke="#000" d="M48 88s32 -24 32 -50c0 -16.568 -14.326 -30 -32 -30S16 21.432 16 38c0 26 32 50 32 50Z" stroke-width="2"/><path stroke="#fff" stroke-linecap="round" d="M42 28v32" stroke-width="2"/><path fill="#00FF00" stroke="#fff" d="M42 28h12a8 8 0 0 1 0 16H42z" stroke-width="2"/></g></svg>');
        $iconGreen = Icon::svg('<svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 96 96"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="#00FF00" stroke="#000" d="M48 88s32 -24 32 -50c0 -16.568 -14.326 -30 -32 -30S16 21.432 16 38c0 26 32 50 32 50Z" stroke-width="2"/><path stroke="#000000" stroke-linecap="round" d="M42 28v32" stroke-width="2"/><path fill="#FFFFFF" stroke="#000000" d="M42 28h12a8 8 0 0 1 0 16H42z" stroke-width="2"/></g></svg>');

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

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'map' => $map,
            'parkings' => $parkings,
        ]);
    }
}
