<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\FacilityElectricTrain;
use App\Models\FacilitySpecialEquipment;
use App\Models\FacilityWagon;
use App\Models\SpecialEquipmentType;
use App\Models\TrainType;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class FacilitySpecialEquipmentController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = FacilitySpecialEquipment::with(['area', 'storehouse.storehouse_type', 'special_equipment_type'])
                ->orderBy('created_at', 'ASC')
                ->get()->append(['expired_in', 'status']);
            return $this->basicDataTables($data);
        }
        $special_equipment_types = SpecialEquipmentType::all();
        $areas = Area::all();
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
        $areas = Area::all();
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
        $areas = Area::all();
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

    public function export_to_excel()
    {
        $fileName = 'sertifikasi_peralatan_khusus_' . date('YmdHis') . '.xlsx';
        $facility_special_equipment = FacilitySpecialEquipment::with(['area', 'storehouse.storehouse_type', 'special_equipment_type'])->get()->append(['expired_in']);
        return Excel::download(
            new \App\Exports\FacilityCertification\FacilitySpecialEquipment($facility_special_equipment),
            $fileName
        );
    }
}
