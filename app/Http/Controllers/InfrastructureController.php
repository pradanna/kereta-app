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
use App\Models\ServiceUnit;
use Illuminate\Database\Eloquent\Builder;

class InfrastructureController extends CustomController
{
    private $formula;

    public function __construct()
    {
        parent::__construct();
        $this->formula = new Formula();
    }

    public function index()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.index')->with([
            'service_units' => $service_units
        ]);
    }

    public function menu_page($service_unit_id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        return view('admin.facility-menu.menu')->with([
            'service_unit' => $service_unit
        ]);
    }

    public function menu_by_slug_page($service_unit_id, $slug)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        switch ($slug) {
            case 'sertifikasi-sarana':
                return $this->goToFacilityCertificationPage($service_unit);
            default:
                return view('admin.facility-menu.menu')->with([
                    'service_unit' => $service_unit
                ]);
        }

    }

    private function goToFacilityCertificationPage($service_unit)
    {
        $facility_types = FacilityType::with([])->orderBy('id', 'ASC')->get();
        if ($this->request->ajax()) {
            $total_facilities = $this->generateTotalFacilityData($service_unit->id);
            return $this->jsonSuccessResponse('success', $total_facilities);
        }
        return view('admin.facility-menu.facility-certification.index')
            ->with([
                'service_unit' => $service_unit,
                'facility_types' => $facility_types,
            ]);
    }

    private function generateTotalFacilityData($id)
    {
        $service_unit = ServiceUnit::with([])->where('id', '=', $id)->first();
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $id);
            })->get();
        if ($service_unit) {
            $serviceUnitName = $service_unit->name;
            if ($serviceUnitName === Formula::ServiceUnitExceptionName) {
                $areas = Area::with(['service_units'])
                    ->whereHas('service_units', function ($qs) use ($id) {
                        /** @var $qs Builder */
                        return $qs->where('service_unit_id', '=', $id);
                    })->get();
            }
        }

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
