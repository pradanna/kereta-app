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
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class FacilitySpecialEquipmentController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    private function generateData()
    {
//        $service_unit = $this->request->query->get('service_unit');
        $area = $this->request->query->get('area');
        $name = $this->request->query->get('name');
        $status = $this->request->query->get('status');
        $query = FacilitySpecialEquipment::with(['area', 'storehouse.storehouse_type', 'special_equipment_type']);

//        if ($service_unit !== '' && $service_unit !== null) {
//            $query->whereHas('area', function ($qse) use ($service_unit){
//                /** @var $qse Builder */
//                return $qse->where('service_unit_id', '=', $service_unit);
//            });
//        }

        if ($area !== '') {
            $query->where('area_id', '=', $area);
        }

        if ($name !== '') {
            $query->where(function ($q) use ($name) {
                /** @var Builder $q */
                $q->where('new_facility_number', 'LIKE', '%' . $name . '%')
                    ->orWhere('old_facility_number', 'LIKE', '%' . $name . '%')
                    ->orWhere('testing_number', 'LIKE', '%' . $name . '%');
            });
        }

        $data = $query->orderBy('created_at', 'DESC')
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
        $access = $this->getRoleAccess(Formula::APPMenuFacilitySpecialEquipment);
        return view('admin.facility-menu.facility-certification.special-equipment.index')->with([
            'special_equipment_types' => $special_equipment_types,
            'areas' => $areas,
            'access' => $access
        ]);
    }

    private $rule = [
        'area' => 'required',
        'ownership' => 'required',
        'new_facility_number' => 'required',
        'old_facility_number' => 'required',
        'service_expired_date' => 'required',
        'testing_number' => 'required',
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'ownership.required' => 'kolom kepemilikan wajib di isi',
        'new_facility_number.required' => 'kolom nomor sarana baru wajib di isi',
        'old_facility_number.required' => 'kolom nomor sarana lama wajib di isi',
        'service_expired_date.required' => 'kolom masa berlaku wajib di isi',
        'testing_number.required' => 'kolom masa berlaku wajib di isi',
    ];

    public function store()
    {
        $access = $this->getRoleAccess(Formula::APPMenuFacilitySpecialEquipment);
        if (!$access['is_granted_create']) {
            abort(403);
        }
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'special_equipment_type_id' => null,
                    'area_id' => $this->postField('area'),
                    'ownership' => $this->postField('ownership'),
                    'new_facility_number' => $this->postField('new_facility_number'),
                    'old_facility_number' => $this->postField('old_facility_number'),
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number') !== '' ? $this->postField('testing_number') : '',
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                FacilitySpecialEquipment::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $special_equipment_types = SpecialEquipmentType::all();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.facility-certification.special-equipment.add')->with([
            'special_equipment_types' => $special_equipment_types,
            'areas' => $areas,
        ]);
    }

    public function patch($id)
    {
        $access = $this->getRoleAccess(Formula::APPMenuFacilitySpecialEquipment);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $data = FacilitySpecialEquipment::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'special_equipment_type_id' => $this->postField('special_equipment_type'),
                    'area_id' => $this->postField('area'),
                    'ownership' => $this->postField('ownership'),
                    'new_facility_number' => $this->postField('new_facility_number'),
                    'old_facility_number' => $this->postField('old_facility_number'),
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number') !== '' ? $this->postField('testing_number') : '',
                    'description' => $this->postField('description'),
                    'updated_by' => auth()->id(),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $special_equipment_types = SpecialEquipmentType::all();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.facility-certification.special-equipment.edit')->with([
            'data' => $data,
            'special_equipment_types' => $special_equipment_types,
            'areas' => $areas,
        ]);
    }

    public function destroy($id)
    {
        $access = $this->getRoleAccess(Formula::APPMenuFacilitySpecialEquipment);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
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
