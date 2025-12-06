<?php

namespace App\Infrastructure\Model;


class Parking
{
    public string $id;
    public string $type;

    public function __construct(
        string $id,
        string $type,
    ) {
        $this->id = $id;
        $this->type = $type;
    }
}
