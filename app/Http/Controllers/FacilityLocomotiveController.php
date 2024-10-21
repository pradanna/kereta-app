<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\AccessMenu;
use App\Models\Area;
use App\Models\FacilityCertification;
use App\Models\FacilityLocomotive;
use App\Models\LocomotiveType;
use App\Models\ServiceUnit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class FacilityLocomotiveController extends CustomController
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
        $query = FacilityLocomotive::with(['area', 'storehouse.storehouse_type', 'locomotive_type', 'author_create', 'author_update']);

        if ($area !== '') {
            $query->where('area_id', '=', $area);
        }

        if ($name !== '') {
            $query->where(function ($q) use ($name) {
                /** @var $q Builder */
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
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        $access = $this->getRoleAccess(Formula::APPMenuFacilityLocomotive);
        return view('admin.facility-menu.facility-certification.locomotive.index')
            ->with([
                'areas' => $areas,
                'access' => $access
            ]);
    }

    private $rule = [
        'area' => 'required',
        'storehouse' => 'required',
        'ownership' => 'required',
        'facility_number' => 'required',
        'service_start_date' => 'required',
        'service_expired_date' => 'required',
        'testing_number' => 'required',
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'storehouse.required' => 'kolom depo wajib di isi',
        'ownership.required' => 'kolom kepemilikan wajib di isi',
        'facility_number.required' => 'kolom nomor sarana wajib di isi',
        'service_start_date.required' => 'kolom mulai dinas wajib di isi',
        'service_expired_date.required' => 'kolom masa berlaku wajib di isi',
        'testing_number.required' => 'kolom masa berlaku wajib di isi',
    ];
    public function store()
    {
        $access = $this->getRoleAccess(Formula::APPMenuFacilityLocomotive);
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
                    'locomotive_type_id' => null,
                    'ownership' => $this->postField('ownership'),
                    'facility_number' => $this->postField('facility_number'),
//                    'service_start_date' => Carbon::createFromFormat('Y', $this->postField('service_start_date'))->format('Y-m-d'),
                    'service_start_date' => $this->postField('service_start_date').'-01-01',
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number'),
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                FacilityLocomotive::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $locomotive_types = LocomotiveType::all();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.facility-certification.locomotive.add')->with([
            'locomotive_types' => $locomotive_types,
            'areas' => $areas
        ]);
    }

    public function patch($id)
    {
        $access = $this->getRoleAccess(Formula::APPMenuFacilityLocomotive);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $data = FacilityLocomotive::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'storehouse_id' => $this->postField('storehouse'),
                    'locomotive_type_id' => null,
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
        $locomotive_types = LocomotiveType::all();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.facility-certification.locomotive.edit')->with([
            'data' => $data,
            'locomotive_types' => $locomotive_types,
            'areas' => $areas
        ]);
    }

    public function destroy($id)
    {
        $access = $this->getRoleAccess(Formula::APPMenuFacilityLocomotive);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            FacilityLocomotive::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $data = FacilityLocomotive::with(['area', 'storehouse.storehouse_type', 'locomotive_type'])
                ->where('id', '=', $id)
                ->first()->append(['expired_in', 'status']);
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel()
    {
        $fileName = 'sertifikasi_lokomotif_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData();
        return Excel::download(
            new \App\Exports\FacilityCertification\FacilityLocomotive($data),
            $fileName
        );
    }
}
