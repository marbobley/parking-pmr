<?php

namespace App\Domain\ProviderInterface;

use App\Domain\Model\ParkingModel;

/**
 * Port primaire (interface) pour accéder aux parkings.
 */
interface ParkingProviderInterface
{
    /**
     * @return list<ParkingModel>
     */
    public function findAll(): array;
}
