<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
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
        $facility_types = FacilityType::all();

        $areas = Area::all();
        if ($this->request->ajax()) {
            $total_facilities = [];
            $facility_locomotives = FacilityLocomotive::with([])->get();
            $facility_trains = FacilityTrain::with([])->get();
            $facility_diesel_trains = FacilityDieselTrain::with([])->get();
            $facility_electric_trains = FacilityElectricTrain::with([])->get();
            $facility_wagons = FacilityWagon::with([])->get();
            $facility_special_equipment = FacilitySpecialEquipment::with([])->get();

            foreach ($areas as $area) {
                $qty_locomotive = $facility_locomotives->where('area_id', '=', $area->id)->count();
                $qty_train = $facility_trains->where('area_id', '=', $area->id)->count();
                $qty_diesel_train = $facility_diesel_trains->where('area_id', '=', $area->id)->count();
                $qty_electric_train = $facility_electric_trains->where('area_id', '=', $area->id)->count();
                $qty_wagon = $facility_wagons->where('area_id', '=', $area->id)->count();
                $qty_special_equipment = $facility_special_equipment->where('area_id', '=', $area->id)->count();
                $sum = ($qty_locomotive + $qty_train + $qty_diesel_train + $qty_electric_train + $qty_wagon + $qty_special_equipment);

                $tmp_total_facility['area'] = $area->name;
                $tmp_total_facility['locomotive'] = $qty_locomotive;
                $tmp_total_facility['train'] = $qty_train;
                $tmp_total_facility['diesel_train'] = $qty_diesel_train;
                $tmp_total_facility['electric_train'] = $qty_electric_train;
                $tmp_total_facility['wagon'] = $qty_wagon;
                $tmp_total_facility['special_equipment'] = $qty_special_equipment;
                $tmp_total_facility['total'] = $sum;
                array_push($total_facilities, $tmp_total_facility);
            }
            return $this->jsonSuccessResponse('success', $total_facilities);
        }


        return view('admin.beranda')->with([
            'facility_types' => $facility_types
        ]);
    }
}
