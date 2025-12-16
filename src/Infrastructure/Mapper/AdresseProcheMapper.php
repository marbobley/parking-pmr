<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\AdresseProcheModel;
use App\Domain\Model\CoordinateModel;
use App\Entity\AdresseProcheOrigin;

class AdresseProcheMapper
{
    public function mapperModelToEntity(AdresseProcheModel $object): AdresseProcheOrigin
    {
        $entity = new AdresseProcheOrigin();
        $entity->setLatitude($object->getCoordinate()->getLatitude());
        $entity->setLongitude($object->getCoordinate()->getLongitude());
        $entity->setLabel($object->getLabel());

        return $entity;
    }

    public function mapperEntityToModel(AdresseProcheOrigin $object): AdresseProcheModel
    {
        return new AdresseProcheModel($object->getLabel(), new CoordinateModel($object->getLatitude(), $object->getLongitude()));

    }

}
