<?php

namespace App\Repositories;

use App\Models\MapPoints;


class PointRepository
{
    public function addNewPoint(array $data): bool
    {
        $result = MapPoints::create($data);

        if($result)
        {
            return true;
        }

        return false;
    }

    public function getASCNumber(string $id): ?int
    {
        $point = MapPoints::where('ulid', $id)->first();

        if($point)
        {
            return $point->isASC;
        }
        return null;
    }

    public function setIsASC(string $ulid, string $isASC): void
    {
        MapPoints::where('ulid', $ulid)->update(['isASC' => $isASC]);
    }
}
