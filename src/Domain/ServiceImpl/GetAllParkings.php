<?php

namespace App\Domain\ServiceImpl;

use App\Domain\Model\ParkingModel;
use App\Domain\ProviderInterface\ParkingProviderInterface;
use App\Domain\ServiceInterface\GetAllParkingsInterface;

/**
 * Cas d'usage : récupérer toutes les places de parking depuis le port.
 */
final readonly class GetAllParkings implements GetAllParkingsInterface
{
    public function __construct(private ParkingProviderInterface $provider)
    {
    }

    /**
     * @return list<ParkingModel>
     */
    public function findAll() : array{
        return $this->provider->findAll();
    }

}
