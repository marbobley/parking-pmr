<?php

namespace App\Domain\Model;

readonly class AdresseProcheModel
{
    public function __construct(
        private string $type
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

}
