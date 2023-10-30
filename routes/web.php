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
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');


Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'satuan-pelayanan'], function () {
    Route::get('/', [\App\Http\Controllers\ServiceUnitController::class, 'index'])->name('service-unit');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\ServiceUnitController::class, 'store'])->name('service-unit.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\ServiceUnitController::class, 'patch'])->name('service-unit.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\ServiceUnitController::class, 'destroy'])->name('service-unit.destroy');
});

Route::group(['prefix' => 'daerah-operasi'], function () {
    Route::get('/', [\App\Http\Controllers\AreaController::class, 'index'])->name('area');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\AreaController::class, 'store'])->name('area.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\AreaController::class, 'patch'])->name('area.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\AreaController::class, 'destroy'])->name('area.destroy');
    Route::get('/{id}/storehouse', [\App\Http\Controllers\AreaController::class, 'getStorehouseByAreaID'])->name('area.storehouse');
});

Route::group(['prefix' => 'depo-dan-balai-yasa'], function () {
    Route::get('/', [\App\Http\Controllers\StoreHouseController::class, 'index'])->name('storehouse');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\StoreHouseController::class, 'store'])->name('storehouse.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\StoreHouseController::class, 'store'])->name('storehouse.edit');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\StoreHouseController::class, 'patch'])->name('storehouse.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\StoreHouseController::class, 'destroy'])->name('storehouse.destroy');
});

Route::group(['prefix' => 'jenis-lokomotif'], function () {
    Route::get('/', [\App\Http\Controllers\LocomotiveTypeController::class, 'index'])->name('locomotive-type');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\LocomotiveTypeController::class, 'store'])->name('locomotive-type.create');
    Route::match(['post', 'get'], '/ubah', [\App\Http\Controllers\LocomotiveTypeController::class, 'store'])->name('locomotive-type.edit');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\LocomotiveTypeController::class, 'patch'])->name('locomotive-type.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\LocomotiveTypeController::class, 'destroy'])->name('locomotive-type.destroy');
});

Route::group(['prefix' => 'jenis-kereta'], function () {
    Route::get('/', [\App\Http\Controllers\TrainTypeController::class, 'index'])->name('train-type');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TrainTypeController::class, 'store'])->name('train-type.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\TrainTypeController::class, 'patch'])->name('train-type.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\TrainTypeController::class, 'destroy'])->name('train-type.destroy');
});

Route::group(['prefix' => 'jenis-gerbong'], function () {
    Route::get('/', [\App\Http\Controllers\WagonTypeController::class, 'index'])->name('wagon-type');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\WagonTypeController::class, 'store'])->name('wagon-type.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\WagonTypeController::class, 'patch'])->name('wagon-type.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\WagonTypeController::class, 'destroy'])->name('wagon-type.destroy');
    Route::get('/{id}/sub-tipe', [\App\Http\Controllers\WagonTypeController::class, 'sub_type'])->name('wagon-type.sub-type');
    Route::match(['post', 'get'], '/{id}/sub-tipe/tambah', [\App\Http\Controllers\WagonTypeController::class, 'store_sub_type'])->name('wagon-type.sub-type.create');
    Route::match(['post', 'get'], '/{id}/sub-tipe/{sub_id}/edit', [\App\Http\Controllers\WagonTypeController::class, 'patch_sub_type'])->name('wagon-type.sub-type.patch');
    Route::post('/{id}/sub-tipe/{sub_id}/delete', [\App\Http\Controllers\WagonTypeController::class, 'destroy_sub_type'])->name('wagon-type.sub-type.destroy');
});

Route::group(['prefix' => 'jenis-peralatan-khusus'], function () {
    Route::get('/', [\App\Http\Controllers\SpecialEquipmentTypeController::class, 'index'])->name('special-equipment-type');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\SpecialEquipmentTypeController::class, 'store'])->name('special-equipment-type.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\SpecialEquipmentTypeController::class, 'patch'])->name('special-equipment-type.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\SpecialEquipmentTypeController::class, 'destroy'])->name('special-equipment-type.destroy');
});

Route::group(['prefix' => 'perlintasan'], function () {
    Route::get('/', [\App\Http\Controllers\TrackController::class, 'index'])->name('track');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TrackController::class, 'store'])->name('track.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\TrackController::class, 'patch'])->name('track.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\TrackController::class, 'destroy'])->name('track.destroy');
});

Route::group(['prefix' => 'lintas-antara'], function () {
    Route::get('/', [\App\Http\Controllers\SubTrackController::class, 'index'])->name('sub-track');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\SubTrackController::class, 'store'])->name('sub-track.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\SubTrackController::class, 'patch'])->name('sub-track.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\SubTrackController::class, 'destroy'])->name('sub-track.destroy');
});

Route::group(['prefix' => 'sertifikasi-sarana-lokomotif'], function () {
    Route::get('/', [\App\Http\Controllers\FacilityLocomotiveController::class, 'index'])->name('facility-certification-locomotive');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityLocomotiveController::class, 'store'])->name('facility-certification-locomotive.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityLocomotiveController::class, 'patch'])->name('facility-certification-locomotive.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\FacilityLocomotiveController::class, 'destroy'])->name('facility-certification-locomotive.destroy');
    Route::get('/{id}/detail', [\App\Http\Controllers\FacilityLocomotiveController::class, 'detail'])->name('facility-certification-locomotive.detail');
    Route::get('/excel', [\App\Http\Controllers\FacilityLocomotiveController::class, 'export_to_excel'])->name('facility-certification-locomotive.excel');
});

Route::group(['prefix' => 'sertifikasi-sarana-kereta'], function () {
    Route::get('/', [\App\Http\Controllers\FacilityTrainController::class, 'index'])->name('facility-certification-train');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityTrainController::class, 'store'])->name('facility-certification-train.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityTrainController::class, 'patch'])->name('facility-certification-train.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\FacilityTrainController::class, 'destroy'])->name('facility-certification-train.destroy');
    Route::get('/{id}/detail', [\App\Http\Controllers\FacilityTrainController::class, 'detail'])->name('facility-certification-train.detail');
    Route::get('/excel', [\App\Http\Controllers\FacilityTrainController::class, 'export_to_excel'])->name('facility-certification-train.excel');
});

Route::group(['prefix' => 'sertifikasi-sarana-kereta-diesel'], function () {
    Route::get('/', [\App\Http\Controllers\FacilityDieselTrainController::class, 'index'])->name('facility-certification-train-diesel');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityDieselTrainController::class, 'store'])->name('facility-certification-train-diesel.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityDieselTrainController::class, 'patch'])->name('facility-certification-train-diesel.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\FacilityDieselTrainController::class, 'destroy'])->name('facility-certification-train-diesel.destroy');
    Route::get('/{id}/detail', [\App\Http\Controllers\FacilityDieselTrainController::class, 'detail'])->name('facility-certification-train-diesel.detail');
    Route::get('/excel', [\App\Http\Controllers\FacilityDieselTrainController::class, 'export_to_excel'])->name('facility-certification-train-diesel.excel');
});

Route::group(['prefix' => 'sertifikasi-sarana-kereta-listrik'], function () {
    Route::get('/', [\App\Http\Controllers\FacilityElectricTrainController::class, 'index'])->name('facility-certification-train-electric');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityElectricTrainController::class, 'store'])->name('facility-certification-train-electric.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityElectricTrainController::class, 'patch'])->name('facility-certification-train-electric.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\FacilityElectricTrainController::class, 'destroy'])->name('facility-certification-train-electric.destroy');
    Route::get('/{id}/detail', [\App\Http\Controllers\FacilityElectricTrainController::class, 'detail'])->name('facility-certification-train-electric.detail');
    Route::get('/excel', [\App\Http\Controllers\FacilityElectricTrainController::class, 'export_to_excel'])->name('facility-certification-train-electric.excel');
});

Route::group(['prefix' => 'sertifikasi-sarana-gerbong'], function () {
    Route::get('/', [\App\Http\Controllers\FacilityWagonController::class, 'index'])->name('facility-certification-wagon');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityWagonController::class, 'store'])->name('facility-certification-wagon.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityWagonController::class, 'patch'])->name('facility-certification-wagon.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\FacilityWagonController::class, 'destroy'])->name('facility-certification-wagon.destroy');
    Route::get('/{id}/detail', [\App\Http\Controllers\FacilityWagonController::class, 'detail'])->name('facility-certification-wagon.detail');
    Route::get('/excel', [\App\Http\Controllers\FacilityWagonController::class, 'export_to_excel'])->name('facility-certification-wagon.excel');
});

Route::group(['prefix' => 'sertifikasi-sarana-peralatan-khusus'], function () {
    Route::get('/', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'index'])->name('facility-certification-special-equipment');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'store'])->name('facility-certification-special-equipment.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'patch'])->name('facility-certification-special-equipment.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'destroy'])->name('facility-certification-special-equipment.destroy');
    Route::get('/{id}/detail', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'detail'])->name('facility-certification-special-equipment.detail');
    Route::get('/excel', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'export_to_excel'])->name('facility-certification-special-equipment.excel');
});

Route::group(['prefix' => 'spesifikasi-teknis-sarana-lokomotif'], function () {
    Route::get('/', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'index'])->name('technical-specification.locomotive');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'store'])->name('technical-specification.locomotive.add');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'patch'])->name('technical-specification.locomotive.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'destroy'])->name('technical-specification.locomotive.destroy');
    Route::get('/{id}/detail', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'detail'])->name('technical-specification.locomotive.detail');
});

Route::group(['prefix' => 'spesifikasi-teknis-sarana-kereta'], function () {
    Route::get('/', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'index'])->name('technical-specification.train');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'store'])->name('technical-specification.train.add');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'patch'])->name('technical-specification.train.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'destroy'])->name('technical-specification.train.destroy');
    Route::get('/{id}/detail', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'detail'])->name('technical-specification.train.detail');
});

Route::group(['prefix' => 'spesifikasi-teknis-sarana-gerbong'], function () {
    Route::get('/', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'index'])->name('technical-specification.wagon');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'store'])->name('technical-specification.wagon.add');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'patch'])->name('technical-specification.wagon.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'destroy'])->name('technical-specification.wagon.destroy');
    Route::get('/{id}/detail', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'detail'])->name('technical-specification.wagon.detail');
});

Route::group(['prefix' => 'spesifikasi-teknis-sarana-peralatan-khusus'], function () {
    Route::get('/', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'index'])->name('technical-specification.special-equipment');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'store'])->name('technical-specification.special-equipment.add');
});

Route::group(['prefix' => 'jalur-perlintasan-langsung'], function () {
    Route::get('/', [\App\Http\Controllers\DirectPassageController::class, 'index'])->name('direct-passage');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\DirectPassageController::class, 'store'])->name('direct-passage.add');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\DirectPassageController::class, 'patch'])->name('direct-passage.patch');
    Route::post( '/{id}/delete', [\App\Http\Controllers\DirectPassageController::class, 'destroy'])->name('direct-passage.destroy');
    Route::get( '/{id}/detail', [\App\Http\Controllers\DirectPassageController::class, 'detail'])->name('direct-passage.detail');
    Route::get( '/excel', [\App\Http\Controllers\DirectPassageController::class, 'export_to_excel'])->name('direct-passage.excel');
});

Route::group(['prefix' => 'rekapitulasi-sarana'], function () {
    Route::get('/', [\App\Http\Controllers\SummaryFacilityController::class, 'index'])->name('summary-facility');
});
