<?php

namespace App\Domain\ServiceImpl;

use App\Domain\Model\AdresseProcheModel;
use App\Domain\ProviderInterface\AdresseProcheProviderInterface;
use App\Domain\ServiceInterface\GetAdresseProcheInterface;

final readonly class GetAdresseProche implements GetAdresseProcheInterface
{
    public function __construct(private AdresseProcheProviderInterface $provider)
    {
    }

    /**
     * @param float $longitude
     * @param float $latitude
     * @return AdresseProcheModel
     */
    public function findOne(float $longitude, float $latitude) : AdresseProcheModel{
        return $this->provider->findOne($longitude,$latitude);
    }

}
