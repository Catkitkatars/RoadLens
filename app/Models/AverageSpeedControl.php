<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Models\RoadLens;

class AverageSpeedControl extends Model
{
    use HasFactory;

    protected $fillable = ['data'];

    public static function addSection($ulid, $section) {
        $validator = Validator::make($section, [
            'ulid' => 'required|ulid',
            'speed' => 'required|numeric|min:10',
        ]);
        
        if ($validator->fails()) {
            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
        }
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
            $result = AverageSpeedControl::create([
                'data' => $jsonSection
            ]);
            return [$validatedData['ulid'], $result->id];
        }
        else 
        {

            dd($IsThereASection);
            return 'NIHERA';
        }
        // Проверяем есть ли вообще секции с участием этой камеры
        // Если нет - добавляем новую секцию 
    }
}
