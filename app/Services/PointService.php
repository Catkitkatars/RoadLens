<?php

namespace App\Services;

use App\Models\AverageSpeedControl;
use App\Models\MapPoints;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use mysql_xdevapi\Collection;
use App\Repository\PointRepository;

class PointService
{
    public function __construct(
        private readonly PointRepository $repository
    ) {}
    public function add($data): bool
    {
        if (isset($data['flags']) && is_array($data['flags'])) {
            $data['flags'] = implode(',', $data['flags']);
        }
        $data['ulid'] = Str::ulid();

        return $this->repository->addNewPoint($data);
    }
    public function getCameras($request)
    {
        $northEastLat = (float) $request->input('northEastLat');
        $northEastLng = (float) $request->input('northEastLng');
        $southWestLat = (float) $request->input('southWestLat');
        $southWestLng = (float) $request->input('southWestLng');

        return MapPoints::whereBetween('lat', [$southWestLat, $northEastLat])
                            ->whereBetween('lng', [$southWestLng, $northEastLng])
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
                'type' => 'Point',
                'properties' => [
                    'country' => $camera['country'],
                    'region' => $camera['region'],
                    'latLng' => [$camera['lat'], $camera['lng']],
                    'ulid' => $camera['ulid'],
                    'type' => $camera['type'],
                    'model' => $camera['model'],
                    'angle' => $camera['angle'],
                    'direction'=> $camera['direction'],
                    'distance' => $camera['distance'],
                    'carSpeed' => $camera['carSpeed'],
                    'truckSpeed' => $camera['truckSpeed'],
                    'user' => $camera['user'],
                    'flags' => explode(',', $camera['flags']),
                    'status' => $camera['status'],
                    'isASC' => $camera['isASC'],
                    'dateCreate' => date('d.m.Y H:i', strtotime($camera['created_at'])),
                    'lastUpdate' => date('d.m.Y H:i', strtotime($camera['updated_at'])),
                ]
            ];
            $cameras[] = $cameraObject;
        }

        $sections = (new AverageSpeedControl())->whereIn('id', $sectionsIds)->select('data')->get();

        foreach($sections as $section) {
            $handledSection = json_decode($section['data'], true);



            $counter = 0;
            foreach($handledSection as $key => $value) {
                $camera = (new MapPoints())->where('ulid', $handledSection[$key]['ulid'])->first();

                $ulidPrevious = $handledSection[$counter - 1]['ulid'] ?? null;
                $ulidNext = $handledSection[$counter + 1]['ulid'] ?? null;

                $cameraObject = [
                    'type' => 'SectionPoint',
                    'properties' => [
                        'country' => $camera['country'],
                        'region' => $camera['region'],
                        'latLng' => [$camera['lat'], $camera['lng']],
                        'ulid' => $camera['ulid'],
                        'type' => $camera['type'],
                        'model' => $camera['model'],
                        'angle' => $camera['angle'],
                        'direction'=> $camera['direction'],
                        'distance' => $camera['distance'],
                        'carSpeed' => $camera['carSpeed'],
                        'truckSpeed' => $camera['truckSpeed'],
                        'user' => $camera['user'],
                        'flags' => explode(',', $camera['flags']),
                        'status' => $camera['status'],
                        'isASC' => $camera['isASC'],
                        'ASC' => [
                            'previous' => $ulidPrevious,
                            'speed' => $handledSection[$key]['speed'],
                            'next' => $ulidNext,
                        ],
                        'dateCreate' => date('d.m.Y H:i', strtotime($camera['created_at'])),
                        'lastUpdate' => date('d.m.Y H:i', strtotime($camera['updated_at'])),
                    ]
                ];
                $cameras[] = $cameraObject;
                $counter++;
            }
        }
        return response()->json($cameras);
    }
}
