<?php

namespace App\Infrastructure\ProviderImpl;

use App\Domain\ProviderInterface\ParkingProviderInterface;
use App\Infrastructure\Model\Parking;
use App\Infrastructure\Repository\ApiParkingRepository;

final class ApiParkingProvider implements ParkingProviderInterface
{
    public function __construct(
        private readonly ApiParkingRepository $httpClient
    ) {
    }

    /**
     * @return list<Parking>
     */
    public function findAll(): array
    {
        return $this->httpClient->findAll();
    }
}
