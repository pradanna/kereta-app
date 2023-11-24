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
    private $formula;
    public function __construct()
    {
        parent::__construct();
        $this->formula = new Formula();
    }

    public function index()
    {
        $facility_types = FacilityType::all();
        $areas = Area::all();
        if ($this->request->ajax()) {
            $type = $this->request->query->get('type');
            $facility_locomotives = FacilityLocomotive::with([])->get()->append(['expired_in']);
            $facility_trains = FacilityTrain::with([])->get()->append(['expired_in']);
            $facility_diesel_trains = FacilityDieselTrain::with([])->get()->append(['expired_in']);
            $facility_electric_trains = FacilityElectricTrain::with([])->get()->append(['expired_in']);
            $facility_wagons = FacilityWagon::with([])->get()->append(['expired_in']);
            $facility_special_equipment = FacilitySpecialEquipment::with([])->get()->append(['expired_in']);

            $total_facilities =  $this->formula->summaryTotalFacilities(
                $type,
                $areas,
                $facility_locomotives,
                $facility_trains,
                $facility_electric_trains,
                $facility_diesel_trains,
                $facility_wagons,
                $facility_special_equipment
            );
            return $this->jsonSuccessResponse('success', $total_facilities);
        }

        return view('admin.summary.facility.index')->with([
            'facility_types' => $facility_types
        ]);
    }
}
