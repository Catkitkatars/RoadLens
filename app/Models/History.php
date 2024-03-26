<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    private array $template = [
        'country' => 'Страна',
        'region'=> 'Регион',
        'type'=> 'Тип',
        'model'=> 'Модель',
        'camera_latitude'=> 'Широта',
        'camera_longitude'=> 'Долгота',
        'direction'=> 'Направление',
        'distance'=> 'Длина луча',
        'angle'=> 'Угол',
        'car_speed'=> 'Скорость легковой',
        'truck_speed'=> 'Скорость грузовой',
        'isDeleted'=> 'Удалена',
        'isASC'=> 'Контроль средней скорости',
        'user'=> 'Модедератор',
        'source'=> 'Источник',
    ];
    private array $flags = [
        '1' => 'Подтверждена',
        '2' => 'В спину',
        '3' => 'Разметка',
        '4' => 'Пешеходный',
        '5' => 'Обочина',
        '6' => 'Автобусная',
        '7' => 'Контроль остановки',
        '8' => 'Грузовой контроль',
        '9' => 'Дополнительный',
        '10'=> 'Контроль средней скорости',
    ];
    private array $ASC = [
        'uuid' => 'Связь с',
        'speed' => 'Средняя скорость',
    ];

    public static function addStory($changes, $previousInformation) 
    {

    }
}
