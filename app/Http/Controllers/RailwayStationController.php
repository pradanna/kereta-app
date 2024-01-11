<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\District;
use App\Models\RailwayStation;
use App\Models\SafetyAssessment;
use App\Models\ServiceUnit;
use App\Models\SubTrack;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class RailwayStationController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.traffic.railway-station.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    private function generateData($areaIDS)
    {
        $query = RailwayStation::with(['area', 'district.city.province']);
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
                $q->where('name', 'LIKE', '%' . $name . '%')
                    ->orWhere('nickname', 'LIKE', '%' . $name . '%');
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
        $access = $this->getRoleAccess(Formula::APPRailwayStation);

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
        return view('admin.traffic.railway-station.index')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'access' => $access,
        ]);
    }

    private $rule = [
        'area' => 'required',
        'district' => 'required',
        'stakes' => 'required',
        'name' => 'required',
        'nickname' => 'required',
        'height' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'type' => 'required',
        'status' => 'required',
        'station_class' => 'required'
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'district.required' => 'kolom kecamatan wajib di isi',
        'stakes.required' => 'kolom km/hm wajib di isi',
        'name.required' => 'kolom nama stasiun wajib di isi',
        'nickname.required' => 'kolom singkatan wajib di isi',
        'height.required' => 'kolom ketinggian wajib di isi',
        'latitude.required' => 'kolom latitude wajib di isi',
        'longitude.required' => 'kolom longitude wajib di isi',
        'type.required' => 'kolom jenis stasiun wajib di isi',
        'status.required' => 'kolom status wajib di isi',
        'station_class.required' => 'kolom kelas stasiun wajib di isi'
    ];

    public function store($service_unit_id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPRailwayStation);
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
                    'area_id'  => $this->postField('area'),
                    'district_id' => $this->postField('district'),
                    'name'  => $this->postField('name'),
                    'nickname'  => $this->postField('nickname'),
                    'stakes'  => $this->postField('stakes'),
                    'height'  => $this->postField('height'),
                    'latitude'  => $this->postField('latitude'),
                    'longitude'  => $this->postField('longitude'),
                    'type'  => $this->postField('type'),
                    'status'  => $this->postField('status'),
                    'station_class' => $this->postField('station_class'),
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                RailwayStation::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }

        $districts = District::with([])->orderBy('name', 'ASC')->get();
        return view('admin.traffic.railway-station.add')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'districts' => $districts,
        ]);
    }

    public function patch($service_unit_id, $id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPRailwayStation);
        if (!$access['is_granted_update']) {
            abort(403);
        }

        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = RailwayStation::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'area_id'  => $this->postField('area'),
                    'district_id' => $this->postField('district'),
                    'name'  => $this->postField('name'),
                    'nickname'  => $this->postField('nickname'),
                    'stakes'  => $this->postField('stakes'),
                    'height'  => $this->postField('height'),
                    'latitude'  => $this->postField('latitude'),
                    'longitude'  => $this->postField('longitude'),
                    'type'  => $this->postField('type'),
                    'status'  => $this->postField('status'),
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
        $districts = District::with([])->orderBy('name', 'ASC')->get();
        return view('admin.traffic.railway-station.edit')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'districts' => $districts,
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

        $access = $this->getRoleAccess(Formula::APPRailwayStation);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }

        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            RailwayStation::destroy($id);
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
            $data = RailwayStation::with(['area', 'district.city.province'])
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
        $fileName = 'stasiun_kereta_api_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData($areaIDS);
        return Excel::download(
            new \App\Exports\RailwayStation($data),
            $fileName
        );
    }
}
