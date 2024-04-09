<?php

namespace App\Http\Controllers;

use App\Http\Requests\CameraFormAddRequest;
use App\Http\Requests\CameraFormUpdateRequest;
use App\Services\Camera;
use Illuminate\Http\Request;
use App\Models\RoadLens;
use App\Models\AverageSpeedControl;

class Map extends Controller
{

    private array $flagsDescriprion = [
        1 => 'Подтвержден',
        2 => 'В спину',
        3 => 'Разметка',
        4 => 'Пешеходный',
        5 => 'Обочина',
        6 => 'Автобусная',
        7 => 'Контроль остановки',
        8 => 'Грузовой контроль',
        9 => 'Дополнительный',
        10 => 'Контроль средней скорости',
    ];

    public function __construct(

    ) {}

    public function showMap($latitude, $longitude, $zoom) {
        return view('home', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'zoom' => $zoom
        ]);
    }

    public function showAddPage($latitude, $longitude, $zoom) {
        return view('edit', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'zoom' => $zoom,
            'flagDescriptions' => $this->flagsDescriprion,
        ]);
    }

    public function add(CameraFormAddRequest $request) {
        $result = (new Camera())->addCamera($request);

        return redirect("/map/" . $result['lat'] . '/' . $result['lng'] . '/16' );
    }

    public function update(string $ulid, CameraFormUpdateRequest $request){
        $result = (new Camera())->updateCamera($ulid, $request);

        return redirect("/map/" . $result['lat'] . '/' . $result['lng'] . '/16' );
    }

    public function delete(string $ulid){
        $result = (new Camera())->deleteCamera($ulid);

        return redirect("/map/" . $result['lat'] . '/' . $result['lng'] . '/16' );
    }

    public function showEditPage(string $ulid) {

        $camera = (new RoadLens)->where('ulid', $ulid)->first();
        $nextCameraId = null;
        $previousCameraId = null;
        $averageSpeed = null;
        if($camera->isASC) {
            $section = (new AverageSpeedControl())->where('id', $camera->isASC)->first();
            $decodeSection = json_decode($section->data);

            $counter = 0;
            foreach($decodeSection as $cameraInSection) {
                if($cameraInSection->ulid === $camera->ulid)
                {
                    $nextCameraId = $decodeSection[$counter + 1]->ulid ?? null;
                    $previousCameraId = $decodeSection[$counter - 1]->ulid ?? null;
                    $averageSpeed = $cameraInSection->speed;

                }
                $counter++;
            }
            return view('edit', [
                'ulid' => $camera->ulid,
                'country' => $camera->country,
                'region' => $camera->region,
                'type' => $camera->type,
                'model' => $camera->model,
                'latitude' => $camera->camera_latitude,
                'longitude' => $camera->camera_longitude,
                'target_latitude' => $camera->target_latitude,
                'target_longitude' => $camera->target_longitude,
                'direction' => $camera->direction,
                'distance' => $camera->distance,
                'angle' => $camera->angle,
                'car_speed' => $camera->car_speed,
                'truck_speed' => $camera->truck_speed,
                'user' => $camera->user,
                'isASC' => $camera->isASC,
                'ASC' => [
                    'previous' => $previousCameraId,
                    'speed' => $averageSpeed,
                    'next' => $nextCameraId,
                ],
                'isDeleted' => $camera->isDeleted,
                'source' => $camera->source,
                'flags' => explode(",", $camera->flags),
                'flagDescriptions' => $this->flagsDescriprion,
            ]);
        }

        return view('edit', [
            'ulid' => $camera->ulid,
            'country' => $camera->country,
            'region' => $camera->region,
            'type' => $camera->type,
            'model' => $camera->model,
            'latitude' => $camera->camera_latitude,
            'longitude' => $camera->camera_longitude,
            'target_latitude' => $camera->target_latitude,
            'target_longitude' => $camera->target_longitude,
            'direction' => $camera->direction,
            'distance' => $camera->distance,
            'angle' => $camera->angle,
            'car_speed' => $camera->car_speed,
            'truck_speed' => $camera->truck_speed,
            'user' => $camera->user,
            'isASC' => $camera->isASC,
            'isDeleted' => $camera->isDeleted,
            'source' => $camera->source,
            'flags' => explode(",", $camera->flags),
            'flagDescriptions' => $this->flagsDescriprion,
        ]);
    }
    public function getCamerasInBounds(Request $request)
    {
        return (new Camera())->getCamerasInBounds($request);
    }
}
