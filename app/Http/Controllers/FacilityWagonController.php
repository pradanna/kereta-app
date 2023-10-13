<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\FacilityTrain;
use App\Models\FacilityWagon;
use App\Models\TrainType;
use App\Models\WagonSubType;
use Carbon\Carbon;

class FacilityWagonController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = FacilityWagon::with(['area', 'storehouse.storehouse_type', 'wagon_sub_type.wagon_type'])
                ->orderBy('created_at', 'ASC')
                ->get()->append(['expired_in', 'status']);
            return $this->basicDataTables($data);
        }
        $wagon_sub_types = WagonSubType::all();
        $areas = Area::all();
        return view('admin.facility-certification.wagon.index')->with([
            'wagon_sub_types' => $wagon_sub_types,
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
                    'train_type_id' => $this->postField('train_type'),
                    'ownership' => $this->postField('ownership'),
                    'facility_number' => $this->postField('facility_number'),
                    'service_start_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_start_date'))->format('Y-m-d'),
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number'),
                ];
                FacilityWagon::create($data_request);
                return redirect()->route('facility-certification-train');
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
        $train_types = TrainType::all();
        $areas = Area::all();
        return view('admin.facility-certification.train.add')->with([
            'train_types' => $train_types,
            'areas' => $areas
        ]);
    }
}
