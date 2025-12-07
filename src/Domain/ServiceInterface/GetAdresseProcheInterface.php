<?php

namespace App\Domain\ServiceInterface;

use App\Domain\Model\AdresseProcheModel;

interface GetAdresseProcheInterface
{
    function findOne(float $longitude, float $latitude) : AdresseProcheModel;
}
