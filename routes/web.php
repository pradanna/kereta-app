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

Route::group(['prefix' => 'sarana-dan-keselamatan'], function () {
    Route::get('/', [\App\Http\Controllers\MeansController::class, 'index'])->name('means');

    //sertifikasi sarana
    Route::group(['prefix' => 'sertifikasi-sarana'], function () {
        Route::get('/', [\App\Http\Controllers\MeansController::class, 'facility_certification_page'])->name('means.facility-certification');
        Route::group(['prefix' => 'lokomotif'], function () {
            Route::get('/', [\App\Http\Controllers\FacilityLocomotiveController::class, 'index'])->name('means.facility-certification.locomotive');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityLocomotiveController::class, 'store'])->name('means.facility-certification.locomotive.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityLocomotiveController::class, 'patch'])->name('means.facility-certification.locomotive.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\FacilityLocomotiveController::class, 'destroy'])->name('means.facility-certification.locomotive.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\FacilityLocomotiveController::class, 'detail'])->name('means.facility-certification.locomotive.detail');
            Route::get('/excel', [\App\Http\Controllers\FacilityLocomotiveController::class, 'export_to_excel'])->name('means.facility-certification.locomotive.excel');
        });

        Route::group(['prefix' => 'kereta'], function () {
            Route::get('/', [\App\Http\Controllers\FacilityTrainController::class, 'index'])->name('means.facility-certification.train');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityTrainController::class, 'store'])->name('means.facility-certification.train.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityTrainController::class, 'patch'])->name('means.facility-certification.train.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\FacilityTrainController::class, 'destroy'])->name('means.facility-certification.train.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\FacilityTrainController::class, 'detail'])->name('means.facility-certification.train.detail');
            Route::get('/excel', [\App\Http\Controllers\FacilityTrainController::class, 'export_to_excel'])->name('means.facility-certification.train.excel');
        });

        Route::group(['prefix' => 'gerbong'], function () {
            Route::get('/', [\App\Http\Controllers\FacilityWagonController::class, 'index'])->name('means.facility-certification.wagon');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityWagonController::class, 'store'])->name('means.facility-certification.wagon.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityWagonController::class, 'patch'])->name('means.facility-certification.wagon.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\FacilityWagonController::class, 'destroy'])->name('means.facility-certification.wagon.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\FacilityWagonController::class, 'detail'])->name('means.facility-certification.wagon.detail');
            Route::get('/excel', [\App\Http\Controllers\FacilityWagonController::class, 'export_to_excel'])->name('means.facility-certification.wagon.excel');
        });

        Route::group(['prefix' => 'peralatan-khusus'], function () {
            Route::get('/', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'index'])->name('means.facility-certification.special-equipment');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'store'])->name('means.facility-certification.special-equipment.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'patch'])->name('means.facility-certification.special-equipment.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'destroy'])->name('means.facility-certification.special-equipment.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'detail'])->name('means.facility-certification.special-equipment.detail');
            Route::get('/excel', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'export_to_excel'])->name('means.facility-certification.special-equipment.excel');
        });
    });

    //depo dan balai yasa
    Route::group(['prefix' => 'depo-dan-balai-yasa'], function () {
        Route::get('/', [\App\Http\Controllers\StoreHouseController::class, 'service_unit_page'])->name('means.storehouse');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\StoreHouseController::class, 'index'])->name('means.storehouse.service-unit');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\StoreHouseController::class, 'store'])->name('means.storehouse.service-unit.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\StoreHouseController::class, 'patch'])->name('means.storehouse.service-unit.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\StoreHouseController::class, 'destroy'])->name('means.storehouse.service-unit.destroy');
            Route::match(['post', 'get'], '/{id}/gambar', [\App\Http\Controllers\StoreHouseController::class, 'image_page'])->name('storehouse.image');
            Route::post('/{id}/gambar/{image_id}/delete-image', [\App\Http\Controllers\StoreHouseController::class, 'destroy_image'])->name('storehouse.image.destroy');
        });
    });

    //spesifikasi teknis
    Route::group(['prefix' => 'spesifikasi-teknis'], function () {
        Route::get('/', [\App\Http\Controllers\MeansController::class, 'technical_specification_page'])->name('means.technical-specification');
        Route::group(['prefix' => 'lokomotif'], function () {
            Route::get('/', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'index'])->name('means.technical-specification.locomotive');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'store'])->name('means.technical-specification.locomotive.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'patch'])->name('means.technical-specification.locomotive.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'destroy'])->name('means.technical-specification.locomotive.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'detail'])->name('means.technical-specification.locomotive.detail');
            Route::match(['post', 'get'], '/{id}/dokumen', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'document_page'])->name('means.technical-specification.locomotive.document');
            Route::match(['post', 'get'], '/{id}/gambar', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'image_page'])->name('means.technical-specification.locomotive.image');
            Route::post('/{id}/delete-document', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'destroy_document'])->name('means.technical-specification.locomotive.document.delete');
            Route::post('/{id}/delete-image', [\App\Http\Controllers\TechnicalSpecificationLocomotiveController::class, 'destroy_image'])->name('means.technical-specification.locomotive.image.delete');
        });

        Route::group(['prefix' => 'kereta'], function () {
            Route::get('/', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'index'])->name('means.technical-specification.train');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'store'])->name('means.technical-specification.train.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'patch'])->name('means.technical-specification.train.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'destroy'])->name('means.technical-specification.train.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'detail'])->name('means.technical-specification.train.detail');
            Route::match(['post', 'get'], '/{id}/dokumen', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'document_page'])->name('means.technical-specification.train.document');
            Route::match(['post', 'get'], '/{id}/gambar', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'image_page'])->name('means.technical-specification.train.image');
            Route::post('/{id}/delete-document', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'destroy_document'])->name('means.technical-specification.train.document.delete');
            Route::post('/{id}/delete-image', [\App\Http\Controllers\TechnicalSpecificationTrainController::class, 'destroy_image'])->name('means.technical-specification.train.image.delete');
        });

        Route::group(['prefix' => 'gerbong'], function () {
            Route::get('/', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'index'])->name('means.technical-specification.wagon');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'store'])->name('means.technical-specification.wagon.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'patch'])->name('means.technical-specification.wagon.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'destroy'])->name('means.technical-specification.wagon.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'detail'])->name('means.technical-specification.wagon.detail');
            Route::match(['post', 'get'], '/{id}/dokumen', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'document_page'])->name('means.technical-specification.wagon.document');
            Route::match(['post', 'get'], '/{id}/gambar', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'image_page'])->name('means.technical-specification.wagon.image');
            Route::post('/{id}/delete-document', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'destroy_document'])->name('means.technical-specification.wagon.document.delete');
            Route::post('/{id}/delete-image', [\App\Http\Controllers\TechnicalSpecificationWagonController::class, 'destroy_image'])->name('means.technical-specification.wagon.image.delete');
        });

        Route::group(['prefix' => 'peralatan-khusus'], function () {
            Route::get('/', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'index'])->name('means.technical-specification.special-equipment');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'store'])->name('means.technical-specification.special-equipment.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'patch'])->name('means.technical-specification.special-equipment.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'destroy'])->name('means.technical-specification.special-equipment.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'detail'])->name('means.technical-specification.special-equipment.detail');
            Route::match(['post', 'get'], '/{id}/dokumen', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'document_page'])->name('means.technical-specification.special-equipment.document');
            Route::match(['post', 'get'], '/{id}/gambar', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'image_page'])->name('means.technical-specification.special-equipment.image');
            Route::post('/{id}/delete-document', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'destroy_document'])->name('means.technical-specification.special-equipment.document.delete');
            Route::post('/{id}/delete-image', [\App\Http\Controllers\TechnicalSpecificationSpecialEquipmentController::class, 'destroy_image'])->name('means.technical-specification.special-equipment.image.delete');
        });
    });

    //jalur perlintasan langsung
    Route::group(['prefix' => 'jalur-perlintasan-langsung'], function () {
        Route::get('/', [\App\Http\Controllers\DirectPassageController::class, 'service_unit_page'])->name('means.direct-passage');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\DirectPassageController::class, 'index'])->name('means.direct-passage.service-unit');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\DirectPassageController::class, 'store'])->name('means.direct-passage.service-unit.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\DirectPassageController::class, 'patch'])->name('means.direct-passage.service-unit.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\DirectPassageController::class, 'destroy'])->name('means.direct-passage.service-unit.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\DirectPassageController::class, 'detail'])->name('means.direct-passage.detail');
            Route::get('/{id}/penjaga-jalur-lintasan', [\App\Http\Controllers\DirectPassageController::class, 'direct_passage_guard_page'])->name('means.direct-passage.guard');
            Route::get('/{id}/peristiwa-luar-biasa-hebat', [\App\Http\Controllers\DirectPassageController::class, 'direct_passage_accident_page'])->name('means.direct-passage.accident');
            Route::get('/excel', [\App\Http\Controllers\DirectPassageController::class, 'export_to_excel'])->name('means.direct-passage.excel');
            Route::match(['post', 'get'], '/{id}/gambar', [\App\Http\Controllers\DirectPassageController::class, 'image_page'])->name('means.direct-passage.image');
            Route::post('/{id}/gambar/{image_id}/delete-image', [\App\Http\Controllers\DirectPassageController::class, 'destroy_image'])->name('means.direct-passage.image.destroy');
        });
    });

    Route::group(['prefix' => 'daerah-rawan-bencana'], function () {
        Route::get('/', [\App\Http\Controllers\DisasterAreaController::class, 'service_unit_page'])->name('means.disaster-area');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\DisasterAreaController::class, 'index'])->name('means.disaster-area.service-unit');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\DisasterAreaController::class, 'store'])->name('means.disaster-area.service-unit.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\DisasterAreaController::class, 'patch'])->name('means.disaster-area.service-unit.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\DisasterAreaController::class, 'destroy'])->name('means.disaster-area.service-unit.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\DisasterAreaController::class, 'detail'])->name('means.disaster-area.service-unit.detail');
            Route::get('/excel', [\App\Http\Controllers\DisasterAreaController::class, 'export_to_excel'])->name('means.disaster-area.service-unit.excel');
        });
    });

    Route::group(['prefix' => 'peristiwa-luar-biasa-hebat'], function () {
        Route::get('/', [\App\Http\Controllers\DirectPassageAccidentsController::class, 'service_unit_page'])->name('means.direct-passage-accident');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\DirectPassageAccidentsController::class, 'index'])->name('means.direct-passage-accident.service-unit');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\DirectPassageAccidentsController::class, 'store'])->name('means.direct-passage-accident.service-unit.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\DirectPassageAccidentsController::class, 'patch'])->name('means.direct-passage-accident.service-unit.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\DirectPassageAccidentsController::class, 'destroy'])->name('means.direct-passage-accident.service-unit.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\DirectPassageAccidentsController::class, 'detail'])->name('means.direct-passage-accident.service-unit.detail');
            Route::get('/excel', [\App\Http\Controllers\DirectPassageAccidentsController::class, 'export_to_excel'])->name('means.direct-passage-accident.service-unit.excel');
        });
    });

    Route::group(['prefix' => 'amus'], function () {
        Route::get('/', [\App\Http\Controllers\MaterialToolController::class, 'index'])->name('means.material-tool');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\MaterialToolController::class, 'main_page'])->name('means.material-tool.main');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\MaterialToolController::class, 'store'])->name('means.material-tool.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\MaterialToolController::class, 'patch'])->name('means.material-tool.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\MaterialToolController::class, 'destroy'])->name('means.material-tool.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\MaterialToolController::class, 'detail'])->name('means.material-tool.detail');
        });
    });

    Route::group(['prefix' => 'bangunan-liar'], function () {
        Route::get('/', [\App\Http\Controllers\IllegalBuildingController::class, 'service_unit_page'])->name('means.illegal-building');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\IllegalBuildingController::class, 'index'])->name('means.illegal-building.service-unit');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\IllegalBuildingController::class, 'store'])->name('means.illegal-building.service-unit.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\IllegalBuildingController::class, 'patch'])->name('means.illegal-building.service-unit.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\IllegalBuildingController::class, 'destroy'])->name('means.illegal-building.service-unit.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\IllegalBuildingController::class, 'detail'])->name('means.illegal-building.service-unit.detail');
            Route::get('/excel', [\App\Http\Controllers\IllegalBuildingController::class, 'export_to_excel'])->name('means.illegal-building.service-unit.excel');
        });
    });

    Route::group(['prefix' => 'keselamatan-dan-kesehatan-kerja'], function () {
        Route::get('/', [\App\Http\Controllers\WorkSafetyController::class, 'index'])->name('means.work-safety');

        Route::group(['prefix' => 'monitoring-implementasi-k3'], function () {
            Route::get('/', [\App\Http\Controllers\WorkSafetyController::class, 'project_monitoring_page'])->name('means.work-safety.project-monitoring');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\WorkSafetyController::class, 'project_monitoring_add'])->name('means.work-safety.project-monitoring.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\WorkSafetyController::class, 'project_monitoring_patch'])->name('means.work-safety.project-monitoring.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\WorkSafetyController::class, 'project_monitoring_destroy'])->name('means.work-safety.project-monitoring.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\WorkSafetyController::class, 'project_monitoring_detail'])->name('means.work-safety.project-monitoring.detail');
            Route::match(['post', 'get'], '/{id}/dokumen', [\App\Http\Controllers\WorkSafetyController::class, 'project_monitoring_document'])->name('means.work-safety.project-monitoring.document');
            Route::post('/{id}/dokumen/{document_id}/delete', [\App\Http\Controllers\WorkSafetyController::class, 'project_monitoring_document_destroy'])->name('means.work-safety.project-monitoring.document.destroy');
        });

        Route::group(['prefix' => 'laporan-bulanan-k3l'], function () {
            Route::get('/', [\App\Http\Controllers\WorkSafetyController::class, 'report_page'])->name('means.work-safety.report');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\WorkSafetyController::class, 'report_add'])->name('means.work-safety.report.add');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\WorkSafetyController::class, 'report_patch'])->name('means.work-safety.report.patch');
            Route::post( '/{id}/delete', [\App\Http\Controllers\WorkSafetyController::class, 'report_destroy'])->name('means.work-safety.report.destroy');
        });
//        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\WorkSafetyController::class, 'store'])->name('means.work-safety.add');
//        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\WorkSafetyController::class, 'patch'])->name('means.work-safety.patch');
//        Route::post('/{id}/delete', [\App\Http\Controllers\WorkSafetyController::class, 'destroy'])->name('means.work-safety.destroy');
//        Route::get('/{id}/detail', [\App\Http\Controllers\WorkSafetyController::class, 'detail'])->name('means.work-safety.detail');
    });

    Route::group(['prefix' => 'sumber-daya-manusia'], function () {
        Route::get('/', [\App\Http\Controllers\HumanResourceController::class, 'category_page'])->name('means.human-resource');
        Route::group(['prefix' => '{slug}'], function () {
            Route::get('/', [\App\Http\Controllers\HumanResourceController::class, 'index'])->name('means.human-resource.service-unit');
            Route::group(['prefix' => '{service_unit_id}'], function () {
                Route::get('/', [\App\Http\Controllers\HumanResourceController::class, 'main_page'])->name('means.human-resource.main');
                Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\HumanResourceController::class, 'store'])->name('means.human-resource.create');
                Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\HumanResourceController::class, 'patch'])->name('means.human-resource.patch');
                Route::post('/{id}/delete', [\App\Http\Controllers\HumanResourceController::class, 'destroy'])->name('means.human-resource.destroy');
                Route::get('/{id}/detail', [\App\Http\Controllers\HumanResourceController::class, 'detail'])->name('means.human-resource.detail');
            });
        });
    });
});

Route::group(['prefix' => 'prasarana'], function () {
    Route::get('/', [\App\Http\Controllers\InfrastructureController::class, 'index'])->name('infrastructure');

    Route::group(['prefix' => 'safety-assessment'], function () {
        Route::get('/', [\App\Http\Controllers\SafetyAssessmentController::class, 'index'])->name('infrastructure.safety.assessment');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\SafetyAssessmentController::class, 'main_page'])->name('infrastructure.safety.assessment.main');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\SafetyAssessmentController::class, 'store'])->name('infrastructure.safety.assessment.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\SafetyAssessmentController::class, 'patch'])->name('infrastructure.safety.assessment.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\SafetyAssessmentController::class, 'destroy'])->name('infrastructure.safety.assessment.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\SafetyAssessmentController::class, 'detail'])->name('infrastructure.safety.assessment.detail');
        });
    });

    Route::group(['prefix' => 'jembatan-penyebrangan'], function () {
        Route::get('/', [\App\Http\Controllers\CrossingBridgeController::class, 'index'])->name('infrastructure.crossing.bridge');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\CrossingBridgeController::class, 'main_page'])->name('infrastructure.crossing.bridge.main');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\CrossingBridgeController::class, 'store'])->name('infrastructure.crossing.bridge.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\CrossingBridgeController::class, 'patch'])->name('infrastructure.crossing.bridge.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\CrossingBridgeController::class, 'destroy'])->name('infrastructure.crossing.bridge.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\CrossingBridgeController::class, 'detail'])->name('infrastructure.crossing.bridge.detail');
        });
    });

    Route::group(['prefix' => 'permohonan-izin-melintas-rel'], function () {
        Route::get('/', [\App\Http\Controllers\CrossingPermissionController::class, 'index'])->name('infrastructure.crossing.permission');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\CrossingPermissionController::class, 'main_page'])->name('infrastructure.crossing.permission.main');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\CrossingPermissionController::class, 'store'])->name('infrastructure.crossing.permission.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\CrossingPermissionController::class, 'patch'])->name('infrastructure.crossing.permission.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\CrossingPermissionController::class, 'destroy'])->name('infrastructure.crossing.permission.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\CrossingPermissionController::class, 'detail'])->name('infrastructure.crossing.permission.detail');
        });
    });

    Route::group(['prefix' => 'jembatan-kereta-api'], function () {
        Route::get('/', [\App\Http\Controllers\TrainBridgesController::class, 'index'])->name('infrastructure.train.bridges');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\TrainBridgesController::class, 'main_page'])->name('infrastructure.train.bridges.main');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TrainBridgesController::class, 'store'])->name('infrastructure.train.bridges.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\TrainBridgesController::class, 'patch'])->name('infrastructure.train.bridges.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\TrainBridgesController::class, 'destroy'])->name('infrastructure.train.bridges.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\TrainBridgesController::class, 'detail'])->name('infrastructure.train.bridges.detail');
        });
    });
});

Route::group(['prefix' => 'lalu-lintas'], function () {
    Route::get('/', [\App\Http\Controllers\TrafficController::class, 'index'])->name('traffic');

    Route::group(['prefix' => 'stasiun-kereta-api'], function () {
        Route::get('/', [\App\Http\Controllers\RailwayStationController::class, 'index'])->name('traffic.railway-station');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\RailwayStationController::class, 'main_page'])->name('traffic.railway-station.main');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\RailwayStationController::class, 'store'])->name('traffic.railway-station.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\RailwayStationController::class, 'patch'])->name('traffic.railway-station.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\RailwayStationController::class, 'destroy'])->name('traffic.railway-station.destroy');
            Route::get('/{id}/detail', [\App\Http\Controllers\RailwayStationController::class, 'detail'])->name('traffic.railway-station.detail');
        });
    });
});

Route::group(['prefix' => 'master-data'], function () {
    Route::get('/', function () {
        return view('admin.master-data.index');
    })->name('master-data');

    Route::group(['prefix' => 'kecamatan'], function () {
        Route::get('/', [\App\Http\Controllers\DistrictController::class, 'index'])->name('district');
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\DistrictController::class, 'store'])->name('district.create');
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\DistrictController::class, 'patch'])->name('district.patch');
        Route::post('/{id}/delete', [\App\Http\Controllers\DistrictController::class, 'destroy'])->name('district.destroy');
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
    });

    Route::group(['prefix' => 'sub-jenis-gerbong'], function () {
        Route::get('/', [\App\Http\Controllers\WagonSubTypeController::class, 'index'])->name('wagon-sub-type');
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\WagonSubTypeController::class, 'store'])->name('wagon-sub-type.create');
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\WagonSubTypeController::class, 'patch'])->name('wagon-sub-type.patch');
        Route::post('/{id}/delete', [\App\Http\Controllers\WagonSubTypeController::class, 'destroy'])->name('wagon-sub-type.destroy');
    });

    Route::group(['prefix' => 'jenis-peralatan-khusus'], function () {
        Route::get('/', [\App\Http\Controllers\SpecialEquipmentTypeController::class, 'index'])->name('special-equipment-type');
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\SpecialEquipmentTypeController::class, 'store'])->name('special-equipment-type.create');
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\SpecialEquipmentTypeController::class, 'patch'])->name('special-equipment-type.patch');
        Route::post('/{id}/delete', [\App\Http\Controllers\SpecialEquipmentTypeController::class, 'destroy'])->name('special-equipment-type.destroy');
    });

    Route::group(['prefix' => 'perlintasan'], function () {
        Route::get('/', [\App\Http\Controllers\TrackController::class, 'service_unit_page'])->name('track');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\TrackController::class, 'index'])->name('track.service-unit');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TrackController::class, 'store'])->name('track.service-unit.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\TrackController::class, 'patch'])->name('track.service-unit.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\TrackController::class, 'destroy'])->name('track.service-unit.destroy');
            Route::get('/excel', [\App\Http\Controllers\TrackController::class, 'export_to_excel'])->name('track.service-unit.excel');
            Route::get('/area', [\App\Http\Controllers\TrackController::class, 'getDataByArea'])->name('track.service-unit.by.area');
        });
    });

    Route::group(['prefix' => 'petak'], function () {
        Route::get('/', [\App\Http\Controllers\SubTrackController::class, 'service_unit_page'])->name('sub-track');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\SubTrackController::class, 'index'])->name('sub-track.service-unit');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\SubTrackController::class, 'store'])->name('sub-track.service-unit.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\SubTrackController::class, 'patch'])->name('sub-track.service-unit.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\SubTrackController::class, 'destroy'])->name('sub-track.service-unit.destroy');
        });
    });

    Route::group(['prefix' => 'jenis-rawan-bencana'], function () {
        Route::get('/', [\App\Http\Controllers\DisasterTypeController::class, 'index'])->name('disaster-type');
        Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\DisasterTypeController::class, 'store'])->name('disaster-type.create');
        Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\DisasterTypeController::class, 'patch'])->name('disaster-type.patch');
        Route::post('/{id}/delete', [\App\Http\Controllers\DisasterTypeController::class, 'destroy'])->name('disaster-type.destroy');
    });

    Route::group(['prefix' => 'resort'], function () {
        Route::get('/', [\App\Http\Controllers\ResortController::class, 'service_unit_page'])->name('resort');
        Route::group(['prefix' => '{service_unit_id}'], function () {
            Route::get('/', [\App\Http\Controllers\ResortController::class, 'index'])->name('resort.service-unit');
            Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\ResortController::class, 'store'])->name('resort.service-unit.create');
            Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\ResortController::class, 'patch'])->name('resort.service-unit.patch');
            Route::post('/{id}/delete', [\App\Http\Controllers\ResortController::class, 'destroy'])->name('resort.service-unit.destroy');
            //            Route::get('/service-unit', [\App\Http\Controllers\ResortController::class, 'getResortsByServiceUnit'])->name('resort.by.service.unit');

        });
    });
});
Route::group(['prefix' => 'pengguna'], function () {
    Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('user');
    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\UserController::class, 'store'])->name('user.create');
    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\UserController::class, 'patch'])->name('user.patch');
    Route::post('/{id}/delete', [\App\Http\Controllers\UserController::class, 'destroy'])->name('user.destroy');
});

Route::group(['prefix' => 'akses-pengguna'], function () {
    Route::match(['post', 'get'], '/', [\App\Http\Controllers\UserAccessController::class, 'index'])->name('user-access');
    Route::get('/access-menu', [\App\Http\Controllers\UserAccessController::class, 'getAccessMenu'])->name('user-access.menu');
});

Route::group(['prefix' => 'public-api'], function () {
    Route::get('/storehouse-by-area', [\App\Http\Controllers\StoreHouseController::class, 'getDataByArea'])->name('public.storehouse.by.area');
});
//Route::group(['prefix' => 'satuan-pelayanan'], function () {
//    Route::get('/', [\App\Http\Controllers\ServiceUnitController::class, 'index'])->name('service-unit');
//    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\ServiceUnitController::class, 'store'])->name('service-unit.create');
//    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\ServiceUnitController::class, 'patch'])->name('service-unit.patch');
//    Route::post('/{id}/delete', [\App\Http\Controllers\ServiceUnitController::class, 'destroy'])->name('service-unit.destroy');
//    Route::match(['post', 'get'], '/{id}/gambar', [\App\Http\Controllers\ServiceUnitController::class, 'image_page'])->name('service-unit.image');
//    Route::get('/{id}/sertifikasi-sarana', [\App\Http\Controllers\ServiceUnitController::class, 'facility_certification_page'])->name('service-unit.facility-certification');
//    Route::get('/{id}/sertifikasi-sarana/{slug}', [\App\Http\Controllers\ServiceUnitController::class, 'facility_certification_page_by_slug'])->name('service-unit.facility-certification.by.slug');
//    Route::get('/{id}/jalur-perlintasan-langsung', [\App\Http\Controllers\ServiceUnitController::class, 'direct_passage_page'])->name('service-unit.direct-passage');
//    Route::get('/{id}/daerah-rawan-bencana', [\App\Http\Controllers\ServiceUnitController::class, 'disaster_area_page'])->name('service-unit.disaster-area');
//    Route::get('/{id}/bangunan-liar', [\App\Http\Controllers\ServiceUnitController::class, 'illegal_building_page'])->name('service-unit.illegal-building');
//    Route::post('/{id}/delete-image', [\App\Http\Controllers\ServiceUnitController::class, 'destroy_image'])->name('service-unit.image.destroy');
//});
//
//Route::group(['prefix' => 'daerah-operasi'], function () {
//    Route::get('/', [\App\Http\Controllers\AreaController::class, 'index'])->name('area');
//    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\AreaController::class, 'store'])->name('area.create');
//    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\AreaController::class, 'patch'])->name('area.patch');
//    Route::post('/{id}/delete', [\App\Http\Controllers\AreaController::class, 'destroy'])->name('area.destroy');
//    Route::get('/{id}/storehouse', [\App\Http\Controllers\AreaController::class, 'getStorehouseByAreaID'])->name('area.storehouse');
//    Route::get('/{id}/sertifikasi-sarana', [\App\Http\Controllers\AreaController::class, 'facility_certification_page'])->name('area.facility-certification');
//    Route::get('/{id}/sertifikasi-sarana/{slug}', [\App\Http\Controllers\AreaController::class, 'facility_certification_page_by_slug'])->name('area.facility-certification.by.slug');
//    Route::get('/{id}/jalur-perlintasan-langsung', [\App\Http\Controllers\AreaController::class, 'direct_passage_page'])->name('area.direct-passage');
//    Route::get('/{id}/bangunan-liar', [\App\Http\Controllers\AreaController::class, 'illegal_building_page'])->name('area.illegal-building');
//});
//
//Route::group(['prefix' => 'depo-dan-balai-yasa'], function () {
////    Route::get('/', [\App\Http\Controllers\StoreHouseController::class, 'index'])->name('storehouse');
////    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\StoreHouseController::class, 'store'])->name('storehouse.create');
////    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\StoreHouseController::class, 'patch'])->name('storehouse.patch');
////    Route::post('/{id}/delete', [\App\Http\Controllers\StoreHouseController::class, 'destroy'])->name('storehouse.destroy');
//    Route::get('/area', [\App\Http\Controllers\StoreHouseController::class, 'getDataByArea'])->name('storehouse.by.area');
//
//});
//
//
//Route::group(['prefix' => 'perlintasan'], function () {
////    Route::get('/', [\App\Http\Controllers\TrackController::class, 'index'])->name('track');
////    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\TrackController::class, 'store'])->name('track.create');
////    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\TrackController::class, 'patch'])->name('track.patch');
////    Route::post('/{id}/delete', [\App\Http\Controllers\TrackController::class, 'destroy'])->name('track.destroy');
////    Route::get('/excel', [\App\Http\Controllers\TrackController::class, 'export_to_excel'])->name('track.excel');
//    Route::get('/area', [\App\Http\Controllers\TrackController::class, 'getDataByArea'])->name('track.by.area');
//});
//
//
//Route::group(['prefix' => 'sumber-daya-penjaga-jalur-lintasan'], function () {
//    Route::get('/', [\App\Http\Controllers\DirectPassageHumanResourceController::class, 'index'])->name('direct-passage-human-resource');
//    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\DirectPassageHumanResourceController::class, 'store'])->name('direct-passage-human-resource.create');
//    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\DirectPassageHumanResourceController::class, 'patch'])->name('direct-passage-human-resource.patch');
//    Route::post('/{id}/delete', [\App\Http\Controllers\DirectPassageHumanResourceController::class, 'destroy'])->name('direct-passage-human-resource.destroy');
//});
//
//Route::group(['prefix' => 'sertifikasi-sarana-lokomotif'], function () {
//    Route::get('/', [\App\Http\Controllers\FacilityLocomotiveController::class, 'index'])->name('facility-certification-locomotive');
//    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityLocomotiveController::class, 'store'])->name('facility-certification-locomotive.create');
//    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityLocomotiveController::class, 'patch'])->name('facility-certification-locomotive.patch');
//    Route::post('/{id}/delete', [\App\Http\Controllers\FacilityLocomotiveController::class, 'destroy'])->name('facility-certification-locomotive.destroy');
//    Route::get('/{id}/detail', [\App\Http\Controllers\FacilityLocomotiveController::class, 'detail'])->name('facility-certification-locomotive.detail');
//    Route::get('/excel', [\App\Http\Controllers\FacilityLocomotiveController::class, 'export_to_excel'])->name('facility-certification-locomotive.excel');
//});
//
//Route::group(['prefix' => 'sertifikasi-sarana-kereta'], function () {
//    Route::get('/', [\App\Http\Controllers\FacilityTrainController::class, 'index'])->name('facility-certification-train');
//    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityTrainController::class, 'store'])->name('facility-certification-train.create');
//    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityTrainController::class, 'patch'])->name('facility-certification-train.patch');
//    Route::post('/{id}/delete', [\App\Http\Controllers\FacilityTrainController::class, 'destroy'])->name('facility-certification-train.destroy');
//    Route::get('/{id}/detail', [\App\Http\Controllers\FacilityTrainController::class, 'detail'])->name('facility-certification-train.detail');
//    Route::get('/excel', [\App\Http\Controllers\FacilityTrainController::class, 'export_to_excel'])->name('facility-certification-train.excel');
//});
//
//Route::group(['prefix' => 'sertifikasi-sarana-kereta-diesel'], function () {
//    Route::get('/', [\App\Http\Controllers\FacilityDieselTrainController::class, 'index'])->name('facility-certification-train-diesel');
//    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityDieselTrainController::class, 'store'])->name('facility-certification-train-diesel.create');
//    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityDieselTrainController::class, 'patch'])->name('facility-certification-train-diesel.patch');
//    Route::post('/{id}/delete', [\App\Http\Controllers\FacilityDieselTrainController::class, 'destroy'])->name('facility-certification-train-diesel.destroy');
//    Route::get('/{id}/detail', [\App\Http\Controllers\FacilityDieselTrainController::class, 'detail'])->name('facility-certification-train-diesel.detail');
//    Route::get('/excel', [\App\Http\Controllers\FacilityDieselTrainController::class, 'export_to_excel'])->name('facility-certification-train-diesel.excel');
//});
//
//Route::group(['prefix' => 'sertifikasi-sarana-kereta-listrik'], function () {
//    Route::get('/', [\App\Http\Controllers\FacilityElectricTrainController::class, 'index'])->name('facility-certification-train-electric');
//    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityElectricTrainController::class, 'store'])->name('facility-certification-train-electric.create');
//    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityElectricTrainController::class, 'patch'])->name('facility-certification-train-electric.patch');
//    Route::post('/{id}/delete', [\App\Http\Controllers\FacilityElectricTrainController::class, 'destroy'])->name('facility-certification-train-electric.destroy');
//    Route::get('/{id}/detail', [\App\Http\Controllers\FacilityElectricTrainController::class, 'detail'])->name('facility-certification-train-electric.detail');
//    Route::get('/excel', [\App\Http\Controllers\FacilityElectricTrainController::class, 'export_to_excel'])->name('facility-certification-train-electric.excel');
//});
//
//Route::group(['prefix' => 'sertifikasi-sarana-gerbong'], function () {
//    Route::get('/', [\App\Http\Controllers\FacilityWagonController::class, 'index'])->name('facility-certification-wagon');
//    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilityWagonController::class, 'store'])->name('facility-certification-wagon.create');
//    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilityWagonController::class, 'patch'])->name('facility-certification-wagon.patch');
//    Route::post('/{id}/delete', [\App\Http\Controllers\FacilityWagonController::class, 'destroy'])->name('facility-certification-wagon.destroy');
//    Route::get('/{id}/detail', [\App\Http\Controllers\FacilityWagonController::class, 'detail'])->name('facility-certification-wagon.detail');
//    Route::get('/excel', [\App\Http\Controllers\FacilityWagonController::class, 'export_to_excel'])->name('facility-certification-wagon.excel');
//});
//
//Route::group(['prefix' => 'sertifikasi-sarana-peralatan-khusus'], function () {
//    Route::get('/', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'index'])->name('facility-certification-special-equipment');
//    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'store'])->name('facility-certification-special-equipment.create');
//    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'patch'])->name('facility-certification-special-equipment.patch');
//    Route::post('/{id}/delete', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'destroy'])->name('facility-certification-special-equipment.destroy');
//    Route::get('/{id}/detail', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'detail'])->name('facility-certification-special-equipment.detail');
//    Route::get('/excel', [\App\Http\Controllers\FacilitySpecialEquipmentController::class, 'export_to_excel'])->name('facility-certification-special-equipment.excel');
//});
//
//
//Route::group(['prefix' => 'jalur-perlintasan-langsung'], function () {
//    Route::get('/', [\App\Http\Controllers\DirectPassageController::class, 'index'])->name('direct-passage');
//    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\DirectPassageController::class, 'store'])->name('direct-passage.add');
//    Route::match(['post', 'get'], '/{id}/edit', [\App\Http\Controllers\DirectPassageController::class, 'patch'])->name('direct-passage.patch');
//    Route::post('/{id}/delete', [\App\Http\Controllers\DirectPassageController::class, 'destroy'])->name('direct-passage.destroy');
//    Route::get('/{id}/detail', [\App\Http\Controllers\DirectPassageController::class, 'detail'])->name('direct-passage.detail');
//    Route::get('/{id}/penjaga-jalur-lintasan', [\App\Http\Controllers\DirectPassageController::class, 'direct_passage_guard_page'])->name('direct-passage.guard');
//    Route::get('/{id}/peristiwa-luar-biasa-hebat', [\App\Http\Controllers\DirectPassageController::class, 'direct_passage_accident_page'])->name('direct-passage.accident');
//    Route::get('/excel', [\App\Http\Controllers\DirectPassageController::class, 'export_to_excel'])->name('direct-passage.excel');
//    Route::match(['post', 'get'], '/{id}/gambar', [\App\Http\Controllers\DirectPassageController::class, 'image_page'])->name('direct-passage.image');
//    Route::post('/{id}/delete-image', [\App\Http\Controllers\DirectPassageController::class, 'destroy_image'])->name('direct-passage.image.destroy');
//});
//
//
//Route::group(['prefix' => 'penjaga-jalur-lintasan'], function () {
//    Route::get('/', [\App\Http\Controllers\DirectPassageGuardController::class, 'index'])->name('direct-passage-guard');
//    Route::match(['post', 'get'], '/tambah', [\App\Http\Controllers\DirectPassageGuardController::class, 'store'])->name('direct-passage-guard.create');
//    Route::post('/{id}/delete', [\App\Http\Controllers\DirectPassageGuardController::class, 'destroy'])->name('direct-passage-guard.destroy');
//});
//
//Route::group(['prefix' => 'rekapitulasi-sarana'], function () {
//    Route::get('/', [\App\Http\Controllers\SummaryFacilityController::class, 'index'])->name('summary-facility');
//});
//
//Route::group(['prefix' => 'rekapitulasi-jalur-perlintasan-langsung'], function () {
//    Route::get('/', [\App\Http\Controllers\SummaryDirectPassageController::class, 'index'])->name('summary-direct-passage');
//});
//
//Route::group(['prefix' => 'rekapitulasi-daerah-rawan-bencana'], function () {
//    Route::get('/', [\App\Http\Controllers\SummaryDisasterAreaController::class, 'index'])->name('summary-disaster-area');
//});
