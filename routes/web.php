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



// delete this!


Route::get('/map/{latitude}/{longitude}/{zoom}', [Map::class, 'showMap']);

Route::prefix('edit')->group(function () {
    Route::get('/{latitude}/{longitude}/{zoom}', [Map::class, 'showAddPage'])
                                                ->name('addPage');
    Route::post('/add', [Map::class, 'add'])
                                                ->name('add');
    Route::post('/update/{ulid}', [Map::class, 'update'])
                                                ->whereUlid('ulid')
                                                ->name('update');
    Route::post('/delete/{ulid}', [Map::class, 'delete'])
                                                ->whereUlid('ulid')
                                                ->name('delete');
    Route::get('/{ulid}', [Map::class, 'showEditPage'])
                                                ->whereUlid('ulid')
                                                ->name('editPage');
});










Route::post('/getCoordsCameras', [Map::class, 'getCoords']);

// Route::get('/getCameras', [Map::class, 'getCamerasInBounds']);
