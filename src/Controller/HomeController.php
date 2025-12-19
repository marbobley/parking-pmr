<?php

namespace App\Controller;

use App\Domain\ServiceInterface\GetAllParkingsInterface;
use App\Domain\ServiceInterface\UxMapInterface;
use App\Domain\ServiceInterface\VisitorIncrementInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(Request                   $request,
                          GetAllParkingsInterface   $getAllParkings,
                          VisitorIncrementInterface $visitorCounter,
                          UxMapInterface            $uxMap,
    ): Response
    {
        $clientIP = $request->getClientIp();
        $browser = $request->headers->get('User-Agent');
        // Incrémente le compteur de visiteurs à chaque affichage de la page d'accueil
        $visitorCounter->saveVisitorConnexion($clientIP, $browser, new \DateTimeImmutable());
        $parkings = $getAllParkings->findAll();

        $mapUx = $uxMap->generate($parkings);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'map' => $mapUx,
            'parkings' => $parkings,
        ]);
    }
}
