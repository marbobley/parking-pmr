<?php

namespace App\Infrastructure\Model;

use Symfony\Component\Serializer\Attribute\SerializedName;

class SlotStatus
{
    #[SerializedName('type')]
    public string $type;
    #[SerializedName('value')]
    public ?string $value;
}
