<?php


namespace App\Helper;


use Illuminate\Database\Eloquent\Collection;

class Formula
{
    const ExpirationLimit = 30;
    const APPMenuFacilityLocomotive = 1;
    const APPMenuFacilityTrain = 2;
    const APPMenuFacilityWagon = 3;
    const APPMenuFacilitySpecialEquipment = 4;
    const APPMenuStorehouse = 5;
    const APPTechSpecLocomotive = 6;
    const APPTechSpecTrain = 7;
    const APPTechSpecWagon = 8;
    const APPTechSpecSpecialEquipment = 9;
    const AppMenuDirectPassage = 10;
    const APPMenuDisasterArea = 11;
    const APPMenuDirectPassageAccident = 12;
    const APPMenuMaterialTool = 13;
    const APPMenuIllegalBuilding = 14;
    const APPWorkSafety = 15;
    const APPHumanResource = 16;
    const APPSafetyAssessment = 17;
    const APPCrossingBridges = 18;
    const APPCrossingPermission = 19;
    const APPTrainBridge = 20;
    const APPRailwayStation = 21;
    const APPMasterDistrict = 22;
    const APPMasterLocomotiveType = 23;
    const APPMasterTrainType = 24;


    const ServiceUnitExceptionName = 'Satpel Surakarta';
    const AreaExceptionName = 'DAOP 6';
    /**
     * @param $type
     * @param $areas Collection
     * @param $facility_locomotives Collection
     * @param $facility_trains Collection
     * @param $facility_electric_trains Collection
     * @param $facility_diesel_trains Collection
     * @param $facility_wagons Collection
     * @param $facility_special_equipment Collection
     * @return array
     */
    public function summaryTotalFacilities(
        $type,
        $areas,
        $facility_locomotives,
        $facility_trains,
        $facility_electric_trains,
        $facility_diesel_trains,
        $facility_wagons,
        $facility_special_equipment
    ) {
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
        return $total_facilities;
    }

    /**
     * @param $areas Collection
     * @param $dataDirectPassages Collection
     * @return array
     */
    public function summaryDirectPassages($areas, $dataDirectPassages)
    {
        $results = [];
        foreach ($areas as $area) {
            $qty_operator = $dataDirectPassages->where('sub_track.track.area_id', '=', $area->id)->where('guarded_by', '=', 0)->count();
            $qty_unit_track = $dataDirectPassages->where('sub_track.track.area_id', '=', $area->id)->where('guarded_by', '=', 1)->count();
            $qty_institution = $dataDirectPassages->where('sub_track.track.area_id', '=', $area->id)->where('guarded_by', '=', 2)->count();
            $qty_unguarded = $dataDirectPassages->where('sub_track.track.area_id', '=', $area->id)->where('guarded_by', '=', 3)->count();
            $qty_illegal = $dataDirectPassages->where('sub_track.track.area_id', '=', $area->id)->where('guarded_by', '=', 4)->count();
            $sum = ($qty_operator + $qty_unit_track + $qty_institution + $qty_unguarded + $qty_illegal);
            $tmp_result['area'] = $area->name;
            $tmp_result['operator'] = $qty_operator;
            $tmp_result['unit_track'] = $qty_unit_track;
            $tmp_result['institution'] = $qty_institution;
            $tmp_result['unguarded'] = $qty_unguarded;
            $tmp_result['illegal'] = $qty_illegal;
            $tmp_result['total'] = $sum;
            array_push($results, $tmp_result);
        }
        return $results;
    }

    /**
     * @param $disasterTypes Collection
     * @param $locationType
     * @param $serviceUnits Collection
     * @param $disasterAreas Collection
     * @return array
     */
    public function summaryDisasterByType($disasterTypes, $locationType, $serviceUnits, $disasterAreas)
    {
        $results = [];
        $typeValue = 0;
        if ($locationType === 'bridge') {
            $typeValue = 1;
        }
        foreach ($disasterTypes as $disasterType) {
            $result['disaster_type'] = $disasterType->name;
            $total = 0;
            foreach ($serviceUnits as $serviceUnit) {
                $serviceUnitID = $serviceUnit['id'];
                $qty = $disasterAreas
                    ->where('resort.service_unit_id', '=', $serviceUnitID)
                    ->where('location_type', '=', $typeValue)
                    ->where('disaster_type_id', '=', $disasterType->id)
                    ->count();
                $result[$serviceUnitID] = $qty;
                $total += $qty;
            }
            $result['total'] = $total;
            array_push($results, $result);
        }
        return $results;
    }
}
