<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\FacilityCertification;
use App\Models\FacilityType;
use App\Models\Storehouse;

class FacilityCertificationController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = FacilityCertification::with(['area', 'storehouse', 'facility_type'])->get()->append(['expired_in', 'status']);
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
                    'area_id' => $this->postField('area_id'),
                    'storehouse_id' => $this->postField('storehouse_id'),
                    'facility_type_id' => $this->postField('facility_type_id'),
                    'ownership' => $this->postField('ownership'),
                    'facility_number' => $this->postField('facility_number'),
                    'service_start_date' => $this->postField('service_start_date'),
                    'service_expired_date' => $this->postField('service_expired_date'),
                    'testing_number' => $this->postField('testing_number'),
                ];
                FacilityCertification::create($data_request);
                return $this->jsonCreatedResponse('success');
            } catch (\Exception $e) {
                return $this->jsonErrorResponse('internal server error', $e->getMessage());
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
