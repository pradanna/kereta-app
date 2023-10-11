<?php

use App\Http\Controllers\berandaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::match(['post', 'get'], '/', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');


Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'satuan-pelayanan'], function () {
    Route::get('/', [\App\Http\Controllers\ServiceUnitController::class, 'index'])->name('service-unit');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\ServiceUnitController::class, 'store'])->name('service-unit.create');
});

Route::group(['prefix' => 'daerah-operasi'], function () {
    Route::get('/', [\App\Http\Controllers\AreaController::class, 'index'])->name('area');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\AreaController::class, 'store'])->name('area.create');
    Route::get('/{id}/storehouse', [\App\Http\Controllers\AreaController::class, 'getStorehouseByAreaID'])->name('area.storehouse');
});

Route::group(['prefix' => 'depo-dan-balai-yasa'], function () {
    Route::get('/', [\App\Http\Controllers\StoreHouseController::class, 'index'])->name('storehouse');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\StoreHouseController::class, 'store'])->name('storehouse.create');
});

Route::group(['prefix' => 'jenis-lokomotif'], function () {
    Route::get('/', [\App\Http\Controllers\LocomotiveTypeController::class, 'index'])->name('locomotive-type');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\LocomotiveTypeController::class, 'store'])->name('locomotive-type.create');
});

Route::group(['prefix' => 'jenis-kereta'], function () {
    Route::get('/', [\App\Http\Controllers\TrainTypeController::class, 'index'])->name('train-type');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TrainTypeController::class, 'store'])->name('train-type.create');
});

Route::group(['prefix' => 'jenis-gerbong'], function () {
    Route::get('/', [\App\Http\Controllers\WagonTypeController::class, 'index'])->name('wagon-type');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\WagonTypeController::class, 'store'])->name('wagon-type.create');
    Route::get('/{id}/sub-tipe', [\App\Http\Controllers\WagonTypeController::class, 'sub_type'])->name('wagon-type.sub-type');
    Route::match(['post', 'get'], '/{id}/sub-tipe/tambah', [\App\Http\Controllers\WagonTypeController::class, 'store_sub_type'])->name('wagon-type.sub-type.create');
});

Route::group(['prefix' => 'sertifikasi-sarana-lokomotif'], function () {
    Route::get('/', [\App\Http\Controllers\FacilityLocomotiveController::class, 'index'])->name('facility-certification-locomotive');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityLocomotiveController::class, 'store'])->name('facility-certification-locomotive.create');
});

Route::group(['prefix' => 'spesifikasi-teknis-sarana-lokomotif'], function () {
    Route::get('/', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'index'])->name('technical-specification.locomotive');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'store'])->name('technical-specification.locomotive.add');
});

Route::group(['prefix' => 'spesifikasi-teknis-sarana-kereta'], function () {
    Route::get('/', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'index'])->name('technical-specification.train');
});

Route::group(['prefix' => 'spesifikasi-teknis-sarana-gerbong'], function () {
    Route::get('/', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'index'])->name('technical-specification.wagon');
});

Route::group(['prefix' => 'spesifikasi-teknis-sarana-peralatan-khusus'], function () {
    Route::get('/', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'index'])->name('technical-specification.special-equipment');
});
