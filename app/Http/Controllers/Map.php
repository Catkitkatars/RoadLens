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

    public function update($ulid, Request $request){
        $result = (new RoadLens)->updateCamera($ulid, $request);

        return redirect("/map/" . $result['lat'] . '/' . $result['lng'] . '/16' );
    }

    public function delete($ulid, Request $request){
        $result = (new RoadLens())->deleteCamera($ulid);

        return redirect("/map/" . $result['lat'] . '/' . $result['lng'] . '/16' );
    }

    public function showEditPage($ulid) {

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

    public function getCamerasInBounds(Request $request){
        $camerasInBounds = (new RoadLens())->getCameras($request);

        $cameras = [];

        $sectionsIds = [];
        $commonCameras = [];

        foreach($camerasInBounds as $point) {
            if($point['isASC'] != '0') {
                if (!isset($sectionsIds[$point['isASC']])) {
                    $sectionsIds[$point['isASC']] = $point['isASC'];
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
                    'ulid' => $camera['ulid'],
                    'type' => $camera['type'],
                    'model' => $camera['model'],
                    'angle' => $camera['angle'],
                    'car_speed' => $camera['car_speed'],
                    'truck_speed' => $camera['truck_speed'],
                    'user' => $camera['user'],
                    'isDeleted' => $camera['isDeleted'],
                    'isASC' => $camera['isASC'],
                    'dateCreate' => date('d.m.Y H:i', strtotime($camera['created_at'])),
                    'lastUpdate' => date('d.m.Y H:i', strtotime($camera['updated_at'])),
                ],
                'geometry' => [
                    'type' => 'GeometryCollection',
                    'geometries' => [
                        [
                            'type' => 'Point',
                            'coordinates' => [$camera['camera_longitude'], $camera['camera_latitude']]
                        ],
                        [
                            'type' => 'Point',
                            'coordinates' => [$camera['target_longitude'], $camera['target_latitude']]
                        ]
                    ]
                ]
            ];
            $cameras[] = $cameraObject;
        }

        $sections = (new AverageSpeedControl())->whereIn('id', $sectionsIds)->select('data')->get();

        foreach($sections as $section) {

            $groupSectionCameras = [];
            $handledSection = json_decode($section['data'], true);

            $counter = 0;
            foreach($handledSection as $key => $value) {
                $camera = (new RoadLens())->where('ulid', $handledSection[$key]['ulid'])->first();

                $ulidPrevious = $handledSection[$counter - 1]['ulid'] ?? null;
                $ulidNext = $handledSection[$counter + 1]['ulid'] ?? null;

                $cameraObject = [
                    'type' => 'Feature',
                    'properties' => [
                        'ulid' => $camera['ulid'],
                        'type' => $camera['type'],
                        'model' => $camera['model'],
                        'angle' => $camera['angle'],
                        'car_speed' => $camera['car_speed'],
                        'truck_speed' => $camera['truck_speed'],
                        'user' => $camera['user'],
                        'isDeleted' => $camera['isDeleted'],
                        'isASC' => $camera['isASC'],
                        'ASC' => [
                            'previous' => $ulidPrevious, 
                            'speed' => $handledSection[$key]['speed'],
                            'next' => $ulidNext,
                        ],
                        'dateCreate' => date('d.m.Y H:i', strtotime($camera['created_at'])),
                        'lastUpdate' => date('d.m.Y H:i', strtotime($camera['updated_at'])),
                    ],
                    'geometry' => [
                        'type' => 'GeometryCollection',
                        'geometries' => [
                            [
                                'type' => 'Point',
                                'coordinates' => [$camera['camera_longitude'], $camera['camera_latitude']]
                            ],
                            [
                                'type' => 'Point',
                                'coordinates' => [$camera['target_longitude'], $camera['target_latitude']]
                            ]
                        ]
                    ]
                ];
                $groupSectionCameras[] = $cameraObject;
                $counter++;
            }
            $sectionsCameras[] = $groupSectionCameras;
        }

        $cameras[] = $sectionsCameras;
        return response()->json($cameras);
    }

}
