<?php

namespace App\Services;

use App\Models\AverageSpeedControl;
use App\Models\MapPoints;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use mysql_xdevapi\Collection;
use App\Repositories\PointRepository;
use App\Repositories\AverageSpeedRepository;

class PointService
{
    public function __construct(
        private readonly PointRepository $pointRepository,
        private readonly AverageSpeedRepository $averageSpeedRepository
    ) {}
    public function add(array $point): bool
    {
        if (isset($point['flags']) && is_array($point['flags'])) {
            $point['flags'] = implode(',', $point['flags']);
        }
        $point['ulid'] = Str::ulid();

        if(isset($point['ASC']))
        {
            $numberSectionNextPoint = $this->pointRepository->getSectionId($point['ASC']['next']);

            if($numberSectionNextPoint !== 0) {
                $sectionNextPoint = $this->averageSpeedRepository->getSection($numberSectionNextPoint);

                if($sectionNextPoint[0]['ulid'] === $point['ASC']['next']) {
                    $newSection = [
                        [
                            'ulid' => $point['ulid'],
                            'speed' => $point['ASC']['speed']
                        ],
                        ...$sectionNextPoint
                    ];

                    $this->averageSpeedRepository->updateSection($numberSectionNextPoint, $newSection);
                    $point['isASC'] = $numberSectionNextPoint;
                }
            }

            if($numberSectionNextPoint === 0) {
                $section = [
                        [
                            'ulid' => $point['ulid'],
                            'speed' => $point['ASC']['speed'],
                        ],
                        [
                            'ulid' => $point['ASC']['next'],
                            'speed' => $point['ASC']['speed'],
                        ]
                    ];

                $sectionId = $this->averageSpeedRepository->createSection($section);
                $this->pointRepository->setSectionId($point['ASC']['next'], $sectionId);
                $point['isASC'] = $sectionId;
            }
        }
        return $this->pointRepository->addPoint($point);
    }

    public function update($point)
    {
        if (isset($point['flags']) && is_array($point['flags'])) {
            $point['flags'] = implode(',', $point['flags']);
        }
        if(isset($point['status']) && $point['status'] >= 1) {
            $point['distance'] = 0;

            if($point['isASC'] !== 0)
            {
                $section = $this->averageSpeedRepository->getSection($point['isASC']);

                $newSection = [];

                foreach ($section as $key => $sectionPoint) {
                    if($section[$key]['ulid'] === $point['ulid']){
                        continue;
                    }
                    $newSection[] = $section[$key];
                }
                if(count($newSection) <= 1)
                {
                    $this->pointRepository->setSectionId($newSection[0]['ulid'], 0);
                    $this->averageSpeedRepository->deleteSections([$point['isASC']]);
                }
                else
                {
                    $this->averageSpeedRepository->updateSection($point['isASC'], $newSection);
                }
                $point['isASC'] = 0;
            }

            return $this->pointRepository->updatePoint($point);
        }

        // Если точка ещё не участник секции
        if(isset($point['ASC']) && $point['isASC'] === 0) {
            //Уточняем, является ли следующая точка секцией.
            $sectionIdNextPoint = $this->pointRepository->getSectionId($point['ASC']['next']);
            // Если следующая точка - часть секции
            if($sectionIdNextPoint !== 0) {
                $sectionNextPoint = $this->averageSpeedRepository->getSection($sectionIdNextPoint);

                if($sectionNextPoint[0]['ulid'] === $point['ASC']['next']){
                    $newSection = [
                        [
                            'ulid' => $point['ulid'],
                            'speed' => $point['ASC']['speed'],
                        ],
                        ...$sectionNextPoint
                    ];
                    $newSectionId = $this->averageSpeedRepository->updateSection($sectionIdNextPoint, $newSection);
                    $point['isASC'] = $newSectionId;
                }
            }
            //Если следующая точка не часть секции
            if($sectionIdNextPoint === 0) {
                $newSection = [
                    [
                        'ulid' => $point['ulid'],
                        'speed' => $point['ASC']['speed'],
                    ],
                    [
                        'ulid' => $point['ASC']['next'],
                        'speed' => $point['ASC']['speed'],
                    ]
                ];

                $newSectionId = $this->averageSpeedRepository->createSection($newSection);
                $this->pointRepository->setSectionId($point['ASC']['next'], $newSectionId);
                $point['isASC'] = $newSectionId;

                // Создаем секцию, добавляем id секции в каждую точку.
            }
        }
        // Если точка участник секции
        if(isset($point['ASC']) && isset($point['ASC']['next']) && $point['isASC'] !== 0) {
            // Проверяем, является ли точка финиш, участником секции.
            $idSectionNextPoint = $this->pointRepository->getSectionId($point['ASC']['next']);

            // Если не является участником секции
            if($idSectionNextPoint === 0) {
                // Запрашиваем секцию в конец которой хотим добавить точку
                $pointSection = $this->averageSpeedRepository->getSection($point['isASC']);

                // Если заменяем финиш на другой.
                if($pointSection[count($pointSection) - 2]['ulid'] === $point['ulid']) {
                    $this->pointRepository->setSectionId($pointSection[count($pointSection) - 1]['ulid'], 0);
                    array_splice($pointSection, -1);
                    $newSection = [
                        ...$pointSection,
                        [
                            'ulid' => $point['ASC']['next'],
                            'speed' => $point['ASC']['speed'],
                        ]
                    ];

                    $this->averageSpeedRepository->updateSection($point['isASC'], $newSection);
                    $this->pointRepository->setSectionId($point['ASC']['next'], $point['isASC']);
                }

                // Если последний элемент секции это наш поинт - добавляем в конец секции следующий поинт
                if($pointSection[count($pointSection) - 1]['ulid'] === $point['ulid']){
                    $newSection = [
                        ...$pointSection,
                        [
                            'ulid' => $point['ASC']['next'],
                            'speed' => $point['ASC']['speed'],
                        ]
                    ];
                    $this->averageSpeedRepository->updateSection($point['isASC'], $newSection);
                    $this->pointRepository->setSectionId($point['ASC']['next'], $point['isASC']);
                }
            }
            // Если является участником секции
            if($idSectionNextPoint !== 0) {
                //Берем секцию текущего point
                $pointSection = $this->averageSpeedRepository->getSection($point['isASC']);
                //Берем секцию next point
                $nextPointSectionId = $this->pointRepository->getSectionId($point['ASC']['next']);
                $nextPointSection = $this->averageSpeedRepository->getSection($nextPointSectionId);

                // Если текущий point - последний в своей секции, а следующий point - первый в своей секции
                // Склеиваем секции
                if(
                    $pointSection[count($pointSection) - 1]['ulid'] === $point['ulid'] &&
                    $nextPointSection[0]['ulid'] === $point['ASC']['next']
                ) {
                    $newSection = [
                        ...$pointSection,
                        ...$nextPointSection
                    ];
                    // Получем ulid всех точек чей isASC надо обновить
                    $ulidsToUpdateIsASC = [];
                    foreach ($pointSection as $sectionPoint) {
                        if($sectionPoint['ulid'] === $point['ulid']) {
                            continue;
                        }
                        $ulidsToUpdateIsASC[] = $sectionPoint['ulid'];
                    }
                    foreach ($nextPointSection as $sectionPoint) {
                        $ulidsToUpdateIsASC[] = $sectionPoint['ulid'];
                    }

                    $this->averageSpeedRepository->deleteSections([$point['isASC'], $nextPointSectionId]);
                    $newSectionId = $this->averageSpeedRepository->createSection($newSection);
                    $this->pointRepository->updateASCs($ulidsToUpdateIsASC, $newSectionId);
                    $point['isASC'] = $newSectionId;
                }
            }
        }
        // Если выключили ASC
        if(!isset($point['ASC']) && $point['isASC'] !== 0) {
            $section = $this->averageSpeedRepository->getSection($point['isASC']);

            $newSection = [];

            foreach ($section as $sectionPoint) {
                if($sectionPoint['ulid'] !== $point['ulid']) {
                    $newSection[] = $sectionPoint;
                }
            }
            if(count($newSection) >= 2) {
                $this->averageSpeedRepository->updateSection($point['isASC'], $newSection);
            }
            if(count($newSection) < 2) {
                $this->pointRepository->setSectionId($newSection[0]['ulid'], 0);
                $this->averageSpeedRepository->deleteSections([$point['isASC']]);
            }

            $point['isASC'] = 0;
        }

        return $this->pointRepository->updatePoint($point);
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
