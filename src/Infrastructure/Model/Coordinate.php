<?php

namespace App\Infrastructure\Model;

use Symfony\Component\Serializer\Attribute\SerializedName;

/**
 * Model pour gérer les coordonnées latitude et longitude
 */
class Coordinate
{
    #[SerializedName('type')]
    public string $type;
    #[SerializedName('value')]
    public ?string $value;
}
