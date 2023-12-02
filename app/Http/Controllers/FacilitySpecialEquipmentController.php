<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\FacilityElectricTrain;
use App\Models\FacilitySpecialEquipment;
use App\Models\FacilityWagon;
use App\Models\SpecialEquipmentType;
use App\Models\TrainType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class FacilitySpecialEquipmentController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    private function generateData()
    {
        $service_unit = $this->request->query->get('service_unit');
        $area = $this->request->query->get('area');
        $name = $this->request->query->get('name');
        $status = $this->request->query->get('status');
        $query = FacilitySpecialEquipment::with(['area', 'storehouse.storehouse_type', 'special_equipment_type']);

        if ($service_unit !== '' && $service_unit !== null) {
            $query->whereHas('area', function ($qse) use ($service_unit){
                /** @var $qse Builder */
                return $qse->where('service_unit_id', '=', $service_unit);
            });
        }

        if ($area !== '') {
            $query->where('area_id', '=', $area);
        }

        if ($name !== '') {
            $query->where(function ($q) use ($name) {
                $q->where('new_facility_number', 'LIKE', '%' . $name . '%')
                    ->orWhere('old_facility_number', 'LIKE', '%' . $name . '%')
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
        $special_equipment_types = SpecialEquipmentType::all();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-certification.special-equipment.index')->with([
            'special_equipment_types' => $special_equipment_types,
            'areas' => $areas,
        ]);
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'special_equipment_type_id' => $this->postField('special_equipment_type'),
                    'area_id' => $this->postField('area'),
                    'ownership' => $this->postField('ownership'),
                    'new_facility_number' => $this->postField('new_facility_number'),
                    'old_facility_number' => $this->postField('old_facility_number'),
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number') !== '' ? $this->postField('testing_number') : null,
                ];
                FacilitySpecialEquipment::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $special_equipment_types = SpecialEquipmentType::all();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-certification.special-equipment.add')->with([
            'special_equipment_types' => $special_equipment_types,
            'areas' => $areas,
        ]);
    }

    public function patch($id)
    {
        $data = FacilitySpecialEquipment::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'special_equipment_type_id' => $this->postField('special_equipment_type'),
                    'area_id' => $this->postField('area'),
                    'ownership' => $this->postField('ownership'),
                    'new_facility_number' => $this->postField('new_facility_number'),
                    'old_facility_number' => $this->postField('old_facility_number'),
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number') !== '' ? $this->postField('testing_number') : null,
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $special_equipment_types = SpecialEquipmentType::all();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-certification.special-equipment.edit')->with([
            'data' => $data,
            'special_equipment_types' => $special_equipment_types,
            'areas' => $areas,
        ]);
    }

    public function destroy($id)
    {
        try {
            FacilitySpecialEquipment::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $data = FacilitySpecialEquipment::with(['area', 'storehouse.storehouse_type', 'special_equipment_type'])
                ->where('id', '=', $id)
                ->first()->append(['expired_in', 'status']);
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel()
    {
        $fileName = 'sertifikasi_peralatan_khusus_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData();
        return Excel::download(
            new \App\Exports\FacilityCertification\FacilitySpecialEquipment($data),
            $fileName
        );
    }
}
