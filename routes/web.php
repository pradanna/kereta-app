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
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\ServiceUnitController::class, 'store'])->name('service-unit.edit');
});

Route::group(['prefix' => 'daerah-operasi'], function () {
    Route::get('/', [\App\Http\Controllers\AreaController::class, 'index'])->name('area');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\AreaController::class, 'store'])->name('area.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\AreaController::class, 'store'])->name('area.edit');
    Route::get('/{id}/storehouse', [\App\Http\Controllers\AreaController::class, 'getStorehouseByAreaID'])->name('area.storehouse');
});

Route::group(['prefix' => 'depo-dan-balai-yasa'], function () {
    Route::get('/', [\App\Http\Controllers\StoreHouseController::class, 'index'])->name('storehouse');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\StoreHouseController::class, 'store'])->name('storehouse.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\StoreHouseController::class, 'store'])->name('storehouse.edit');
});

Route::group(['prefix' => 'jenis-lokomotif'], function () {
    Route::get('/', [\App\Http\Controllers\LocomotiveTypeController::class, 'index'])->name('locomotive-type');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\LocomotiveTypeController::class, 'store'])->name('locomotive-type.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\LocomotiveTypeController::class, 'store'])->name('locomotive-type.edit');
});

Route::group(['prefix' => 'jenis-kereta'], function () {
    Route::get('/', [\App\Http\Controllers\TrainTypeController::class, 'index'])->name('train-type');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TrainTypeController::class, 'store'])->name('train-type.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\TrainTypeController::class, 'store'])->name('train-type.edit');
});

Route::group(['prefix' => 'jenis-gerbong'], function () {
    Route::get('/', [\App\Http\Controllers\WagonTypeController::class, 'index'])->name('wagon-type');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\WagonTypeController::class, 'store'])->name('wagon-type.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\WagonTypeController::class, 'store'])->name('wagon-type.edit');
    Route::get('/{id}/sub-tipe', [\App\Http\Controllers\WagonTypeController::class, 'sub_type'])->name('wagon-type.sub-type');
    Route::match(['post', 'get'], '/{id}/sub-tipe/tambah', [\App\Http\Controllers\WagonTypeController::class, 'store_sub_type'])->name('wagon-type.sub-type.create');
});

Route::group(['prefix' => 'jenis-peralatan-khusus'], function () {
    Route::get('/', [\App\Http\Controllers\SpecialEquipmentTypeController::class, 'index'])->name('special-equipment-type');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\SpecialEquipmentTypeController::class, 'store'])->name('special-equipment-type.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\SpecialEquipmentTypeController::class, 'store'])->name('special-equipment-type.edit');
});

Route::group(['prefix' => 'sertifikasi-sarana-lokomotif'], function () {
    Route::get('/', [\App\Http\Controllers\FacilityLocomotiveController::class, 'index'])->name('facility-certification-locomotive');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityLocomotiveController::class, 'store'])->name('facility-certification-locomotive.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\FacilityLocomotiveController::class, 'store'])->name('facility-certification-locomotive.edit');
});

Route::group(['prefix' => 'sertifikasi-sarana-kereta'], function () {
    Route::get('/', [\App\Http\Controllers\FacilityTrainController::class, 'index'])->name('facility-certification-train');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityTrainController::class, 'store'])->name('facility-certification-train.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\FacilityTrainController::class, 'store'])->name('facility-certification-train.edit');
});

Route::group(['prefix' => 'sertifikasi-sarana-kereta-diesel'], function () {
    Route::get('/', [\App\Http\Controllers\FacilityDieselTrainController::class, 'index'])->name('facility-certification-train-diesel');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityDieselTrainController::class, 'store'])->name('facility-certification-train-diesel.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\FacilityDieselTrainController::class, 'store'])->name('facility-certification-train-diesel.edit');
});

Route::group(['prefix' => 'sertifikasi-sarana-kereta-listrik'], function () {
    Route::get('/', [\App\Http\Controllers\FacilityElectricTrainController::class, 'index'])->name('facility-certification-train-electric');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityElectricTrainController::class, 'store'])->name('facility-certification-train-electric.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\FacilityElectricTrainController::class, 'store'])->name('facility-certification-train-electric.edit');
});

Route::group(['prefix' => 'sertifikasi-sarana-gerbong'], function () {
    Route::get('/', [\App\Http\Controllers\FacilityWagonController::class, 'index'])->name('facility-certification-wagon');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityWagonController::class, 'store'])->name('facility-certification-wagon.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\FacilityWagonController::class, 'store'])->name('facility-certification-wagon.edit');
});

Route::group(['prefix' => 'sertifikasi-sarana-peralatan-khusus'], function () {
    Route::get('/', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'index'])->name('facility-certification-special-equipment');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'store'])->name('facility-certification-special-equipment.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'store'])->name('facility-certification-special-equipment.edit');
});

Route::group(['prefix' => 'spesifikasi-teknis-sarana-lokomotif'], function () {
    Route::get('/', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'index'])->name('technical-specification.locomotive');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'store'])->name('technical-specification.locomotive.add');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'store'])->name('technical-specification.locomotive.edit');
});

Route::group(['prefix' => 'spesifikasi-teknis-sarana-kereta'], function () {
    Route::get('/', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'index'])->name('technical-specification.train');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'store'])->name('technical-specification.train.add');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'store'])->name('technical-specification.train.edit');
});

Route::group(['prefix' => 'spesifikasi-teknis-sarana-gerbong'], function () {
    Route::get('/', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'index'])->name('technical-specification.wagon');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'store'])->name('technical-specification.wagon.add');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'store'])->name('technical-specification.wagon.edit');
});

Route::group(['prefix' => 'spesifikasi-teknis-sarana-peralatan-khusus'], function () {
    Route::get('/', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'index'])->name('technical-specification.special-equipment');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'store'])->name('technical-specification.special-equipment.add');
});
