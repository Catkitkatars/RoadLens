<?php

namespace App\Repositories;

use App\Models\MapPoints;


class PointRepository
{
    public function addPoint(array $point): bool
    {
        $result = MapPoints::create($point);

        if($result)
        {
            return true;
        }

        return false;
    }

    public function updatePoint(array $point): bool
    {
        $result = MapPoints::where('ulid', $point['ulid'])->update([
            'country' => $point['country'],
            'region' => $point['region'],
            'type' => $point['type'],
            'model' => $point['model'],
            'lat' => $point['lat'],
            'lng' => $point['lng'],
            'direction' => $point['direction'],
            'distance' => $point['distance'],
            'angle' => $point['angle'],
            'carSpeed' => $point['carSpeed'],
            'truckSpeed' => $point['truckSpeed'],
            'status' => $point['status'],
            'isASC' => $point['isASC'],
            'flags' => $point['flags'],
        ]);

        if($result)
        {
            return true;
        }
        return false;
    }

    public function getSectionId(string $id): ?int
    {
        $point = MapPoints::where('ulid', $id)->first();

        if($point)
        {
            return $point->isASC;
        }
        return null;
    }

    public function setSectionId(string $ulid, string $isASC): void
    {
        MapPoints::where('ulid', $ulid)->update(['isASC' => $isASC]);
    }
}
