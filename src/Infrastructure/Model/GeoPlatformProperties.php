<?php

namespace App\Infrastructure\Model;


use Symfony\Component\Serializer\Attribute\SerializedName;

class GeoPlatformProperties
{
    #[SerializedName('label')]
    public string $label;
}
