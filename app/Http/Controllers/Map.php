<?php

namespace App\Http\Controllers;

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
            'zoom' => $zoom,
            'flagDescriptions' => $this->flagsDescriprion,
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
        $camerasInBounds = (new RoadLens())->getCameras($request);

        $cameras = [];

        $sectionsIds = [];
        $commonCameras = [];

        foreach($camerasInBounds as $point) {
            if($point['isASC'] != '0') {
                if(!in_array($point['isASC'], $sectionsIds)) {
                    $sectionsIds[] = $point['isASC'];
                }
            }
            else 
            {
                $commonCameras[] = $point;
            }
        }


        foreach($commonCameras as $camera) {
            $cameraObject = [
                'type' => 'Feature',
                'properties' => [
                    'uuid' => $camera['uuid'],
                    'type' => intval($camera['type']),
                    'model' => intval($camera['model']),
                    'angle' => intval($camera['angle']),
                    'car_speed' => intval($camera['car_speed']),
                    'truck_speed' => intval($camera['truck_speed']),
                    'user' => $camera['user'],
                    'isDeleted' => intval($camera['isDeleted']),
                    'isASC' => intval($camera['isASC']),
                    'dateCreate' => date('d.m.Y', strtotime($camera['created_at'])),
                    'lastUpdate' => date('d.m.Y', strtotime($camera['updated_at'])),
                ],
                'geometry' => [
                    'type' => 'GeometryCollection',
                    'geometries' => [
                        [
                            'type' => 'Point',
                            'coordinates' => [floatval($camera['camera_longitude']), floatval($camera['camera_latitude'])]
                        ],
                        [
                            'type' => 'Point',
                            'coordinates' => [floatval($camera['target_longitude']), floatval($camera['target_latitude'])]
                        ]
                    ]
                ]
            ];
            $cameras[] = $cameraObject;
        }


        $sections = (new AverageSpeedControl())->whereIn('id', $sectionsIds)->select('data')->get();

        $sectionsCameras = [];

        foreach($sections as $section) {
            $groupSectionCameras = [];
            $handledSection = json_decode($section['data'], true);
            $cameraIds = array_keys($handledSection);

            foreach($cameraIds as $camerasId) {
                $camera = (new RoadLens())->where('uuid', $camerasId)->first();
                
                $uuidPrevious = $cameraIds[array_search($camerasId, $cameraIds) - 1] ?? null;
                $uuidNext = $cameraIds[array_search($camerasId, $cameraIds) + 1] ?? null;
                
                $cameraObject = [
                    'type' => 'Feature',
                    'properties' => [
                        'uuid' => $camera['uuid'],
                        'type' => intval($camera['type']),
                        'model' => intval($camera['model']),
                        'angle' => intval($camera['angle']),
                        'car_speed' => intval($camera['car_speed']),
                        'truck_speed' => intval($camera['truck_speed']),
                        'user' => $camera['user'],
                        'isDeleted' => intval($camera['isDeleted']),
                        'isASC' => intval($camera['isASC']),
                        'ASC' => [
                            'previous' => $uuidPrevious, 
                            'speed' => $handledSection[$camerasId],
                            'next' => $uuidNext,
                        ],
                        'dateCreate' => date('d.m.Y', strtotime($camera['created_at'])),
                        'lastUpdate' => date('d.m.Y', strtotime($camera['updated_at'])),
                    ],
                    'geometry' => [
                        'type' => 'GeometryCollection',
                        'geometries' => [
                            [
                                'type' => 'Point',
                                'coordinates' => [floatval($camera['camera_longitude']), floatval($camera['camera_latitude'])]
                            ],
                            [
                                'type' => 'Point',
                                'coordinates' => [floatval($camera['target_longitude']), floatval($camera['target_latitude'])]
                            ]
                        ]
                    ]
                ];
                $groupSectionCameras[] = $cameraObject;
            }
            $sectionsCameras[] = $groupSectionCameras;
        }

        $cameras[] = $sectionsCameras;
        return response()->json($cameras);
    }
}
