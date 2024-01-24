<?php

use App\Http\Controllers\FileImportController;
use App\Http\Controllers\fileImportControllerold;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/log', [fileImportControllerold::class, 'processarLog']);

Route::get('/file_import', [FileImportController::class, 'importFile']);

Route::get('/best-lap-for-each-pilot', [StatisticsController::class, 'bestLapForEachPilot']);

