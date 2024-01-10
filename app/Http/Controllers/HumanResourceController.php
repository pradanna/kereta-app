<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\HumanResource;
use App\Models\MaterialTool;
use App\Models\Resort;
use App\Models\ServiceUnit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class HumanResourceController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function category_page()
    {
        return view('admin.facility-menu.human-resource.category');
    }

    private function generateSlug($slug)
    {
        $type = '-';
        switch ($slug) {
            case 'ppka':
                $type = 'PPKA';
                break;
            case 'awak-sarana-perkeretaapian':
                $type = 'Awak Sarana Perkeretaapian';
                break;
            case 'pemeriksa-sarana':
                $type = 'Pemeriksa Sarana';
                break;
            case 'perawat-sarana':
                $type = 'Perawat Sarana';
                break;
            case 'penjaga-perlintasan':
                $type = 'Penjaga Perlintasan Kereta Api (PJL)';
                break;
            default:
                break;
        }
        return $type;
    }

    public function index($slug)
    {
        $type = $this->generateSlug($slug);
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.human-resource.service-unit')
            ->with([
                'service_units' => $service_units,
                'type' => $type
            ]);
    }

    private function generateData($slug, $areaIDS)
    {
        $query = HumanResource::with(['area'])->where('type', '=', $slug);
        $area = $this->request->query->get('area');
        $name = $this->request->query->get('name');
        $status = $this->request->query->get('status');
        if ($area !== '') {
            $query->where('area_id', '=', $area);
        } else {

            $query->whereIn('area_id', $areaIDS);
        }

        if ($name !== '') {
            $query->where(function ($q) use ($name) {
                /** @var $q Builder */
                $q->where('name', 'LIKE', '%' . $name . '%');
            });
        }

        $data = $query
            ->orderBy('created_at', 'ASC')
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

    public function main_page($slug, $service_unit_id)
    {
        $access = $this->getRoleAccess(Formula::APPHumanResource);
        $type = $this->generateSlug($slug);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        $areaIDS = $areas->pluck('id')->toArray();
        if ($this->request->ajax()) {
            $data = $this->generateData($slug, $areaIDS);
            return $this->basicDataTables($data);
        }
        return view('admin.facility-menu.human-resource.index')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'type' => $type,
            'slug' => $slug,
            'access' => $access,
        ]);
    }

    private $rule = [
        'area' => 'required',
        'name' => 'required',
        'birth_place' => 'required',
        'date_of_birth' => 'required',
        'identity_number' => 'required',
        'certification_unit' => 'required',
        'certification_number' => 'required',
        'expired_date' => 'required',
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'name.required' => 'kolom nama wajib di isi',
        'birth_place.required' => 'kolom tempat lahir wajib di isi',
        'date_of_birth.required' => 'kolom tanggal lahir wajib di isi',
        'identity_number.required' => 'kolom nomor identitas wajib di isi',
        'certification_unit.required' => 'kolom unit pengajuan sertifikasi wajib di isi',
        'certification_number.required' => 'kolom kodefikasi sertifikat wajib di isi',
        'expired_date.required' => 'kolom tanggal habis masa berlaku wajib di isi',
    ];

    public function store($slug, $service_unit_id)
    {
        $access = $this->getRoleAccess(Formula::APPHumanResource);
        if (!$access['is_granted_create']) {
            abort(403);
        }
        $type = $this->generateSlug($slug);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();

        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'name' => $this->postField('name'),
                    'birth_place' => $this->postField('birth_place'),
                    'date_of_birth' => Carbon::createFromFormat('d-m-Y', $this->postField('date_of_birth'))->format('Y-m-d'),
                    'identity_number' => $this->postField('identity_number'),
                    'type' => $slug,
                    'certification_unit' => $this->postField('certification_unit'),
                    'certification_number' => $this->postField('certification_number'),
                    'expired_date' => $this->postField('expired_date') !== '' ? Carbon::createFromFormat('d-m-Y', $this->postField('expired_date'))->format('Y-m-d') : null,
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                HumanResource::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }

        return view('admin.facility-menu.human-resource.add')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'type' => $type,
            'slug' => $slug
        ]);
    }

    public function patch($slug, $service_unit_id, $id)
    {
        $access = $this->getRoleAccess(Formula::APPHumanResource);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $type = $this->generateSlug($slug);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = HumanResource::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'name' => $this->postField('name'),
                    'birth_place' => $this->postField('birth_place'),
                    'date_of_birth' => Carbon::createFromFormat('d-m-Y', $this->postField('date_of_birth'))->format('Y-m-d'),
                    'identity_number' => $this->postField('identity_number'),
                    'type' => $slug,
                    'certification_unit' => $this->postField('certification_unit'),
                    'certification_number' => $this->postField('certification_number'),
                    'expired_date' => $this->postField('expired_date') !== '' ? Carbon::createFromFormat('d-m-Y', $this->postField('expired_date'))->format('Y-m-d') : null,
                    'description' => $this->postField('description'),
                    'updated_by' => auth()->id(),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.human-resource.edit')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'type' => $type,
            'data' => $data,
            'slug' => $slug
        ]);
    }

    public function destroy($slug, $service_unit_id, $id)
    {
        $access = $this->getRoleAccess(Formula::APPHumanResource);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            HumanResource::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($slug, $service_unit_id, $id)
    {
        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            $data = HumanResource::with(['area'])
                ->where('id', '=', $id)
                ->first()->append(['expired_in', 'status']);
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel($slug, $service_unit_id)
    {
        $type = $this->generateSlug($slug);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        $areaIDS = $areas->pluck('id')->toArray();
        $fileName = 'SDM-' . $slug . '-' . date('YmdHis') . '.xlsx';
        $data = $this->generateData($slug, $areaIDS);
        return Excel::download(
            new \App\Exports\HumanResource($data, $type),
            $fileName
        );
    }
}
