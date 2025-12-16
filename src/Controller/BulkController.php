<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\ProviderInterface\AdresseProcheOriginProviderInterface;
use App\Domain\ServiceInterface\BulkLoadAdresseProcheInterface;
use App\Domain\ServiceInterface\GetAllParkingsInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BulkController extends AbstractController
{
    #[Route('/bulk/load', name: 'app_bulk_load', methods: ['GET'])]
    public function bulkLoad(BulkLoadAdresseProcheInterface       $bulkLoader,
                             GetAllParkingsInterface              $getAllParkings,
                             AdresseProcheOriginProviderInterface $originProvider

    ): Response
    {
        $parkings = $getAllParkings->findAll();

        $coordinates = array();
        foreach ($parkings as $parking) {
            $coordinates[] = $parking->getCoordinate();
        }

        $adresseProche = $bulkLoader->findAll($coordinates);
        $originProvider->saveAll($adresseProche);

        return $this->render('bulk/bulk_load.html.twig', [
            'adresseProche' => $adresseProche,
        ]);
    }

    #[Route('/bulk/show', name: 'app_bulk_show', methods: ['GET'])]
    public function bulkShow(
        AdresseProcheOriginProviderInterface $originProvider

    ): Response
    {

        $alls = $originProvider->findAll();

        return $this->render('bulk/bulk_show.html.twig', [
            'adresseProches' => $alls,
        ]);
    }

    #[Route('/bulk/delete', name: 'app_bulk_delete', methods: ['GET'])]
    public function bulkDelete(
        AdresseProcheOriginProviderInterface $originProvider

    ): Response
    {

        $originProvider->deleteAll();

        return $this->render('bulk/bulk_delete.html.twig');
    }
}
