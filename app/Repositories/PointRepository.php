<?php

namespace App\Repositories;

use App\Models\MapPoints;


class PointRepository
{
    public function addPoint(array $point): bool
    {
        $result = MapPoints::create($point);

        return (bool) $result;
    }

    public function getPoint(string $ulid): array
    {
        return MapPoints::where('ulid', $ulid)->first();
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


        return (bool) $result;
    }

    public function getSectionId(string $ulid): ?int
    {
        $point = MapPoints::where('ulid', $ulid)->first();

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

    public function updateASCs(array $ulids, int $isASC): bool
    {
        $result = MapPoints::whereIn('ulid', $ulids)->update(['isASC' => $isASC]);

        return (bool) $result;
    }
}
