<?php

namespace App\Infrastructure\ProviderImpl;

use App\Domain\Model\ParkingModel;
use App\Domain\ProviderInterface\ParkingProviderInterface;
use App\Infrastructure\Mapper\ParkingMapper;
use App\Infrastructure\Model\Parking;
use App\Infrastructure\Repository\ApiParkingRepository;

final class ApiParkingProvider implements ParkingProviderInterface
{
    public function __construct(
        private readonly ApiParkingRepository $httpClient,
        private readonly ParkingMapper $mapper
    ) {
    }

    /**
     * @return list<ParkingModel>
     */
    public function findAll(): array
    {
        $results = $this->httpClient->findAll();

        dd($results);

        //return array_map(fn($result) => $this->mapper->mapperEntityToModel($result), $results);
    }
}
