<?php

namespace App\Domain\ProviderInterface;

use App\Domain\Model\AdresseProcheModel;

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
}
