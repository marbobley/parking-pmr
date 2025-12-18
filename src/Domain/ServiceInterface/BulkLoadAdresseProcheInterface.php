<?php

namespace App\Domain\ServiceInterface;

use App\Domain\Model\AdresseProcheModel;
use App\Domain\Model\CoordinateModel;

interface BulkLoadAdresseProcheInterface
{

    /**
     * @param list<CoordinateModel> $coordinates
     * @return list<AdresseProcheModel>
     */
    public function findAll(array $coordinates): array;

    /**
     * Load address from an external source and save them in a database
     * @return int quantity of saved address
     */
    public function loadAndSave(): int;
}
