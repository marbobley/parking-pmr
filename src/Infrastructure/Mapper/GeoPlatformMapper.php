<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\AdresseProcheModel;
use App\Infrastructure\Model\GeoPlatformAdress;
class GeoPlatformMapper
{
    public function mapperEntityToModel(GeoPlatformAdress $object): AdresseProcheModel
    {
        return new AdresseProcheModel($object->type);
    }

}
