<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\City;
use App\Models\DirectPassage;
use App\Models\DirectPassageSignEquipment;
use App\Models\District;
use App\Models\IllegalBuilding;
use App\Models\IllegalBuildingImage;
use App\Models\ServiceUnit;
use App\Models\SubTrack;
use App\Models\Track;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;

class IllegalBuildingController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function service_unit_page()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.illegal-building.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    private function generateData($areaIDS)
    {
        $service_unit = $this->request->query->get('service_unit');
        $area = $this->request->query->get('area');
        $track = $this->request->query->get('track');

        $query = IllegalBuilding::with(['area', 'track', 'sub_track', 'district.city']);

        //        if ($service_unit !== '' && $service_unit !== null) {
        //            $query->whereHas('sub_track', function ($qst) use ($service_unit){
        //                /** @var $qst Builder */
        //                return $qst->whereHas('track', function ($qt) use ($service_unit){
        //                    /** @var $qt Builder */
        //                    return $qt->whereHas('area', function ($qa) use ($service_unit){
        //                        /** @var $qa Builder */
        //                        return $qa->where('service_unit_id', '=', $service_unit);
        //                    });
        //                });
        //            });
        //        }

        if ($area !== '') {
            $query->where('area_id', '=', $area);
        } else {
            $query->whereIn('area_id', $areaIDS);
        }

        //        if ($track !== '') {
        //            $query->whereHas('sub_track', function ($qstt) use ($track){
        //                /** @var $qstt Builder */
        //                return $qstt->where('track_id', '=', $track);
        //            });
        //
        //        }

        return $query->orderBy('created_at', 'ASC')->get();
    }

    public function index($service_unit_id)
    {
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }
        $access = $this->getRoleAccess(Formula::APPMenuIllegalBuilding);
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
        return view('admin.facility-menu.illegal-building.index')->with([
            'areas' => $areas,
            'service_unit' => $service_unit,
            'access' => $access,
        ]);
    }

    private $rule = [
        'area' => 'required',
        'track' => 'required',
        'sub_track' => 'required',
        'district' => 'required',
        'stakes' => 'required',
        'surface_area' => 'required',
        'building_area' => 'required',
        'distance_from_rail' => 'required',
        'illegal_building' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'track.required' => 'kolom lintas wajib di isi',
        'sub_track.required' => 'kolom petak wajib di isi',
        'district.required' => 'kolom kecamatan wajib di isi',
        'stakes.required' => 'kolom km/hm wajib di isi',
        'surface_area.required' => 'kolom luas tanah wajib di isi',
        'building_area.required' => 'kolom luas bangunan wajib di isi',
        'distance_from_rail.required' => 'kolom jarak dari AS rel wajib di isi',
        'illegal_building.required' => 'kolom jumlah bangunan liar wajib di isi',
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

        $access = $this->getRoleAccess(Formula::APPMenuIllegalBuilding);
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
                    'surface_area' => $this->postField('surface_area'),
                    'building_area' => $this->postField('building_area'),
                    'distance_from_rail' => $this->postField('distance_from_rail'),
                    'illegal_building' => $this->postField('illegal_building'),
                    'demolished' => 0,
                    'description' => $this->postField('description'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                IllegalBuilding::create($data_request);
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
        return view('admin.facility-menu.illegal-building.add')->with([
            'areas' => $areas,
            'tracks' => $tracks,
            'sub_tracks' => $sub_tracks,
            'districts' => $districts,
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

        $access = $this->getRoleAccess(Formula::APPMenuIllegalBuilding);
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
        $areaIDS = $areas->pluck('id')->toArray();
        $data = IllegalBuilding::with(['sub_track.track.area', 'district.city'])->findOrFail($id);
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
                    'surface_area' => $this->postField('surface_area'),
                    'building_area' => $this->postField('building_area'),
                    'distance_from_rail' => $this->postField('distance_from_rail'),
                    'illegal_building' => $this->postField('illegal_building'),
                    'demolished' => 0,
                    'description' => $this->postField('description'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'updated_by' => auth()->id(),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $sub_tracks = SubTrack::with(['track.area'])
            ->orderBy('name', 'ASC')->get();
        $tracks = Track::with(['area'])
            ->orderBy('name', 'ASC')->get();
        $districts = District::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.illegal-building.edit')->with([
            'data' => $data,
            'areas' => $areas,
            'tracks' => $tracks,
            'sub_tracks' => $sub_tracks,
            'districts' => $districts,
            'service_unit' => $service_unit,
        ]);
    }

    public function destroy($service_unit_id, $id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPMenuIllegalBuilding);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            IllegalBuilding::destroy($id);
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
            $data = IllegalBuilding::with(['area', 'sub_track', 'track', 'district.city'])
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
        $fileName = 'bangunan_liar_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData($areaIDS);
        return Excel::download(
            new \App\Exports\IllegalBuilding($data),
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

        $access = $this->getRoleAccess(Formula::APPMenuIllegalBuilding);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = IllegalBuilding::with(['images'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                if ($this->request->hasFile('files')) {
                    foreach ($this->request->file('files') as $file) {
                        $extension = $file->getClientOriginalExtension();
                        $document = Uuid::uuid4()->toString() . '.' . $extension;
                        $storage_path = public_path('illegal-building');
                        $documentName = $storage_path . '/' . $document;
                        $dataDocument = [
                            'illegal_building_id' => $data->id,
                            'image' => '/illegal-building/' . $document
                        ];
                        IllegalBuildingImage::create($dataDocument);
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
        return view('admin.facility-menu.illegal-building.image')->with([
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

        $access = $this->getRoleAccess(Formula::APPMenuIllegalBuilding);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }

        try {
            IllegalBuildingImage::destroy($image_id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
