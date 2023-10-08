<?php

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

Route::match(['post', 'get'],'/', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::group(['prefix' => 'satuan-pelayanan'], function (){
    Route::get( '/', [\App\Http\Controllers\ServiceUnitController::class, 'index'])->name('service-unit');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\ServiceUnitController::class, 'store'])->name('service-unit.create');
});

Route::group(['prefix' => 'daerah-operasi'], function (){
    Route::get( '/', [\App\Http\Controllers\AreaController::class, 'index'])->name('area');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\AreaController::class, 'store'])->name('area.create');
});

Route::group(['prefix' => 'depo-dan-balai-yasa'], function () {
    Route::get('/', [\App\Http\Controllers\StoreHouseController::class, 'index'])->name('storehouse');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\StoreHouseController::class, 'store'])->name('storehouse.create');
});


