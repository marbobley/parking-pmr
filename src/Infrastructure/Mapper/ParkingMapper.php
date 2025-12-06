<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\ParkingModel;
use App\Infrastructure\Model\Parking;

class ParkingMapper
{
    public function mapperEntityToModel(Parking $object): ParkingModel
    {
        return new ParkingModel($object->id, floatval($object->latitude->value), floatval($object->longitude->value));
    }
}
