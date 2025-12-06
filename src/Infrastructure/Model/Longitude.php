<?php

namespace App\Infrastructure\Model;

class Longitude
{
    public string $type;
    public ?string $value;

    public function __construct(
        string $type,
        ?string $value,
    ) {
        $this->type = $type;
        $this->value = $value;
    }
}
