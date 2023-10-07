<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => 'service_unit'], function (){
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\ServiceUnitController::class, 'index']);
    Route::match(['post', 'get'], '/{id}', [\App\Http\Controllers\ServiceUnitController::class, 'getDataByID']);
    Route::post( '/{id}/delete', [\App\Http\Controllers\ServiceUnitController::class, 'destroy']);
});

Route::group(['prefix' => 'area'], function (){
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\AreaController::class, 'index']);
});

Route::group(['prefix' => 'storehouse'], function (){
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\StoreHouseController::class, 'index']);
});

Route::group(['prefix' => 'facility-type'], function (){
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\FacilityTypeController::class, 'index']);
});

Route::group(['prefix' => 'facility-certification'], function (){
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\FacilityCertificationController::class, 'index']);
});
