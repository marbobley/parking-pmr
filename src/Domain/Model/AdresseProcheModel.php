<?php

namespace App\Domain\Model;

class AdresseProcheModel
{
    public function __construct(
        private string          $label,
        private CoordinateModel $coordinate
    )
    {
    }


    public function getLabel(): string
    {
        return $this->label;
    }

    public function getCoordinate(): CoordinateModel
    {
        return $this->coordinate;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function setCoordinate(CoordinateModel $coordinate): void
    {
        $this->coordinate = $coordinate;
    }


}
