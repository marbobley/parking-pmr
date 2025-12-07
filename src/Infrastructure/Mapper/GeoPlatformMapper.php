<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\AdresseProcheModel;
use App\Infrastructure\Model\GeoPlatformAdress;
class GeoPlatformMapper
{
    public function mapperEntityToModel(GeoPlatformAdress $object): AdresseProcheModel
    {
        if(!isset($object->features[0]->properties->label)) {
            return new AdresseProcheModel('Adresse non trouvée');
        }

        return new AdresseProcheModel($object->features[0]->properties->label);
    }

}
