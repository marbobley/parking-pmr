<?php

namespace App\Infrastructure\Model;

class Metadata
{
    public ?TimeInstant $timeInstant;

    public function __construct(?TimeInstant $timeInstant)
    {
        $this->timeInstant = $timeInstant;
    }
}
