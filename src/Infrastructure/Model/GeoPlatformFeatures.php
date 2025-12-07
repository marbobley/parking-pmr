<?php

namespace App\Infrastructure\Model;


use Symfony\Component\Serializer\Attribute\SerializedName;

class GeoPlatformFeatures
{
    #[SerializedName('properties')]
    public GeoPlatformProperties $properties;
}
