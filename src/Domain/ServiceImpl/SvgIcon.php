<?php

namespace App\Domain\ServiceImpl;

use Symfony\UX\Map\Icon\Icon;

readonly class SvgIcon
{
    const RED = "#FF0000";
    const GREEN = "#06402B";
    const BLUE = "#0000FF";

    const SVG_PARKING_ICON = '<svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 96 96"><g fill="none" stroke-linejoin="round" stroke-width="4"><path fill="%s" stroke="#000" d="M48 88s32 -24 32 -50c0 -16.568 -14.326 -30 -32 -30S16 21.432 16 38c0 26 32 50 32 50Z" stroke-width="2"/><path stroke="#FFF" stroke-linecap="round" d="M42 28v32" stroke-width="2"/><path fill="%s" stroke="#FFF" d="M42 28h12a8 8 0 0 1 0 16h-12z" stroke-width="2"/></g></svg>';

    public function getParkingIcon(string $color): Icon
    {
        return Icon::svg(sprintf(self::SVG_PARKING_ICON, $color, $color));
    }
}
