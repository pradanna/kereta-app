<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\FacilityDieselTrain;
use App\Models\FacilityTrain;
use App\Models\TrainType;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class FacilityDieselTrainController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = FacilityDieselTrain::with(['area', 'storehouse.storehouse_type', 'train_type'])
                ->orderBy('created_at', 'ASC')
                ->get()->append(['expired_in', 'status']);
            return $this->basicDataTables($data);
        }
        $train_types = TrainType::all();
        $areas = Area::all();
        return view('admin.facility-certification.diesel-train.index')->with([
            'train_types' => $train_types,
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
                    'testing_number' => $this->postField('testing_number') !== '' ? $this->postField('testing_number') : null,
                ];
                FacilityDieselTrain::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $train_types = TrainType::all();
        $areas = Area::all();
        return view('admin.facility-certification.diesel-train.add')->with([
            'train_types' => $train_types,
            'areas' => $areas
        ]);
    }

    public function patch($id)
    {
        $data = FacilityDieselTrain::findOrFail($id);
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
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $train_types = TrainType::all();
        $areas = Area::all();
        return view('admin.facility-certification.diesel-train.edit')->with([
            'data' => $data,
            'train_types' => $train_types,
            'areas' => $areas
        ]);
    }

    public function destroy($id)
    {
        try {
            FacilityDieselTrain::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $data = FacilityDieselTrain::with(['area', 'storehouse.storehouse_type', 'train_type'])
                ->where('id', '=', $id)
                ->first()->append(['expired_in', 'status']);
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel()
    {
        $fileName = 'sertifikasi_krd_' . date('YmdHis') . '.xlsx';
        $facility_trains = FacilityDieselTrain::with(['area', 'storehouse.storehouse_type', 'train_type'])->get()->append(['expired_in']);
        return Excel::download(
            new \App\Exports\FacilityCertification\FacilityDieselTrain($facility_trains),
            $fileName
        );
    }
}
