<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\ServiceInterface\VisitorIncrementInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PlusInfoController extends AbstractController
{

    #[Route('/nombre_visiteur', name: 'app_plus_info_nb_visiteur')]
    public function getNombreVisiteur(VisitorIncrementInterface $visitorIncrement): Response
    {
        $visitors = $visitorIncrement->getCount();
        return $this->render('plus_info/nombre_visiteur.html.twig', [
            'nbVisiteur' => $visitors,
        ]);
    }


}
