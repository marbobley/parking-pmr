<?php

namespace App\Domain\ServiceImpl;

use App\Domain\ProviderInterface\AdresseProcheProviderInterface;
use App\Domain\ServiceInterface\BulkLoadAdresseProcheInterface;

readonly class BulkLoadAdresseProche implements BulkLoadAdresseProcheInterface
{
    public function __construct(private AdresseProcheProviderInterface $provider)
    {
    }

    public function findAll(array $coordinates): array
    {
        return $this->provider->findAll($coordinates);
    }
}
