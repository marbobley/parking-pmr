<?php

namespace App\Domain\ServiceImpl;

use App\Domain\Model\Parking;
use App\Domain\ProviderInterface\ParkingRepositoryInterface;
use App\Domain\ServiceInterface\GetAllParkingsInterface;

/**
 * Cas d'usage: récupérer toutes les places de parking depuis le port.
 */
final class GetAllParkings implements GetAllParkingsInterface
{
    public function __construct(private readonly ParkingRepositoryInterface $repository)
    {
    }

    /**
     * @return list<Parking>
     */
    public function findAll() : array{
        return $this->repository->findAll();
    }

}
