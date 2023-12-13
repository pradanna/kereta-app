<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\FacilityLocomotive;
use App\Models\FacilitySpecialEquipment;
use App\Models\FacilityTrain;
use App\Models\FacilityType;
use App\Models\FacilityWagon;

class MeansController extends CustomController
{
    private $formula;
    public function __construct()
    {
        parent::__construct();
        $this->formula = new Formula();
    }

    public function index()
    {
        return view('admin.facility-menu.index');
    }

    public function facility_certification_page()
    {
        $facility_types = FacilityType::with([])->orderBy('id', 'ASC')->get();
        if ($this->request->ajax()) {
            $total_facilities = $this->generateTotalFacilityData();
            return $this->jsonSuccessResponse('success', $total_facilities);
        }
        return view('admin.facility-menu.facility-certification.index')
            ->with([
                'facility_types' => $facility_types,
            ]);
    }


    private function generateTotalFacilityData()
    {
        $areas = Area::with(['service_units'])
//            ->whereHas('service_units', function ($qs) use ($id) {
//                /** @var $qs Builder */
//                return $qs->where('service_unit_id', '=', $id);
//            })
            ->orderBy('name', 'ASC')
            ->get();

        $areaID = $areas->pluck('id');
        $areaIDSValue = $areaID->values()->toArray();

        $type = $this->request->query->get('type');
        $facility_locomotives = FacilityLocomotive::with(['area'])
            ->whereIn('area_id', $areaIDSValue)
            ->get()->append(['expired_in']);
//
        $facility_trains = FacilityTrain::with(['area'])
            ->whereIn('area_id', $areaIDSValue)
            ->where('engine_type', '=', 'train')
            ->get()->append(['expired_in']);

        $facility_diesel_trains = FacilityTrain::with(['area'])
            ->whereIn('area_id', $areaIDSValue)
            ->where('engine_type', '=', 'diesel-train')
            ->get()->append(['expired_in']);

        $facility_electric_trains = FacilityTrain::with(['area'])
            ->whereIn('area_id', $areaIDSValue)
            ->where('engine_type', '=', 'electric-train')
            ->get()->append(['expired_in']);

        $facility_wagons = FacilityWagon::with(['area'])
            ->whereIn('area_id', $areaIDSValue)
            ->get()->append(['expired_in']);

        $facility_special_equipment = FacilitySpecialEquipment::with(['area'])
            ->whereIn('area_id', $areaIDSValue)
            ->get()->append(['expired_in']);

        return $this->formula->summaryTotalFacilities(
            $type,
            $areas,
            $facility_locomotives,
            $facility_trains,
            $facility_electric_trains,
            $facility_diesel_trains,
            $facility_wagons,
            $facility_special_equipment
        );
    }
}
