<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\FacilityLocomotive;
use App\Models\FacilitySpecialEquipment;
use App\Models\FacilityTrain;
use App\Models\FacilityWagon;
use App\Models\LocomotiveType;
use App\Models\TrainType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
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
        $train_type_string = $this->request->query->get('train_type_string');


        $query = FacilityTrain::with(['area', 'storehouse.storehouse_type', 'train_type']);

//        if ($service_unit !== '' && $service_unit !== null) {
//            $query->whereHas('area', function ($qt) use ($service_unit){
//                /** @var $qt Builder */
//                return $qt->where('service_unit_id', '=', $service_unit);
//            });
//        }

        if ($area !== '') {
            $query->where('area_id', '=', $area);
        }

//        if ($storehouse !== '') {
//            $query->where('storehouse_id', '=', $storehouse);
//        }

        if ($engineType !== '') {
            $query->where('engine_type', '=', $engineType);
        }

        if ($train_type_string !== '') {
            $query->where('train_type_string', 'LIKE', '%' . $train_type_string . '%');
        }

        if ($name !== '') {
            $query->where(function ($q) use ($name) {
                /** @var Builder $q */
                $q->where('facility_number', 'LIKE', '%' . $name . '%')
                    ->orWhere('testing_number', 'LIKE', '%' . $name . '%');
            });
        }

        $data = $query->orderBy('created_at', 'DESC')
            ->get()->append(['expired_in', 'status']);

        if ($status !== '') {
            if ($status === '2') {
                $data = $data->where('expired_in', '>=', 31)->values();
            }

            if ($status === '1') {
                $data = $data->whereBetween('expired_in', [1, 30])->values();
            }
//            if ($status === '1') {
//                $data = $data->where('expired_in', '>', Formula::ExpirationLimit)->values();
//            }

            if ($status === '0') {
                $data = $data->where('expired_in', '<=', 0)->values();
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
        return view('admin.facility-menu.facility-certification.train.index')->with([
            'train_types' => $train_types,
            'areas' => $areas,
        ]);
    }

    private $rule = [
        'area' => 'required',
        'storehouse' => 'required',
        'train_type_string' => 'required',
        'engine_type' => 'required',
        'ownership' => 'required',
        'facility_number' => 'required',
        'service_start_date' => 'required',
        'service_expired_date' => 'required',
        'testing_number' => 'required',
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'storehouse.required' => 'kolom depo wajib di isi',
        'train_type_string.required' => 'kolom jenis kereta wajib di isi',
        'engine_type.required' => 'kolom tipe kereta wajib di isi',
        'ownership.required' => 'kolom kepemilikan wajib di isi',
        'facility_number.required' => 'kolom nomor sarana wajib di isi',
        'service_start_date.required' => 'kolom mulai dinas wajib di isi',
        'service_expired_date.required' => 'kolom masa berlaku wajib di isi',
        'testing_number.required' => 'kolom masa berlaku wajib di isi',
    ];

    public function store()
    {
        $access = $this->getRoleAccess(Formula::APPMenuFacilityTrain);
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
                    'area_id' => $this->postField('area'),
                    'storehouse_id' => $this->postField('storehouse'),
                    'train_type_id' => null,
                    'train_type_string' => $this->postField('train_type_string'),
                    'engine_type' => $this->postField('engine_type'),
                    'ownership' => $this->postField('ownership'),
                    'facility_number' => $this->postField('facility_number'),
//                    'service_start_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_start_date'))->format('Y-m-d'),
                    'service_start_date' => $this->postField('service_start_date').'-01-01',
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number'),
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                FacilityTrain::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $train_types = TrainType::with([])->orderBy('code', 'ASC')->get();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.facility-certification.train.add')->with([
            'train_types' => $train_types,
            'areas' => $areas
        ]);
    }

    public function patch($id)
    {
        $access = $this->getRoleAccess(Formula::APPMenuFacilityTrain);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $data = FacilityTrain::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'storehouse_id' => $this->postField('storehouse'),
                    'train_type_id' => null,
                    'train_type_string' => $this->postField('train_type_string'),
                    'engine_type' => $this->postField('engine_type'),
                    'ownership' => $this->postField('ownership'),
                    'facility_number' => $this->postField('facility_number'),
//                    'service_start_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_start_date'))->format('Y-m-d'),
                    'service_start_date' => $this->postField('service_start_date').'-01-01',
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number'),
                    'description' => $this->postField('description'),
                    'updated_by' => auth()->id(),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $train_types = TrainType::with([])->orderBy('code', 'ASC')->get();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.facility-certification.train.edit')->with([
            'data' => $data,
            'train_types' => $train_types,
            'areas' => $areas
        ]);
    }

    public function destroy($id)
    {
        $access = $this->getRoleAccess(Formula::APPMenuFacilityTrain);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
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
        $area = $this->request->query->get('area');
        $queryAreas = Area::with(['service_units']);
        if ($area !== '') {
            $queryAreas->where('id', '=', $area);
        }
        $areas = $queryAreas->orderBy('name', 'ASC')
            ->get();

        $facilityLocomotiveQuery = FacilityLocomotive::with(['area']);
        $facilityTrainsQuery = FacilityTrain::with(['area'])->where('engine_type', '=', 'train');
        $facilityDieselTrainsQuery = FacilityTrain::with(['area'])->where('engine_type', '=', 'diesel-train');
        $facilityElectricTrainsQuery = FacilityTrain::with(['area'])->where('engine_type', '=', 'electric-train');
        $facilityWagonsQuery = FacilityWagon::with(['area']);
        $facilitySpecialEquipmentsQuery = FacilitySpecialEquipment::with(['area']);
        if ($area !== '') {
            $facilityLocomotiveQuery->where('area_id', '=', $area);
            $facilityTrainsQuery->where('area_id', '=', $area);
            $facilityDieselTrainsQuery->where('area_id', '=', $area);
            $facilityElectricTrainsQuery->where('area_id', '=', $area);
            $facilityWagonsQuery->where('area_id', '=', $area);
            $facilitySpecialEquipmentsQuery->where('area_id', '=', $area);
        }
        $facilityLocomotives = $facilityLocomotiveQuery->get()->append(['expired_in']);
        $facilityTrains = $facilityTrainsQuery->get()->append(['expired_in']);
        $facilityDieselTrains = $facilityDieselTrainsQuery->get()->append(['expired_in']);
        $facilityElectricTrains = $facilityElectricTrainsQuery->get()->append(['expired_in']);
        $facilityWagons = $facilityWagonsQuery->get()->append(['expired_in']);
        $facilitySpecialEquipments = $facilitySpecialEquipmentsQuery->get()->append(['expired_in']);

        $facilitiesData = [
            'locomotives' => $facilityLocomotives,
            'trains' => $facilityTrains,
            'diesel_trains' => $facilityDieselTrains,
            'electric_trains' => $facilityElectricTrains,
            'wagons' => $facilityWagons,
            'special_equipments' => $facilitySpecialEquipments
        ];
        return Excel::download(
            new \App\Exports\FacilityCertification\FacilityTrainData($data, $areas, $facilitiesData),
            $fileName
        );
    }
}
