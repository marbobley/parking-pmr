<?php

namespace App\Domain\ProviderInterface;

use App\Domain\Model\AdresseProcheModel;
use App\Domain\Model\CoordinateModel;

/**
 * Port primaire (interface) pour accéder aux parkings.
 */
interface AdresseProcheProviderInterface
{
    /**
     * @param float $longitude
     * @param float $latitude
     * @return AdresseProcheModel
     */
    public function findOne(float $longitude, float $latitude): AdresseProcheModel;

    /**
     * @param list<CoordinateModel> $coordinates
     * @return list<AdresseProcheModel>
     */
    public function findAll(array $coordinates): array;
}
