<?php

namespace App\Infrastructure\ProviderImpl;

use App\Domain\Model\ParkingModel;
use App\Domain\ProviderInterface\ParkingProviderInterface;
use App\Infrastructure\Mapper\ParkingMapper;
use App\Infrastructure\Repository\ApiParkingRepository;

final readonly class ApiParkingProvider implements ParkingProviderInterface
{
    public function __construct(
        private ApiParkingRepository $httpClient,
        private ParkingMapper        $mapper
    ) {
    }

    /**
     * @return list<ParkingModel>
     */
    public function findAll(): array
    {
        $results = $this->httpClient->findAll();
        return array_map(fn($result) => $this->mapper->mapperEntityToModel($result), $results);
    }
}
