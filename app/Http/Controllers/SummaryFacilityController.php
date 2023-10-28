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

class SummaryFacilityController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {$facility_types = FacilityType::all();

        $areas = Area::all();
        if ($this->request->ajax()) {
            $type = $this->request->query->get('type');
            $facility_locomotives = FacilityLocomotive::with([])->get()->append(['expired_in']);
            $facility_trains = FacilityTrain::with([])->get()->append(['expired_in']);
            $facility_diesel_trains = FacilityDieselTrain::with([])->get()->append(['expired_in']);
            $facility_electric_trains = FacilityElectricTrain::with([])->get()->append(['expired_in']);
            $facility_wagons = FacilityWagon::with([])->get()->append(['expired_in']);
            $facility_special_equipment = FacilitySpecialEquipment::with([])->get()->append(['expired_in']);

            $total_facilities = [];
            if ($type === 'total') {
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
            } elseif ($type === 'expiration') {
                foreach ($areas as $area) {
                    $qty_locomotive = $facility_locomotives
                        ->where('area_id', '=', $area->id)
                        ->where('expired_in', '>', Formula::ExpirationLimit)
                        ->count();
                    $qty_locomotive_expired = $facility_locomotives
                        ->where('area_id', '=', $area->id)
                        ->where('expired_in', '<=', Formula::ExpirationLimit)
                        ->count();

                    $qty_train = $facility_trains
                        ->where('area_id', '=', $area->id)
                        ->where('expired_in', '>', Formula::ExpirationLimit)
                        ->count();

                    $qty_train_expired = $facility_trains
                        ->where('area_id', '=', $area->id)
                        ->where('expired_in', '<=', Formula::ExpirationLimit)
                        ->count();

                    $qty_diesel_train = $facility_diesel_trains
                        ->where('area_id', '=', $area->id)
                        ->where('expired_in', '>', Formula::ExpirationLimit)
                        ->count();

                    $qty_diesel_train_expired = $facility_diesel_trains
                        ->where('area_id', '=', $area->id)
                        ->where('expired_in', '<=', Formula::ExpirationLimit)
                        ->count();

                    $qty_electric_train = $facility_electric_trains
                        ->where('area_id', '=', $area->id)
                        ->where('expired_in', '>', Formula::ExpirationLimit)
                        ->count();

                    $qty_electric_train_expired = $facility_electric_trains
                        ->where('area_id', '=', $area->id)
                        ->where('expired_in', '<=', Formula::ExpirationLimit)
                        ->count();

                    $qty_wagon = $facility_wagons
                        ->where('area_id', '=', $area->id)
                        ->where('expired_in', '>', Formula::ExpirationLimit)
                        ->count();

                    $qty_wagon_expired = $facility_wagons
                        ->where('area_id', '=', $area->id)
                        ->where('expired_in', '<=', Formula::ExpirationLimit)
                        ->count();

                    $qty_special_equipment = $facility_special_equipment
                        ->where('area_id', '=', $area->id)
                        ->where('expired_in', '>', Formula::ExpirationLimit)
                        ->count();

                    $qty_special_equipment_expired = $facility_special_equipment
                        ->where('area_id', '=', $area->id)
                        ->where('expired_in', '<=', Formula::ExpirationLimit)
                        ->count();

                    $sum = (
                        $qty_locomotive +
                        $qty_train +
                        $qty_diesel_train +
                        $qty_electric_train +
                        $qty_wagon +
                        $qty_special_equipment +
                        $qty_locomotive_expired +
                        $qty_train_expired +
                        $qty_diesel_train_expired +
                        $qty_electric_train_expired +
                        $qty_wagon_expired +
                        $qty_special_equipment_expired
                    );

                    $tmp_total_facility['area'] = $area->name;
                    $tmp_total_facility['locomotive'] = $qty_locomotive;
                    $tmp_total_facility['locomotive_expired'] = $qty_locomotive_expired;
                    $tmp_total_facility['train'] = $qty_train;
                    $tmp_total_facility['train_expired'] = $qty_train_expired;
                    $tmp_total_facility['diesel_train'] = $qty_diesel_train;
                    $tmp_total_facility['diesel_train_expired'] = $qty_diesel_train_expired;
                    $tmp_total_facility['electric_train'] = $qty_electric_train;
                    $tmp_total_facility['electric_train_expired'] = $qty_electric_train_expired;
                    $tmp_total_facility['wagon'] = $qty_wagon;
                    $tmp_total_facility['wagon_expired'] = $qty_wagon_expired;
                    $tmp_total_facility['special_equipment'] = $qty_special_equipment;
                    $tmp_total_facility['special_equipment_expired'] = $qty_special_equipment_expired;
                    $tmp_total_facility['total'] = $sum;
                    array_push($total_facilities, $tmp_total_facility);
                }
            } else {
                $total_facilities = [];
            }

            return $this->jsonSuccessResponse('success', $total_facilities);
        }

        return view('admin.summary.facility.index')->with([
            'facility_types' => $facility_types
        ]);
    }
}
