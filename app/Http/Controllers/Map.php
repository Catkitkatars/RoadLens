<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoadLens;

class Map extends Controller
{

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
        return view('add', [
            'latitude' => $latitude,
            'longitude' => $longitude,
            'zoom' => $zoom
        ]);
    }

    public function showPost(Request $request) {

        
        $roadLens = new RoadLens();

        $roadLens->addCamera($request);
        return redirect('/');
    }

    public function showEditPage($uuid) {
        // Получаем uuid 
        // Ищем в базе элемент с таким uuid 
        // Получаем
        // Вызваем view куда передаем данные о элементе и добавляем их в поля ввода
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
