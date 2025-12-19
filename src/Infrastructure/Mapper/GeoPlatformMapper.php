<?php

namespace App\Infrastructure\Mapper;

use App\Domain\Model\AdresseProcheModel;
use App\Domain\Model\CoordinateModel;
use App\Infrastructure\Model\GeoPlatformAdress;

class GeoPlatformMapper
{
    const DEFAULT_COORDONNEE = 0.0;
    const ADRESSE_NON_TROUVEE = 'Adresse non trouvée';

    public function mapperEntityToModel(GeoPlatformAdress $object): AdresseProcheModel
    {
        if (!isset($object->features[0]->properties->label)) {
            return new AdresseProcheModel(self::ADRESSE_NON_TROUVEE, new CoordinateModel(self::DEFAULT_COORDONNEE, self::DEFAULT_COORDONNEE));
        }

        return new AdresseProcheModel($object->features[0]->properties->label, new CoordinateModel(self::DEFAULT_COORDONNEE, self::DEFAULT_COORDONNEE));
    }

    public function mapperEntityToModelWithOrigin(GeoPlatformAdress $object, CoordinateModel $coordinateModel): AdresseProcheModel
    {
        if (!isset($object->features[0]->properties->label)) {
            return new AdresseProcheModel(self::ADRESSE_NON_TROUVEE, new CoordinateModel(self::DEFAULT_COORDONNEE, self::DEFAULT_COORDONNEE));
        }

        return new AdresseProcheModel($object->features[0]->properties->label, $coordinateModel);
    }

}
