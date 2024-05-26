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

class MapPoints extends Model
{
    use HasFactory;

    protected $table = 'map_points';
    protected $fillable = [
        'ulid',
        'country',
        'region',
        'type',
        'model',
        'lat',
        'lng',
        'direction',
        'distance',
        'angle',
        'status',
        'carSpeed',
        'truckSpeed',
        'source',
        'isASC',
        'flags',
    ];





}
