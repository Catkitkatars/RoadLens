<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoadLens;

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

    public function showTemplate() {
        return $this->showMap(52.433690, 6.834420, 170);
    }

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
            'zoom' => $zoom
        ]);
    }

    public function add(Request $request) {
        $result = (new RoadLens())->addCamera($request);

        return redirect("/map/" . $result['lat'] . '/' . $result['lng'] . '/16' );
    }

    public function update($uuid, Request $request){
        $result = (new RoadLens)->updateCamera($uuid, $request);

        return redirect("/map/" . $result['lat'] . '/' . $result['lng'] . '/16' );
    }

    public function delete($uuid, Request $request){
        $result = (new RoadLens())->deleteCamera($uuid);

        return redirect("/map/" . $result['lat'] . '/' . $result['lng'] . '/16' );
    }


    public function showEditPage($uuid) {

        $camera = (new RoadLens)->where('uuid', $uuid)->first();
        return view('edit', [
            'uuid' => $camera->uuid,
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

    public function getCamerasInBounds(Request $request){

        $roadlens = new RoadLens();

        $camerasInBounds = $roadlens->getCameras($request);

        $cameras = [];

        foreach ($camerasInBounds as $point) {
            $cameraObject = [
                'type' => 'Feature',
                'properties' => [
                    'uuid' => $point['uuid'],
                    'type' => $point['type'],
                    'model' => $point['model'],
                    'angle' => $point['angle'],
                    'car_speed' => $point['car_speed'],
                    'truck_speed' => $point['truck_speed'],
                    'user' => $point['user'],
                    'isDeleted' => $point['isDeleted'],
                    'isASC' => $point['isASC'],
                    'dateCreate' => date('d.m.Y', strtotime($point['created_at'])),
                    'lastUpdate' => date('d.m.Y', strtotime($point['updated_at'])),
                ],
                'geometry' => [
                    'type' => 'GeometryCollection',
                    'geometries' => [
                        [
                            'type' => 'Point',
                            'coordinates' => [$point['camera_longitude'], $point['camera_latitude']]
                        ],
                        [
                            'type' => 'Point',
                            'coordinates' => [$point['target_longitude'], $point['target_latitude']]
                        ]
                    ]
                ]
            ];

            $cameras[] = $cameraObject;
            }

        return response()->json($cameras);
    }
}
