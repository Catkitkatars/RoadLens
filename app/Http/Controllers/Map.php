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

        
        // dd($uuid);
        $roadLens = new RoadLens();

        dd($roadLens->addCamera($request));

        
        // DB::table('russia')->insert([
        //     'uuid' => $uuid,
        //     'country' => $request->input('country'),
        //     'region' => $request->input('country'),
        //     'type' => $request->input('country'),
        //     'model' => $request->input('country'),
        //     'camera_latitude' => $request->input('country'),
        //     'camera_longitude' => $request->input('country'),
        //     'target_latitude' => $request->input('country'),
        //     'target_longitude' => $request->input('country'),
        //     'direction' => $request->input('country'),
        //     'distance' => $request->input('country'),
        //     'angle' => $request->input('country'),
        //     'car_speed' => $request->input('country'),
        //     'truck_speed' => $request->input('country'),
        //     'source' => $request->input('country'),
        //     'flags' => ['1', '2'], // Значения флагов
        // ]);
    }

    public function showEditPage($uuid) {
        // Получаем uuid 
        // Ищем в базе элемент с таким uuid 
        // Получаем
        // Вызваем view куда передаем данные о элементе и добавляем их в поля ввода
    }
}
