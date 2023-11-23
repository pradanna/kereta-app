<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\FacilityDieselTrain;
use App\Models\FacilityElectricTrain;
use App\Models\FacilityLocomotive;
use App\Models\FacilitySpecialEquipment;
use App\Models\FacilityTrain;
use App\Models\FacilityType;
use App\Models\FacilityWagon;
use App\Models\ServiceUnit;

class DashboardController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $facility_locomotives = FacilityLocomotive::with([])->get()->append(['expired_in']);
        $facility_trains = FacilityTrain::with([])->get()->append(['expired_in']);
        $facility_wagons = FacilityWagon::with([])->get()->append(['expired_in']);
        $facility_special_equipments = FacilitySpecialEquipment::with([])->get()->append(['expired_in']);

        $facility_types = FacilityType::with([])->orderBy('id', 'ASC')->get();
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.beranda')->with([
            'facility_locomotives' => $facility_locomotives->count(),
            'facility_trains' => $facility_trains->count(),
            'facility_wagons' => $facility_wagons->count(),
            'facility_special_equipments' => $facility_special_equipments->count(),
            'facility_expirations' => $this->generateExpiredFacility($facility_locomotives, $facility_trains, $facility_wagons, $facility_special_equipments),
            'service_units' => $service_units,
        ]);
    }

    private function generateExpiredFacility($facility_locomotives, $facility_trains, $facility_wagons, $facility_special_equipments)
    {
        $qty_locomotive = $facility_locomotives
            ->where('expired_in', '<=', Formula::ExpirationLimit)
            ->count();

        $qty_train = $facility_trains
            ->where('engine_type', '=', 'train')
            ->where('expired_in', '<=', Formula::ExpirationLimit)
            ->count();

        $qty_train_diesel = $facility_trains
            ->where('engine_type', '=', 'diesel-train')
            ->where('expired_in', '<=', Formula::ExpirationLimit)
            ->count();

        $qty_train_electric = $facility_trains
            ->where('engine_type', '=', 'electric-train')
            ->where('expired_in', '<=', Formula::ExpirationLimit)
            ->count();

        $qty_wagon = $facility_wagons
            ->where('expired_in', '<=', Formula::ExpirationLimit)
            ->count();

        $qty_special_equipment = $facility_special_equipments
            ->where('expired_in', '<=', Formula::ExpirationLimit)
            ->count();

        return [
            [
                'type' => 'Lokomotif',
                'value' => $qty_locomotive,
            ],[
                'type' => 'Kereta',
                'value' => $qty_train,
            ],[
                'type' => 'KRD',
                'value' => $qty_train_diesel,
            ],[
                'type' => 'KRL',
                'value' => $qty_train_electric,
            ],[
                'type' => 'Gerbong',
                'value' => $qty_wagon,
            ],[
                'type' => 'Peralatan Khusus',
                'value' => $qty_special_equipment,
            ],
        ];
    }
}
