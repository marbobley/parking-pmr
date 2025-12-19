<?php

namespace App\Domain\ProviderInterface;

use App\Domain\Model\ParkingModel;

/**
 * Port primaire (interface) pour accéder aux parkings.
 */
interface ParkingProviderInterface
{
    /**
     * Return all parking without any filters
     * @return list<ParkingModel>
     */
    public function findAll(): array;
}
