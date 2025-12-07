<?php

namespace App\Domain\Model;

readonly class AdresseProcheModel
{
    public function __construct(
        private string $label
    ) {
    }

    public function getLabel(): string
    {
        return $this->label;
    }


}
