<?php

namespace App\Domain\ServiceInterface;

interface VisitorIncrementInterface
{
    function increment() : void;
    function getCount() : int;
}
