<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class RoadLens extends Model
{
    use HasFactory;


    protected $table = 'russia';
    protected $fillable = [
        'uuid',
        'country', 
        'region',
        'type',
        'model',
        'camera_latitude',
        'camera_longitude',
        'target_latitude',
        'target_longitude',
        'direction',
        'distance',
        'angle',
        'car_speed',
        'truck_speed',
        'source',
        'flags',
    ];

    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }

    public function addCamera($request) 
    {

        $validator = Validator::make($request->all(), [
            'country' => 'required|numeric|between:1,14',
            'region' => 'required|numeric|between:1,85',
            'type' => 'required|numeric|between:1,7',
            'model' => 'required|numeric|between:1,7',
            'camera_latitude' => 'required|numeric|between:-90,90',
            'camera_longitude' => 'required|numeric|between:-180,180',
            'target_latitude' => 'required|numeric|between:-90,90',
            'target_longitude' => 'required|numeric|between:-180,180',
            'direction' => 'required|numeric|between:0,359',
            'distance' => 'required|numeric',
            'angle' => 'required|numeric',
            'car_speed' => 'required|numeric|between:0,250',
            'truck_speed' => 'required|numeric|between:0,250',
            'source' => 'required|string',
            'flags' => 'nullable|array',
            'flags.*' => 'nullable|numeric|in:1,2,3,4,5,6,7,8,9',
        ]);

        if ($validator->fails()) {
            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
        }

        $validatedData = $validator->validated();

        $validatedData['uuid'] = RoadLens::newUniqueId();

        if(isset($validatedData['flags'])) {
            $associativeArrayToString = implode(',', array_values($validatedData['flags']));
            $validatedData['flags'] = $associativeArrayToString;


            return RoadLens::create($validatedData);
            // return DB::table($this->table)->insert([
            //     'uuid' => $uuid,
            //     'country' => $validatedData['country'],
            //     'region' => $validatedData['region'],
            //     'type' => $validatedData['type'],
            //     'model' => $validatedData['model'],
            //     'camera_latitude' => $validatedData['camera_latitude'],
            //     'camera_longitude' => $validatedData['camera_longitude'],
            //     'target_latitude' => $validatedData['target_latitude'],
            //     'target_longitude' => $validatedData['target_longitude'],
            //     'direction' => $validatedData['direction'],
            //     'distance' => $validatedData['distance'],
            //     'angle' => $validatedData['angle'],
            //     'car_speed' => $validatedData['car_speed'],
            //     'truck_speed' => $validatedData['truck_speed'],
            //     'source' => $validatedData['source'],
            //     'flags' => $associativeArrayToString,
            // ]);
        }


        return RoadLens::create($validatedData);

        //========================
        // Что делаем если флаги вообще не переданы
        //========================

        // return DB::table($this->table)->insert([
        //     'uuid' => $uuid,
        //     'country' => $validatedData['country'],
        //     'region' => $validatedData['region'],
        //     'type' => $validatedData['type'],
        //     'model' => $validatedData['model'],
        //     'camera_latitude' => $validatedData['camera_latitude'],
        //     'camera_longitude' => $validatedData['camera_longitude'],
        //     'target_latitude' => $validatedData['target_latitude'],
        //     'target_longitude' => $validatedData['target_longitude'],
        //     'direction' => $validatedData['direction'],
        //     'distance' => $validatedData['distance'],
        //     'angle' => $validatedData['angle'],
        //     'car_speed' => $validatedData['car_speed'],
        //     'truck_speed' => $validatedData['truck_speed'],
        //     'source' => $validatedData['source'],
        // ]);
    }
}
