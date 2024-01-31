<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\District;
use App\Models\MaterialTool;
use App\Models\MaterialToolImage;
use App\Models\RailwayStation;
use App\Models\Resort;
use App\Models\ServiceUnit;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;

class MaterialToolController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.material-tool.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    private  function generateData($areaIDS) {
        $query = MaterialTool::with(['area', 'resort']);
        $area = $this->request->query->get('area');
        $name = $this->request->query->get('name');
        if ($area !== '') {
            $query->where('area_id', '=', $area);
        } else {
            $query->whereIn('area_id', $areaIDS);
        }

        if ($name !== '') {
            $query->where(function ($q) use ($name) {
                /** @var $q Builder */
                $q->where('type', 'LIKE', '%' . $name . '%');
            });
        }

        return $query
            ->orderBy('created_at', 'DESC')
            ->get();
    }
    public function main_page($service_unit_id)
    {
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }
        $access = $this->getRoleAccess(Formula::APPMenuMaterialTool);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        $areaIDS = $areas->pluck('id')->toArray();
        if ($this->request->ajax()) {
            $type = $this->request->query->get('type');
            $data = $this->generateData($areaIDS);
            switch ($type) {
                case 'map':
                    return $this->jsonSuccessResponse('success', $data);
                case 'table':
                    return $this->basicDataTables($data);
                default:
                    return $this->jsonSuccessResponse('success', []);
            }
        }
        return view('admin.facility-menu.material-tool.index')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'access' => $access,
        ]);
    }

    private $rule = [
        'area' => 'required',
        'stakes' => 'required',
        'resort' => 'required',
        'type' => 'required',
        'qty' => 'required',
        'unit' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'stakes.required' => 'kolom km/hm wajib di isi',
        'resort.required' => 'kolom resort wajib di isi',
        'type.required' => 'kolom jenis amus wajib di isi',
        'latitude.required' => 'kolom latitude wajib di isi',
        'longitude.required' => 'kolom longitude wajib di isi',
        'qty.required' => 'kolom jumlah wajib di isi',
        'unit.required' => 'kolom satuan wajib di isi',
    ];

    public function store($service_unit_id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPMenuMaterialTool);
        if (!$access['is_granted_create']) {
            abort(403);
        }
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
                    'resort_id' => $this->postField('resort'),
                    'type' => $this->postField('type'),
                    'qty' => $this->postField('qty'),
                    'unit' => $this->postField('unit'),
                    'description' => $this->postField('description'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'stakes' => $this->postField('stakes'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                MaterialTool::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }

        $resorts = Resort::with([])->where('service_unit_id', '=', $service_unit_id)->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.material-tool.add')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'resorts' => $resorts,
        ]);
    }

    public function patch($service_unit_id, $id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPMenuMaterialTool);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = MaterialTool::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'resort_id' => $this->postField('resort'),
                    'type' => $this->postField('type'),
                    'qty' => $this->postField('qty'),
                    'unit' => $this->postField('unit'),
                    'description' => $this->postField('description'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'stakes' => $this->postField('stakes'),
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
        $resorts = Resort::with([])->where('service_unit_id', '=', $service_unit_id)->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.material-tool.edit')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'resorts' => $resorts,
            'data' => $data,
        ]);
    }

    public function destroy($service_unit_id, $id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPMenuMaterialTool);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            MaterialTool::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($service_unit_id, $id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }
        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            $data = MaterialTool::with(['area', 'resort'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel($service_unit_id)
    {
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        $areaIDS = $areas->pluck('id')->toArray();
        $fileName = 'amus_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData($areaIDS);
        return Excel::download(
            new \App\Exports\MaterialTool($data),
            $fileName
        );
    }

    public function image_page($service_unit_id, $id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPMenuMaterialTool);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = MaterialTool::with(['images'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                if ($this->request->hasFile('files')) {
                    foreach ($this->request->file('files') as $file) {
                        $extension = $file->getClientOriginalExtension();
                        $document = Uuid::uuid4()->toString() . '.' . $extension;
                        $storage_path = public_path('material-tool');
                        $documentName = $storage_path . '/' . $document;
                        $dataDocument = [
                            'material_tool_id' => $data->id,
                            'image' => '/material-tool/' . $document
                        ];
                        MaterialToolImage::create($dataDocument);
                        $file->move($storage_path, $documentName);
                    }
                    DB::commit();
                    return $this->jsonSuccessResponse('success');
                } else {
                    DB::rollBack();
                    return $this->jsonBadRequestResponse('no image attached...');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->jsonErrorResponse('internal server error');
            }
        }
        return view('admin.facility-menu.material-tool.image')->with([
            'data' => $data,
            'service_unit' => $service_unit,
            'access' => $access,
        ]);
    }

    public function destroy_image($service_unit_id, $id, $image_id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPMenuMaterialTool);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }

        try {
            MaterialToolImage::destroy($image_id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
