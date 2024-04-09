<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Map;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::get('/', [Map::class, 'showMap']);

Route::post('/getCameras', [Map::class, 'getCamerasInBounds']);

Route::get('/map/{latitude}/{longitude}/{zoom}', [Map::class, 'showMap']);

Route::get('/edit/{latitude}/{longitude}/{zoom}', [Map::class, 'showAddPage']);

Route::post('/edit/add', [Map::class, 'add']);

Route::post('/edit/update/{ulid}', [Map::class, 'update']);

Route::post('/edit/delete/{ulid}', [Map::class, 'delete']);

Route::get('/edit/{ulid}', [Map::class, 'showEditPage']);

Route::post('/getCoordsCameras', [Map::class, 'getCoords']);

// Route::get('/getCameras', [Map::class, 'getCamerasInBounds']);
