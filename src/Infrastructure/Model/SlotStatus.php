<?php

namespace App\Infrastructure\Model;

class SlotStatus
{
    public string $type;
    public ?string $value;
    public Metadata $metadata;

    public function __construct(
        string $type,
        ?string $value,
        Metadata $metadata
    ) {
        $this->type = $type;
        $this->value = $value;
        $this->metadata = $metadata;
    }
}
