<?php

namespace App\Domain\ProviderInterface;

use App\Domain\Model\Parking;

/**
 * Port primaire (interface) pour accéder aux parkings.
 */
interface ParkingRepositoryInterface
{
    /**
     * @return list<Parking>
     */
    public function findAll(): array;
}
