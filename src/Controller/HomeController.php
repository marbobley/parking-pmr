<?php

namespace App\Controller;

use App\Domain\ServiceImpl\GetAllParkings;
use App\Domain\ServiceInterface\GetAllParkingsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(GetAllParkingsInterface $getAllParkings): Response
    {
        $parkings = $getAllParkings->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'parkings' => $parkings,
        ]);
    }
}
