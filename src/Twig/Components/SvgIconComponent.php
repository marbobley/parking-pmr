<?php

namespace App\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent]
class SvgIconComponent
{
    public string $color = '#FF0000';
    public string $svgIcon;
    public string $message;
}
