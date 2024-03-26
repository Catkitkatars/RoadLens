<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class AverageSpeedControl extends Model
{
    use HasFactory;

    protected $fillable = ['data'];

    public static function addSection($uuid, $section) {
        $validator = Validator::make($section, [
            'uuid' => 'required|uuid',
            'speed' => 'required|numeric|min:10',
        ]);
        
        if ($validator->fails()) {
            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
        }
        $validatedData = $validator->validated();

        $resultСurrentCamera = AverageSpeedControl::whereJsonContains('data', $uuid)->first();
        
        $resultNextCamera = AverageSpeedControl::whereJsonContains('data', $validatedData['uuid'])->first();

        if(!$resultСurrentCamera && !$resultNextCamera) 
        {
            $data = [
                $uuid => $validatedData['speed'],
                $validatedData['uuid'] => $validatedData['speed']
            ];
            $jsonData = json_encode($data);

            $result = AverageSpeedControl::create([
                'data' => $jsonData
            ]);
            return $result->id;
        }
        else 
        {
            return 'NIHERA';
        }
        // Проверяем есть ли вообще секции с участием этой камеры
        // Если нет - добавляем новую секцию 
    }
}
