<?php

namespace App\Repository;

use App\Models\MapPoints;


class PointRepository
{
    public function __construct()
    {

    }

    public function addNewPoint($data): bool
    {
        $result = MapPoints::create($data);


        if($result)
        {
            return true;
        }

        return false;
    }
}
