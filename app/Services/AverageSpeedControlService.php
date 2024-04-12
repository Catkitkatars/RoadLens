<?php

namespace App\Services;

use App\Models\RoadLens;
use Illuminate\Support\Facades\Validator;

class AverageSpeedControlService
{
    public static function addSection($ulid, $section) {
        $validator = Validator::make($section, [
            'ulid' => 'required|ulid',
            'speed' => 'required|numeric|min:10',
        ]);

        $validatedData = $validator->validated();

        $ulidPartOfSectionOrNot = RoadLens::whereIn('ulid', [$ulid, $validatedData['ulid']])
                                                ->where('isASC', '!=', 0)
                                                ->get();

        if($ulidPartOfSectionOrNot->isEmpty())
        {
            $section = [
                [
                    'ulid' => $ulid,
                    'speed' => $validatedData['speed'],
                ],
                [
                    'ulid' => $validatedData['ulid'],
                    'speed' => $validatedData['speed'],
                ]
            ];

            $jsonSection = json_encode($section);
            $result = \App\Models\AverageSpeedControl::create([
                'data' => $jsonSection
            ]);
            return [$validatedData['ulid'], $result->id];
        }

        foreach ($ulidPartOfSectionOrNot as $section) {
            dd($section->ulid);
        }

    }
}
