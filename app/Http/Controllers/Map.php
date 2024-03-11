<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Map extends Controller
{

    public function __construct(
        
    ) {}

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
        dd($request);
    }

    public function showEditPage($uuid) {
        // Получаем uuid 
        // Ищем в базе элемент с таким uuid 
        // Получаем
        // Вызваем view куда передаем данные о элементе и добавляем их в поля ввода
    }
}
