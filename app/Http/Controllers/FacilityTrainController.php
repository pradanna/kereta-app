<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\FacilityLocomotive;
use App\Models\FacilityTrain;
use App\Models\LocomotiveType;
use App\Models\TrainType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class FacilityTrainController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    private function generateData()
    {
        $service_unit = $this->request->query->get('service_unit');
        $area = $this->request->query->get('area');
        $storehouse = $this->request->query->get('storehouse');
        $name = $this->request->query->get('name');
        $status = $this->request->query->get('status');
        $engineType = $this->request->query->get('engine_type');


        $query = FacilityTrain::with(['area', 'storehouse.storehouse_type', 'train_type']);

        if ($service_unit !== '' && $service_unit !== null) {
            $query->whereHas('area', function ($qt) use ($service_unit){
                /** @var $qt Builder */
                return $qt->where('service_unit_id', '=', $service_unit);
            });
        }

        if ($area !== '') {
            $query->where('area_id', '=', $area);
        }

        if ($storehouse !== '') {
            $query->where('storehouse_id', '=', $storehouse);
        }

        if ($engineType !== '') {
            $query->where('engine_type', '=', $engineType);
        }

        if ($name !== '') {
            $query->where(function ($q) use ($name) {
                $q->where('facility_number', 'LIKE', '%' . $name . '%')
                    ->orWhere('testing_number', 'LIKE', '%' . $name . '%');
            });
        }

        $data = $query->orderBy('created_at', 'ASC')
            ->get()->append(['expired_in', 'status']);

        if ($status !== '') {
            if ($status === '1') {
                $data = $data->where('expired_in', '>', Formula::ExpirationLimit)->values();
            }

            if ($status === '0') {
                $data = $data->where('expired_in', '<=', Formula::ExpirationLimit)->values();
            }
        }
        return $data;
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = $this->generateData();
            return $this->basicDataTables($data);
        }
        $train_types = TrainType::all();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-certification.train.index')->with([
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
                    'engine_type' => $this->postField('engine_type'),
                    'ownership' => $this->postField('ownership'),
                    'facility_number' => $this->postField('facility_number'),
                    'service_start_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_start_date'))->format('Y-m-d'),
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number'),
                ];
                FacilityTrain::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $train_types = TrainType::with([])->orderBy('code', 'ASC')->get();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-certification.train.add')->with([
            'train_types' => $train_types,
            'areas' => $areas
        ]);
    }

    public function patch($id)
    {
        $data = FacilityTrain::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'storehouse_id' => $this->postField('storehouse'),
                    'train_type_id' => $this->postField('train_type'),
                    'engine_type' => $this->postField('engine_type'),
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
        $train_types = TrainType::with([])->orderBy('code', 'ASC')->get();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-certification.train.edit')->with([
            'data' => $data,
            'train_types' => $train_types,
            'areas' => $areas
        ]);
    }

    public function destroy($id)
    {
        try {
            FacilityTrain::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $data = FacilityTrain::with(['area', 'storehouse.storehouse_type', 'train_type'])
                ->where('id', '=', $id)
                ->first()->append(['expired_in', 'status']);
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel()
    {
        $fileName = 'sertifikasi_kereta_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData();
        return Excel::download(
            new \App\Exports\FacilityCertification\FacilityTrain($data),
            $fileName
        );
    }
}
