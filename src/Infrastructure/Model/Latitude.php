<?php

namespace App\Infrastructure\Model;

class Latitude
{
    public string $type;
    public ?string $value;

    public function __construct(
        string $type,
        ?string $value
    ) {
        $this->type = $type;
        $this->value = $value;
    }

}
