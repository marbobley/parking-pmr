<?php

namespace App\Domain\ServiceImpl;

use App\Domain\ProviderInterface\AdresseProcheOriginProviderInterface;
use App\Domain\ProviderInterface\AdresseProcheProviderInterface;
use App\Domain\ServiceInterface\BulkLoadAdresseProcheInterface;
use App\Domain\ServiceInterface\GetAllParkingsInterface;

readonly class BulkLoadAdresseProche implements BulkLoadAdresseProcheInterface
{
    public function __construct(
        private AdresseProcheProviderInterface       $provider,
        private GetAllParkingsInterface              $getAllParkings,
        private AdresseProcheOriginProviderInterface $originProvider)
    {
    }

    public function loadAndSave(): int
    {
        $parkings = $this->getAllParkings->findAll();

        $coordinates = array();
        foreach ($parkings as $parking) {
            $coordinates[] = $parking->getCoordinate();
        }

        $adresseProche = $this->provider->findAll($coordinates);
        $this->originProvider->saveAll($adresseProche);

        return count($adresseProche);
    }


    public function findAll(array $coordinates): array
    {
        return $this->provider->findAll($coordinates);
    }
}
