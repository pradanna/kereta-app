<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\District;
use App\Models\SafetyAssessment;
use App\Models\ServiceUnit;
use App\Models\SubTrack;
use App\Models\Track;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SafetyAssessmentController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.safety-assessment.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    private function generateData($areaIDS)
    {
        $query = SafetyAssessment::with(['area', 'sub_track', 'track', 'district.city.province']);
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
                $q->where('stakes', 'LIKE', '%' . $name . '%')
                    ->orWhere('recommendation_number', 'LIKE', '%' . $name . '%');
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
        $access = $this->getRoleAccess(Formula::APPSafetyAssessment);
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
        return view('admin.infrastructure.safety-assessment.index')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'access' => $access,
        ]);
    }

    private $rule = [
        'area' => 'required',
        'track' => 'required',
        'sub_track' => 'required',
        'district' => 'required',
        'stakes' => 'required',
        'recommendation_number' => 'required',
        'organizer' => 'required',
        'job_scope' => 'required',
        'follow_up' => 'required',
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'track.required' => 'kolom lintas wajib di isi',
        'sub_track.required' => 'kolom petak wajib di isi',
        'district.required' => 'kolom kecamatan wajib di isi',
        'stakes.required' => 'kolom km/hm wajib di isi',
        'recommendation_number.required' => 'kolom nomor surat rekomendasi wajib di isi',
        'organizer.required' => 'kolom penyelenggara wajib di isi',
        'job_scope.required' => 'kolom ruang lingkup pekerjaan wajib di isi',
        'follow_up.required' => 'kolom rekomendasi tindak lanjut wajib di isi',
    ];

    public function store($service_unit_id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPSafetyAssessment);
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
                    'district_id' => $this->postField('district'),
                    'stakes' => $this->postField('stakes'),
                    'recommendation_number' => $this->postField('recommendation_number'),
                    'organizer' => $this->postField('organizer'),
                    'description' => $this->postField('description'),
                    'job_scope' => $this->postField('job_scope'),
                    'follow_up' => $this->postField('follow_up'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                SafetyAssessment::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $sub_tracks = SubTrack::with(['track.area'])
            ->orderBy('name', 'ASC')->get();
        $tracks = Track::with(['area'])
            ->orderBy('name', 'ASC')->get();
        $districts = District::with([])->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.safety-assessment.add')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'tracks' => $tracks,
            'sub_tracks' => $sub_tracks,
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

        $access = $this->getRoleAccess(Formula::APPSafetyAssessment);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = SafetyAssessment::findOrFail($id);
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
                    'district_id' => $this->postField('district'),
                    'stakes' => $this->postField('stakes'),
                    'recommendation_number' => $this->postField('recommendation_number'),
                    'organizer' => $this->postField('organizer'),
                    'description' => $this->postField('description'),
                    'job_scope' => $this->postField('job_scope'),
                    'follow_up' => $this->postField('follow_up'),
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
        $sub_tracks = SubTrack::with(['track.area'])
            ->orderBy('name', 'ASC')->get();
        $tracks = Track::with(['area'])
            ->orderBy('name', 'ASC')->get();
        $districts = District::with([])->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.safety-assessment.edit')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'tracks' => $tracks,
            'sub_tracks' => $sub_tracks,
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

        $access = $this->getRoleAccess(Formula::APPSafetyAssessment);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            SafetyAssessment::destroy($id);
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
            $data = SafetyAssessment::with(['area', 'sub_track', 'track', 'district.city.province'])
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
        $fileName = 'safety_assessment_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData($areaIDS);
        return Excel::download(
            new \App\Exports\SafetyAssessment($data),
            $fileName
        );
    }
}
