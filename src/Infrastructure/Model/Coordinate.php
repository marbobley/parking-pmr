<?php

namespace App\Infrastructure\Model;

use Symfony\Component\Serializer\Attribute\SerializedName;

class Coordinate
{
    #[SerializedName('type')]
    public string $type;
    #[SerializedName('value')]
    public ?string $value;
}
