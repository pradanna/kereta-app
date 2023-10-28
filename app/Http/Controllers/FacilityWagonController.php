<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
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
        $areas = Area::all();
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
        $areas = Area::all();
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

    public function export_to_excel()
    {
        $fileName = 'sertifikasi_gerbong_' . date('YmdHis') . '.xlsx';
        $facility_wagon = FacilityWagon::with(['area', 'storehouse.storehouse_type', 'wagon_sub_type.wagon_type'])->get()->append(['expired_in']);
        return Excel::download(
            new \App\Exports\FacilityCertification\FacilityWagon($facility_wagon),
            $fileName
        );
    }
}
