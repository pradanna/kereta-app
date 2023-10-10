<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\FacilityCertification;
use App\Models\FacilityType;
use App\Models\Storehouse;
use Carbon\Carbon;

class FacilityCertificationController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = FacilityCertification::with(['area', 'storehouse.storehouse_type', 'facility_type'])->orderBy('created_at', 'ASC')->get()->append(['expired_in', 'status']);
            return $this->basicDataTables($data);
        }
        $facility_types = FacilityType::all();
        $areas = Area::all();
        return view('admin.facility-certification.index')->with([
            'facility_types' => $facility_types,
            'areas' => $areas,
        ]);
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'storehouse_id' => $this->postField('storehouse'),
                    'facility_type_id' => $this->postField('facility_type'),
                    'ownership' => $this->postField('ownership'),
                    'facility_number' => $this->postField('facility_number'),
                    'service_start_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_start_date'))->format('Y-m-d'),
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number'),
                ];
                FacilityCertification::create($data_request);
                return redirect()->route('facility-certification');
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
        $facility_types = FacilityType::all();
        $areas = Area::all();
        return view('admin.facility-certification.add')->with([
            'facility_types' => $facility_types,
            'areas' => $areas,
        ]);
    }
}
