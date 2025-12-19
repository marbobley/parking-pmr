<?php

namespace App\Domain\ProviderInterface;

use App\Domain\Model\AdresseProcheModel;

/**
 * Port primaire (interface) pour accéder aux parkings.
 */
interface AdresseProcheOriginProviderInterface
{

    /**
     * @param list<AdresseProcheModel> $adresseProches
     * @return void
     */
    public function saveAll(array $adresseProches): void;

    /**
     * @return list<AdresseProcheModel>
     */
    public function findAll(): array;

    /**
     * Delete all adresses proches
     * @return void
     */
    public function deleteAll(): void;
}
