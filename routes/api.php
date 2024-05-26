<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Map;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Тест

// Routes /api/*getAll
Route::post('/getAll', [Map::class, 'getAll']);
Route::post('/add', [Map::class, 'add']);
Route::post('update', [Map::class, 'update']);
Route::post('/points', [Map::class, 'getPointsInBounds']);


