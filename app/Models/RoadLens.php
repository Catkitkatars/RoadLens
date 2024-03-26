<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Models\AverageSpeedControl;

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
        'isASC',
        'flags',
    ];

    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }
    public function addCamera($request) 
    {
        $validator = Validator::make($request->all(), [
            'country' => 'required|numeric|between:1,15',
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
            'isASC' => 'string|numeric|in:0,1',
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
        $validatedData['user'] = 'admin';
        $validatedData['isDeleted'] = '0';
        $validatedData['isASC'] = '0';
        
        if(isset($validatedData['flags'])) {
            $associativeArrayToString = implode(',', array_values($validatedData['flags']));
            $validatedData['flags'] = $associativeArrayToString;
            RoadLens::create($validatedData);
            return [
                'lat' => $validatedData['camera_latitude'],
                'lng' => $validatedData['camera_longitude']
            ];
        }

        RoadLens::create($validatedData);
        return [
            'lat' => $validatedData['camera_latitude'],
            'lng' => $validatedData['camera_longitude']
        ];
    }
    public function updateCamera($uuid, $request) 
    {

        $validator = Validator::make($request->all(), [
            'country' => 'required|numeric|between:1,15',
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
            'isDeleted' => 'required|in:0,1',
            'ASC' => 'nullable|array',
            'ASC.uuid' => 'uuid',
            'ASC.speed' => 'numeric|min:10',
            'isASC' => 'numeric',
            'flags' => 'nullable|array',
            'flags.*' => 'nullable|numeric|in:1,2,3,4,5,6,7,8,9,10',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            dd($errors->first());
        }
        $validatedData = $validator->validated();

        

        $idSection = AverageSpeedControl::addSection($uuid, $validatedData['ASC']);

        $validatedData['isASC'] = $idSection;
        
        dd($validatedData);

        if(isset($validatedData['flags'])) {
            $arrayToString = implode(',', array_values($validatedData['flags']));
            $validatedData['flags'] = $arrayToString;
        }
        if(isset($validatedData['ASC'])) {
            dd($validatedData['ASC']);
        }

        RoadLens::where('uuid', $uuid)->update([
            'uuid' => $uuid,
            'country' => $validatedData['country'],
            'region' => $validatedData['region'],
            'type' => $validatedData['type'],
            'model' => $validatedData['model'],
            'camera_latitude' => $validatedData['camera_latitude'],
            'camera_longitude' => $validatedData['camera_longitude'],
            'target_latitude' => $validatedData['target_latitude'],
            'target_longitude' => $validatedData['target_longitude'],
            'direction' => $validatedData['direction'],
            'distance' => $validatedData['distance'],
            'angle' => $validatedData['angle'],
            'car_speed' => $validatedData['car_speed'],
            'truck_speed' => $validatedData['truck_speed'],
            'isDeleted' => 0,
            'source' => $validatedData['source'],
            'isASC' => $validatedData['isASC'],
            'flags' => $validatedData['flags'],
        ]);

        return [
            'lat' => $validatedData['camera_latitude'],
            'lng' => $validatedData['camera_longitude']
        ];

    }
    public function deleteCamera($uuid) 
    {
        $cameraData = Roadlens::where('uuid', $uuid)->first();

        RoadLens::where('uuid', $uuid)->update([
            'target_latitude' => $cameraData->camera_latitude,
            'target_longitude' => $cameraData->camera_longitude,
            'isDeleted' => 1
        ]);
        return [
            'lat' => $cameraData->camera_latitude,
            'lng' => $cameraData->camera_longitude
        ];
    }
    public function getCameras($request) 
    {
        $northEastLat = $request->input('northEastLat');
        $northEastLng = $request->input('northEastLng');
        $southWestLat = $request->input('southWestLat');
        $southWestLng = $request->input('southWestLng');

        $cameras = RoadLens::whereBetween('camera_latitude', [$southWestLat, $northEastLat])
                            ->whereBetween('camera_longitude', [$southWestLng, $northEastLng])
                            ->get();

        return $cameras;
    }
}
