<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Models\RoadLens;

class AverageSpeedControl extends Model
{
    use HasFactory;

    protected $fillable = ['data'];


}
