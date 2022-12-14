<?php

use App\Http\Controllers\API\V1\CityController;
use App\Http\Controllers\API\V1\CountryController;
use App\Http\Controllers\API\V1\StateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function() {

    Route::apiResource('countries', CountryController::class)->only([
        'index', 'show'
    ]);

    Route::apiResource('states', StateController::class)->only([
        'index', 'show'
    ]);

    Route::apiResource('cities', CityController::class)->only([
        'index', 'show'
    ]);

    Route::group(['middleware' => ['auth:sanctum']], function() {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
    });
});
