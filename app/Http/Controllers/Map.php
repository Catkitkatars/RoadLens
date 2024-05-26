<?php

namespace App\Http\Controllers;

use App\Http\Requests\CameraFormAddRequest;
use App\Http\Requests\CameraFormUpdateRequest;
use App\Services\PointService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\AverageSpeedControl;

class Map extends Controller
{

    public function __construct(
        private readonly PointService $pointService
    ) {}

    public function add(Request $request): JsonResponse
    {
        $point = $request->all();

        $result = $this->pointService->add($point);

        return new JsonResponse([
            'success' => true,
            'data' => $result,
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $point = $request->all();

        $result = $this->pointService->update($point);

        return new JsonResponse([
            'success' => true,
            'data' => $result,
        ]);
    }

    public function getPointsInBounds(Request $request): JsonResponse
    {
        $result = $this->pointService->getCamerasInBounds($request);

        return new JsonResponse([
            "success" => true,
            'data' => $result,
        ]);
    }
}
