<?php

namespace App\Models;

use App\Http\Requests\CameraFormAddRequest;
use App\Http\Requests\CameraFormUpdateRequest;
use App\Models\AverageSpeedControl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RoadLens extends Model
{
    use HasFactory;

    protected $table = 'russia';
    protected $fillable = [
        'ulid',
        'country',
        'region',
        'type',
        'model',
        'camera_latitude',
        'camera_longitude',
        'target_latitude',
        'target_longitude',
        'direction',
        'distance',
        'angle',
        'car_speed',
        'truck_speed',
        'source',
        'isASC',
        'flags',
    ];





}
