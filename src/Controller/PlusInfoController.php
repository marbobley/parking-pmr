<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\ServiceInterface\GetAdresseProcheInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class PlusInfoController extends AbstractController
{
    #[Route('/plus-info', name: 'app_plus_info_index',methods: ['GET'])]
    public function index(GetAdresseProcheInterface $adresseProcheService,
                          #[MapQueryParameter] float $longitude,
                          #[MapQueryParameter] float $latitude,
    ): Response
    {
        $adresseProche = $adresseProcheService->findOne($longitude, $latitude);
        return $this->render('plus_info/index.html.twig' , [
            'adresseProche' => $adresseProche,
        ]);
    }
}
