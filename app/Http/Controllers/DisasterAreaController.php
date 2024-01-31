<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\DisasterArea;
use App\Models\DisasterAreaImage;
use App\Models\DisasterType;
use App\Models\Resort;
use App\Models\ServiceUnit;
use App\Models\SubTrack;
use App\Models\Track;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;

class DisasterAreaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function service_unit_page()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.disaster-area.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    private function generateData($service_unit_id)
    {
        $resort = $this->request->query->get('resort');
        $location_type = $this->request->query->get('location_type');
        $query = DisasterArea::with(['resort.service_unit', 'sub_track', 'area', 'track', 'disaster_type']);

        $query->whereHas('resort', function ($qr) use ($service_unit_id) {
            /** @var $qr Builder */
            $qr->where('service_unit_id', '=', $service_unit_id);
        });

        if ($resort !== '') {
            $query->where('resort_id', '=', $resort);
        }

        if ($location_type !== '') {
            $query->where('location_type', '=', $location_type);
        }
        return $query->orderBy('created_at', 'DESC')->get();
    }


    public function index($service_unit_id)
    {
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $access = $this->getRoleAccess(Formula::APPMenuDisasterArea);
        if ($this->request->ajax()) {
            $type = $this->request->query->get('type');
            $data = $this->generateData($service_unit_id);
            switch ($type) {
                case 'map':
                    return $this->jsonSuccessResponse('success', $data);
                case 'table':
                    return $this->basicDataTables($data);
                default:
                    return $this->jsonSuccessResponse('success', []);
            }
        }
        $resorts = Resort::with([])
            ->where('service_unit_id', '=', $service_unit_id)
            ->orderBy('name', 'ASC')->get();
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.disaster-area.index')->with([
            'resorts' => $resorts,
            'service_unit' => $service_unit,
            'access' => $access,
            'areas' => $areas,
        ]);
    }

    private $rule = [
        'area' => 'required',
        'track' => 'required',
        'sub_track' => 'required',
        'resort' => 'required',
        'location_type' => 'required',
        'disaster_type' => 'required',
        'block' => 'required',
        'lane' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'track.required' => 'kolom lintas wajib di isi',
        'sub_track.required' => 'kolom petak wajib di isi',
        'resort.required' => 'kolom resort wajib di isi',
        'location_type.required' => 'kolom lokasi wajib di isi',
        'disaster_type.required' => 'kolom jenis rawan wajib di isi',
        'block.required' => 'kolom km/hm wajib di isi',
        'lane.required' => 'kolom jalur wajib di isi',
        'latitude.required' => 'kolom latitude wajib di isi',
        'longitude.required' => 'kolom longitude wajib di isi',
    ];

    public function store($service_unit_id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::AppMenuDirectPassage);
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
                    'resort_id' => $this->postField('resort'),
                    'area_id' => $this->postField('area'),
                    'track_id' => $this->postField('track'),
                    'sub_track_id' => $this->postField('sub_track'),
                    'disaster_type_id' => $this->postField('disaster_type'),
                    'location_type' => $this->postField('location_type'),
                    'block' => $this->postField('block'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'lane' => $this->postField('lane'),
                    'handling' => $this->postField('handling'),
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                DisasterArea::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $areaIDS = $areas->pluck('id')->toArray();
        $resorts = Resort::with([])
            ->where('service_unit_id', '=', $service_unit_id)
            ->orderBy('name', 'ASC')->get();
        $sub_tracks = SubTrack::with(['track.area'])
//            ->whereHas('track', function ($qt) use ($areaIDS) {
//                /** @var $qt Builder */
//                return $qt->whereIn('area_id', $areaIDS);
//            })
            ->orderBy('name')->get();

        $tracks = Track::with(['area'])
//            ->whereIn('area_id', $areaIDS)
            ->orderBy('name', 'ASC')->get();
        $disaster_types = DisasterType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.disaster-area.add')->with([
            'areas' => $areas,
            'tracks' => $tracks,
            'sub_tracks' => $sub_tracks,
            'resorts' => $resorts,
            'disaster_types' => $disaster_types,
            'service_unit' => $service_unit,
        ]);
    }

    public function patch($service_unit_id, $id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPMenuDisasterArea);
        if (!$access['is_granted_update']) {
            abort(403);
        }
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        $data = DisasterArea::with(['resort.service_unit', 'sub_track', 'disaster_type'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'resort_id' => $this->postField('resort'),
                    'area_id' => $this->postField('area'),
                    'track_id' => $this->postField('track'),
                    'sub_track_id' => $this->postField('sub_track'),
                    'disaster_type_id' => $this->postField('disaster_type'),
                    'location_type' => $this->postField('location_type'),
                    'block' => $this->postField('block'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'lane' => $this->postField('lane'),
                    'handling' => $this->postField('handling'),
                    'description' => $this->postField('description'),
                    'updated_by' => auth()->id(),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $areaIDS = $areas->pluck('id')->toArray();
        $resorts = Resort::with([])
            ->where('service_unit_id', '=', $service_unit_id)
            ->orderBy('name', 'ASC')->get();
        $sub_tracks = SubTrack::with(['track.area'])
//            ->whereHas('track', function ($qt) use ($areaIDS) {
//                /** @var $qt Builder */
//                return $qt->whereIn('area_id', $areaIDS);
//            })
            ->orderBy('name')->get();
        $tracks = Track::with(['area'])
//            ->whereIn('area_id', $areaIDS)
            ->orderBy('name', 'ASC')->get();
        $disaster_types = DisasterType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.disaster-area.edit')->with([
            'areas' => $areas,
            'tracks' => $tracks,
            'sub_tracks' => $sub_tracks,
            'resorts' => $resorts,
            'disaster_types' => $disaster_types,
            'service_unit' => $service_unit,
            'data' => $data
        ]);
    }


    public function destroy($service_unit_id, $id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPMenuDisasterArea);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            DisasterArea::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($service_unit_id, $id)
    {
        try {
            $data = DisasterArea::with(['resort.service_unit', 'sub_track', 'track', 'area' ,'disaster_type'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel($service_unit_id)
    {
        $fileName = 'daerah_rawan_bencana_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData($service_unit_id);
        return Excel::download(
            new \App\Exports\DisasterArea($data),
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

        $access = $this->getRoleAccess(Formula::APPMenuDisasterArea);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = DisasterArea::with(['images'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                if ($this->request->hasFile('files')) {
                    foreach ($this->request->file('files') as $file) {
                        $extension = $file->getClientOriginalExtension();
                        $document = Uuid::uuid4()->toString() . '.' . $extension;
                        $storage_path = public_path('disaster-area');
                        $documentName = $storage_path . '/' . $document;
                        $dataDocument = [
                            'disaster_area_id' => $data->id,
                            'image' => '/disaster-area/' . $document
                        ];
                        DisasterAreaImage::create($dataDocument);
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
        return view('admin.facility-menu.disaster-area.image')->with([
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

        $access = $this->getRoleAccess(Formula::APPMenuDisasterArea);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            DisasterAreaImage::destroy($image_id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
