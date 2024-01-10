<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\CrossingPermission;
use App\Models\ServiceUnit;
use App\Models\SubTrack;
use App\Models\Track;
use App\Models\TrainBridge;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TrainBridgesController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.train-bridges.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    private function generateData($areaIDS)
    {
        $query = TrainBridge::with(['area', 'sub_track', 'track']);
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
                    ->orWhere('corridor', 'LIKE', '%' . $name . '%');
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
        $access = $this->getRoleAccess(Formula::APPTrainBridge);
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
        return view('admin.infrastructure.train-bridges.index')->with([
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
        'corridor' => 'required',
        'reference_number' => 'required',
        'bridge_type' => 'required',
        'building_type' => 'required',
        'span' => 'required',
        'installed_date' => 'required',
        'replaced_date' => 'required',
        'strengthened_date' => 'required',
        'volume' => 'required',
        'bolt' => 'required',
        'bearing' => 'required',
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'track.required' => 'kolom lintas wajib di isi',
        'sub_track.required' => 'kolom petak wajib di isi',
        'stakes.required' => 'kolom km/hm wajib di isi',
        'corridor.required' => 'kolom koridor wajib di isi',
        'reference_number.required' => 'kolom nomor bh wajib di isi',
        'bridge_type.required' => 'kolom jenis jembatan wajib di isi',
        'building_type.required' => 'kolom jenis bangunan wajib di isi',
        'span.required' => 'kolom bentang wajib di isi',
        'installed_date.required' => 'kolom tanggal di pasang wajib di isi',
        'replaced_date.required' => 'kolom di ganti wajib di isi',
        'strengthened_date.required' => 'kolom di perkuat wajib di isi',
        'volume.required' => 'kolom volume wajib di isi',
        'bolt.required' => 'kolom jumlah bantalan wajib di isi',
        'bearing.required' => 'kolom jumlah baut wajib di isi',
    ];

    public function store($service_unit_id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPTrainBridge);
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
                    'corridor' => $this->postField('corridor'),
                    'reference_number' => $this->postField('reference_number'),
                    'bridge_type' => $this->postField('bridge_type'),
                    'building_type' => $this->postField('building_type'),
                    'span' => $this->postField('span'),
                    'installed_date' => $this->postField('installed_date') !== '' ? $this->postField('installed_date') . '-01-01' : null,
                    'replaced_date' => $this->postField('replaced_date') !== '' ? $this->postField('replaced_date') . '-01-01' : null,
                    'strengthened_date' => $this->postField('strengthened_date') !== '' ? $this->postField('strengthened_date') . '-01-01' : null,
                    'volume' => $this->postField('volume'),
                    'bolt' => $this->postField('bolt'),
                    'bearing' => $this->postField('bearing'),
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                TrainBridge::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $sub_tracks = SubTrack::with(['track.area'])
            ->orderBy('name', 'ASC')->get();
        $tracks = Track::with(['area'])
            ->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.train-bridges.add')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'tracks' => $tracks,
            'sub_tracks' => $sub_tracks,
        ]);
    }

    public function patch($service_unit_id, $id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPTrainBridge);
        if (!$access['is_granted_update']) {
            abort(403);
        }

        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = TrainBridge::findOrFail($id);
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
                    'corridor' => $this->postField('corridor'),
                    'reference_number' => $this->postField('reference_number'),
                    'bridge_type' => $this->postField('bridge_type'),
                    'building_type' => $this->postField('building_type'),
                    'span' => $this->postField('span'),
                    'installed_date' => $this->postField('installed_date') !== '' ? $this->postField('installed_date') . '-01-01' : null,
                    'replaced_date' => $this->postField('replaced_date') !== '' ? $this->postField('replaced_date') . '-01-01' : null,
                    'strengthened_date' => $this->postField('strengthened_date') !== '' ? $this->postField('strengthened_date') . '-01-01' : null,
                    'volume' => $this->postField('volume'),
                    'bolt' => $this->postField('bolt'),
                    'bearing' => $this->postField('bearing'),
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
        return view('admin.infrastructure.train-bridges.edit')->with([
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

        $access = $this->getRoleAccess(Formula::APPTrainBridge);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            TrainBridge::destroy($id);
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
            $data = TrainBridge::with(['area', 'sub_track', 'track'])
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
        $fileName = 'train_bridges_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData($areaIDS);
        return Excel::download(
            new \App\Exports\TrainBridge($data),
            $fileName
        );
    }
}
