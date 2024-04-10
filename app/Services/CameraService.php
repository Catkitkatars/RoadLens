<?php

namespace App\Services;

use App\Models\AverageSpeedControl;
use App\Models\RoadLens;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use mysql_xdevapi\Collection;

class CameraService
{
    public function add($request): array
    {
        $validatedData = $request->validated();

        $validatedData['ulid'] = Str::ulid();
        $validatedData['user'] = 'admin';
        $validatedData['isDeleted'] = '0';
        $validatedData['isASC'] = '0';

        $flags = null;

        if(isset($validatedData['flags'])) {
            $flags = implode(',', array_values($validatedData['flags']));
            $validatedData['flags'] = $flags;
        }

        RoadLens::create($validatedData);
        return [
            'lat' => $validatedData['camera_latitude'],
            'lng' => $validatedData['camera_longitude']
        ];
    }
    public function update(string $ulid, $request): array
    {
        $validatedData = $request->validated();
        if(isset($validatedData['ASC'])) {
            if($validatedData['ASC']['ulid'] && $validatedData['ASC']['speed']) {
                $nextCameraAndIdSection = AverageSpeedControlService::addSection($ulid, $validatedData['ASC']);

                $validatedData['isASC'] = $nextCameraAndIdSection[1];
                RoadLens::where('ulid', $nextCameraAndIdSection[0])->update([
                    'isASC' => $nextCameraAndIdSection[1],
                ]);
            }
        }
        if(isset($validatedData['flags'])) {
            $arrayToString = implode(',', array_values($validatedData['flags']));
            $validatedData['flags'] = $arrayToString;
        }

        RoadLens::where('ulid', $ulid)->update([
            'ulid' => $ulid,
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
    public function delete(string $ulid): array
    {
        $cameraData = Roadlens::where('ulid', $ulid)->first();

        RoadLens::where('ulid', $ulid)->update([
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
        $northEastLat = (float) $request->input('northEastLat');
        $northEastLng = (float) $request->input('northEastLng');
        $southWestLat = (float) $request->input('southWestLat');
        $southWestLng = (float) $request->input('southWestLng');

        return RoadLens::whereBetween('camera_latitude', [$southWestLat, $northEastLat])
                            ->whereBetween('camera_longitude', [$southWestLng, $northEastLng])
                            ->get();
    }
    public function getCamerasInBounds($request){
        $camerasInBounds = $this->getCameras($request);

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
        $sectionsCameras = [];
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
