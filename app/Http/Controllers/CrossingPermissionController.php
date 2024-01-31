<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\CrossingBridge;
use App\Models\CrossingPermission;
use App\Models\ServiceUnit;
use App\Models\SubTrack;
use App\Models\Track;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CrossingPermissionController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.crossing-permission.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    private function generateData($areaIDS)
    {
        $query = CrossingPermission::with(['area', 'sub_track', 'track']);
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
                $q->where('stakes', 'LIKE', '%' . $name . '%')
                    ->orWhere('decree_number', 'LIKE', '%' . $name . '%');
            });
        }

        $data = $query
            ->orderBy('created_at', 'DESC')
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

    public function main_page($service_unit_id)
    {
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }
        $access = $this->getRoleAccess(Formula::APPCrossingPermission);

        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        $areaIDS = $areas->pluck('id')->toArray();
        if ($this->request->ajax()) {
            $data = $this->generateData($areaIDS);
            return $this->basicDataTables($data);
        }
        return view('admin.infrastructure.crossing-permission.index')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'access' => $access,
        ]);
    }

    private $rule = [
        'area' => 'required',
        'track' => 'required',
        'sub_track' => 'required',
        'stakes' => 'required',
        'decree_number' => 'required',
        'decree_date' => 'required',
        'intersection' => 'required',
        'building_type' => 'required',
        'agency' => 'required',
        'expired_date' => 'required',
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'track.required' => 'kolom lintas wajib di isi',
        'sub_track.required' => 'kolom petak wajib di isi',
        'stakes.required' => 'kolom km/hm wajib di isi',
        'decree_number.required' => 'kolom nomor SK wajib di isi',
        'decree_date.required' => 'kolom tanggal SK wajib di isi',
        'intersection.required' => 'kolom jenis perpotongan / persinggungan wajib di isi',
        'building_type.required' => 'kolom jenis bangunan wajib di isi',
        'agency.required' => 'kolom badan hukum / instansi wajib di isi',
        'expired_date.required' => 'kolom tanggal habis masa berlaku wajib di isi',
    ];

    public function store($service_unit_id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPCrossingPermission);
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
        $areaIDS = $areas->pluck('id')->toArray();

        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'track_id' => $this->postField('track'),
                    'sub_track_id' => $this->postField('sub_track'),
                    'stakes' => $this->postField('stakes'),
                    'decree_number' => $this->postField('decree_number'),
                    'decree_date' => Carbon::createFromFormat('d-m-Y', $this->postField('decree_date'))->format('Y-m-d'),
                    'intersection' => $this->postField('intersection'),
                    'building_type' => $this->postField('building_type'),
                    'agency' => $this->postField('agency'),
                    'expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('expired_date'))->format('Y-m-d'),
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                CrossingPermission::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $sub_tracks = SubTrack::with(['track.area'])
            ->orderBy('name', 'ASC')->get();
        $tracks = Track::with(['area'])
            ->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.crossing-permission.add')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'tracks' => $tracks,
            'sub_tracks' => $sub_tracks,
        ]);
    }

    public function patch($service_unit_id, $id)
    {
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPCrossingPermission);
        if (!$access['is_granted_update']) {
            abort(403);
        }

        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = CrossingPermission::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'track_id' => $this->postField('track'),
                    'sub_track_id' => $this->postField('sub_track'),
                    'stakes' => $this->postField('stakes'),
                    'decree_number' => $this->postField('decree_number'),
                    'decree_date' => Carbon::createFromFormat('d-m-Y', $this->postField('decree_date'))->format('Y-m-d'),
                    'intersection' => $this->postField('intersection'),
                    'building_type' => $this->postField('building_type'),
                    'agency' => $this->postField('agency'),
                    'expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('expired_date'))->format('Y-m-d'),
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
        $areaIDS = $areas->pluck('id')->toArray();
        $sub_tracks = SubTrack::with(['track.area'])
            ->orderBy('name', 'ASC')->get();
        $tracks = Track::with(['area'])
            ->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.crossing-permission.edit')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'tracks' => $tracks,
            'sub_tracks' => $sub_tracks,
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

        $access = $this->getRoleAccess(Formula::APPCrossingPermission);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            CrossingPermission::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($service_unit_id, $id)
    {
        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            $data = CrossingPermission::with(['area', 'sub_track', 'track'])
                ->where('id', '=', $id)
                ->first()->append(['expired_in', 'status']);
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
        $fileName = 'permintaan_izin_melintas_rel_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData($areaIDS);
        return Excel::download(
            new \App\Exports\CrossingPermission($data),
            $fileName
        );
    }
}
