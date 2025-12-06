<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\ParkingModel;
use App\Infrastructure\Model\Parking;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;

class ParkingMapper
{
    public function __construct(private ObjectMapperInterface $objectMapper)
    {
    }

    public function mapperModelToEntity(ParkingModel $object): Parking
    {
        return $this->objectMapper->map($object, Parking::class);
    }

    public function mapperEntityToModel(Parking $object): ParkingModel
    {
        return $this->objectMapper->map($object, ParkingModel::class);
    }
}
