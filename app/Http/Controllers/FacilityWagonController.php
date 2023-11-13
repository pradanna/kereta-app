<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\FacilityDieselTrain;
use App\Models\FacilityTrain;
use App\Models\FacilityWagon;
use App\Models\TrainType;
use App\Models\WagonSubType;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class FacilityWagonController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    private function generateData()
    {
        $area = $this->request->query->get('area');
        $storehouse = $this->request->query->get('storehouse');
        $name = $this->request->query->get('name');
        $status = $this->request->query->get('status');

        $query = FacilityWagon::with(['area', 'storehouse.storehouse_type', 'wagon_sub_type.wagon_type']);

        if ($area !== '') {
            $query->where('area_id', '=', $area);
        }

        if ($storehouse !== '') {
            $query->where('storehouse_id', '=', $storehouse);
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
        $wagon_sub_types = WagonSubType::all();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
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
                    'wagon_sub_type_id' => $this->postField('wagon_sub_type'),
                    'ownership' => $this->postField('ownership'),
                    'facility_number' => $this->postField('facility_number'),
                    'service_start_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_start_date'))->format('Y-m-d'),
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number'),
                ];
                FacilityWagon::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $wagon_sub_types = WagonSubType::with(['wagon_type'])->get();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-certification.wagon.add')->with([
            'wagon_sub_types' => $wagon_sub_types,
            'areas' => $areas
        ]);
    }

    public function patch($id)
    {
        $data = FacilityWagon::findOrFail($id);
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
        $wagon_sub_types = WagonSubType::with(['wagon_type'])->get();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-certification.wagon.edit')->with([
            'data' => $data,
            'wagon_sub_types' => $wagon_sub_types,
            'areas' => $areas
        ]);
    }

    public function destroy($id)
    {
        try {
            FacilityWagon::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $data = FacilityWagon::with(['area', 'storehouse.storehouse_type', 'wagon_sub_type.wagon_type'])
                ->where('id', '=', $id)
                ->first()->append(['expired_in', 'status']);
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel()
    {
        $fileName = 'sertifikasi_gerbong_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData();
        return Excel::download(
            new \App\Exports\FacilityCertification\FacilityWagon($data),
            $fileName
        );
    }
}
