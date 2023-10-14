<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\FacilityElectricTrain;
use App\Models\FacilitySpecialEquipment;
use App\Models\TrainType;
use Carbon\Carbon;

class FacilitySpecialEquipmentController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = FacilitySpecialEquipment::with(['area'])
                ->orderBy('created_at', 'ASC')
                ->get()->append(['expired_in', 'status']);
            return $this->basicDataTables($data);
        }
        $areas = Area::all();
        return view('admin.facility-certification.special-equipment.index')->with([
            'areas' => $areas,
        ]);
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'ownership' => $this->postField('ownership'),
                    'new_facility_number' => $this->postField('new_facility_number'),
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number') !== '' ? $this->postField('testing_number') : null,
                ];
                FacilityElectricTrain::create($data_request);
                return redirect()->route('facility-certification-special-equipment');
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
        $areas = Area::all();
        return view('admin.facility-certification.special-equipment.add')->with([
            'areas' => $areas
        ]);
    }
}
