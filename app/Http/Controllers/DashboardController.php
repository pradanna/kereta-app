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

class DashboardController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $facility_locomotives = FacilityLocomotive::with([])->count();
        $facility_trains = FacilityTrain::with([])->count();
        $facility_wagons = FacilityWagon::with([])->count();
        $facility_special_equipments = FacilitySpecialEquipment::with([])->count();
        return view('admin.beranda')->with([
            'facility_locomotives' => $facility_locomotives,
            'facility_trains' => $facility_trains,
            'facility_wagons' => $facility_wagons,
            'facility_special_equipments' => $facility_special_equipments,
        ]);
    }
}
