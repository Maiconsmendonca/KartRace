<?php

use App\Http\Controllers\FileImportController;
use App\Http\Controllers\fileImportControllerold;
use App\Http\Controllers\PilotController;
use App\Http\Controllers\RaceResultController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/process-log', [FileImportController::class, 'processLog']);

Route::get('/pilot-results', [PilotController::class, 'index']);

Route::get('/race-results', [RaceResultController::class, 'index']);

Route::get('/best-lap-for-each-pilot', [StatisticsController::class, 'bestLapForEachPilot']);
Route::get('/best-lap-of-the-race', [StatisticsController::class, 'bestLapOfTheRace']);
Route::get('/average-speed-for-each-pilot', [StatisticsController::class, 'averageSpeedForEachPilot']);
Route::get('/time-difference-from-winner-for-each-pilot', [StatisticsController::class, 'timeDifferenceFromWinnerForEachPilot']);
Route::get('/all-race-information', [StatisticsController::class, 'allRaceInformation']);
