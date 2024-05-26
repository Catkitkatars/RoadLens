<?php

namespace App\Repositories;

use App\Models\MapPoints;
use App\Models\AverageSpeedControl;


class AverageSpeedRepository
{
    public function getSection(int $sectionId): array
    {
        $result = AverageSpeedControl::where('id', $sectionId)->first();

        return json_decode($result->data, true);
    }

    public function createSection(array $sectionData): ?int
    {
        $arrayToJson = json_encode($sectionData);

        $result = AverageSpeedControl::create([
            'data' => $arrayToJson,
        ]);

        if($result) {
            return $result->id;
        }
        return null;
    }

    public function updateSection(int $sectionId, array $section): bool
    {
        $arrayToJson = json_encode($section);
        $result = AverageSpeedControl::where('id', $sectionId)->update(['data' => $arrayToJson]);

        if($result) {
            return true;
        }
        return false;
    }

}
