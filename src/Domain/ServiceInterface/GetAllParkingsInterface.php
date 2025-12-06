<?php

namespace App\Domain\ServiceInterface;

interface GetAllParkingsInterface
{
    function findAll() : array;
}
