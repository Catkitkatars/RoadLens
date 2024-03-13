<?php 
namespace App\DTO;



class CameraDTO {
    public function __construct(
        public string $uuid,
        public string $country,
        public string $region,
        public string $type,
        public string $model,
        public string $cameraLatitude,
        public string $cameraLongitude,
        public string $targetLatitude,
        public string $targetLongitude,
        public string $direction,
        public string $distance,
        public string $angle,
        public string $carSpeed,
        public string $truckSpeed,
        public string $source = '', 
    ) {}
}