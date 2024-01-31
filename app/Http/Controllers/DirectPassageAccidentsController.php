<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\City;
use App\Models\DirectPassage;
use App\Models\DirectPassageAccident;
use App\Models\DirectPassageAccidentImage;
use App\Models\DirectPassageSignEquipment;
use App\Models\ServiceUnit;
use App\Models\SubTrack;
use App\Models\Track;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;

class DirectPassageAccidentsController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function service_unit_page()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.direct-passage-accidents.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    private function generateData($areaIDS)
    {
        $area = $this->request->query->get('area');
        $date = $this->request->query->get('date');
        $direct_passage = $this->request->query->get('direct_passage');
        $query = DirectPassageAccident::with(['direct_passage', 'area', 'track', 'sub_track', 'city']);

        if ($area !== '') {
            $query->where('area_id', '=', $area);
        } else {
            $query->whereIn('area_id', $areaIDS);
        }
        if ($date !== '') {
            $query->whereYear('date', $date);
        }

        if ($direct_passage === '') {
            $query->whereNull('direct_passage_id');
        } else {
            if ($direct_passage !== 'none') {
                $query->where('direct_passage_id', '=', $direct_passage);
            }
        }
        return $query->orderBy('created_at', 'DESC')
            ->get();
    }

    public function index($service_unit_id)
    {
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }
        $access = $this->getRoleAccess(Formula::APPMenuDirectPassageAccident);
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

        $direct_passages = DirectPassage::with(['area'])
            ->whereIn('area_id', $areaIDS)
            ->orderBy('name')->get();
        return view('admin.facility-menu.direct-passage-accidents.index')->with([
            'areas' => $areas,
            'service_unit' => $service_unit,
            'access' => $access,
            'direct_passages' => $direct_passages,
        ]);
    }

    private $rule = [
        'area' => 'required',
        'track' => 'required',
        'sub_track' => 'required',
        'stakes' => 'required',
        'city' => 'required',
        'date' => 'required',
        'time' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'train_name' => 'required',
        'accident_type' => 'required',
        'injured' => 'required',
        'died' => 'required',
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'track.required' => 'kolom lintas wajib di isi',
        'sub_track.required' => 'kolom petak wajib di isi',
        'city.required' => 'kolom kota wajib di isi',
        'stakes.required' => 'kolom km/hm wajib di isi',
        'date.required' => 'kolom tanggal kejadian wajib di isi',
        'time.required' => 'kolom waktu kejadian wajib di isi',
        'latitude.required' => 'kolom latitude wajib di isi',
        'longitude.required' => 'kolom longitude wajib di isi',
        'train_name.required' => 'kolom jenis kereta api wajib di isi',
        'accident_type.required' => 'kolom jenis laka wajib di isi',
        'injured.required' => 'kolom korban luka-luka wajib di isi',
        'died.required' => 'kolom korban meninggal dunia wajib di isi',
    ];

    public function store($service_unit_id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPMenuDirectPassageAccident);
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
                $date = Carbon::createFromFormat('d-m-Y', $this->postField('date'))->format('Y-m-d');
                $time = $this->postField('time');
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'track_id' => $this->postField('track'),
                    'sub_track_id' => $this->postField('sub_track'),
                    'city_id' => $this->postField('city'),
                    'direct_passage_id' => $this->postField('direct_passage') !== '' ? $this->postField('direct_passage') : null,
                    'stakes' => $this->postField('stakes'),
                    'date' => $date . ' ' . $time,
                    'train_name' => $this->postField('train_name'),
                    'accident_type' => $this->postField('accident_type'),
                    'injured' => $this->postField('injured'),
                    'died' => $this->postField('died'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'damaged_description' => $this->postField('damaged_description'),
                    'chronology' => $this->postField('chronology'),
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];

                DirectPassageAccident::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $areaIDS = $areas->pluck('id')->toArray();
        $direct_passages = DirectPassage::with(['area'])
            ->whereIn('area_id', $areaIDS)
            ->orderBy('name')->get();
        $cities = City::with([])->orderBy('name', 'ASC')->get();
        $sub_tracks = SubTrack::with(['track.area'])
//            ->whereHas('track', function ($qt) use ($areaIDS) {
//                /** @var $qt Builder */
//                return $qt->whereIn('area_id', $areaIDS);
//            })
            ->orderBy('name', 'ASC')->get();
        $tracks = Track::with(['area'])
//            ->whereIn('area_id', $areaIDS)
            ->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.direct-passage-accidents.add')->with([
            'areas' => $areas,
            'tracks' => $tracks,
            'sub_tracks' => $sub_tracks,
            'direct_passages' => $direct_passages,
            'cities' => $cities,
            'service_unit' => $service_unit,
        ]);
    }

    public function patch($service_unit_id, $id)
    {
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPMenuDirectPassageAccident);
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
        $data = DirectPassageAccident::with([])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $date = Carbon::createFromFormat('d-m-Y', $this->postField('date'))->format('Y-m-d');
                $time = $this->postField('time');
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'track_id' => $this->postField('track'),
                    'sub_track_id' => $this->postField('sub_track'),
                    'city_id' => $this->postField('city'),
                    'direct_passage_id' => $this->postField('direct_passage') !== '' ? $this->postField('direct_passage') : null,
                    'stakes' => $this->postField('stakes'),
                    'date' => $date . ' ' . $time,
                    'train_name' => $this->postField('train_name'),
                    'accident_type' => $this->postField('accident_type'),
                    'injured' => $this->postField('injured'),
                    'died' => $this->postField('died'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'damaged_description' => $this->postField('damaged_description'),
                    'chronology' => $this->postField('chronology'),
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
        $direct_passages = DirectPassage::with(['area'])
            ->whereIn('area_id', $areaIDS)
            ->orderBy('name')->get();
        $cities = City::with([])->orderBy('name', 'ASC')->get();
        $sub_tracks = SubTrack::with(['track.area'])
            ->orderBy('name', 'ASC')->get();
        $tracks = Track::with(['area'])
            ->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.direct-passage-accidents.edit')->with([
            'data' => $data,
            'direct_passages' => $direct_passages,
            'cities' => $cities,
            'service_unit' => $service_unit,
            'tracks' => $tracks,
            'sub_tracks' => $sub_tracks,
            'areas' => $areas,
        ]);
    }

    public function destroy($service_unit_id, $id)
    {
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPMenuDirectPassageAccident);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        DB::beginTransaction();
        try {
            DirectPassageSignEquipment::with(['direct_passage'])->where('direct_passage_id', '=', $id)->delete();
            DirectPassage::destroy($id);
            DB::commit();
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($service_unit_id, $id)
    {
        try {
            $data = DirectPassageAccident::with(['direct_passage', 'area', 'track', 'sub_track', 'city'])
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
        $fileName = 'peristiwa_luar_biasa_hebat_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData($areaIDS);
        return Excel::download(
            new \App\Exports\DirectPassageAccident($data),
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

        $access = $this->getRoleAccess(Formula::APPMenuDirectPassageAccident);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = DirectPassageAccident::with(['images'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                if ($this->request->hasFile('files')) {
                    foreach ($this->request->file('files') as $file) {
                        $extension = $file->getClientOriginalExtension();
                        $document = Uuid::uuid4()->toString() . '.' . $extension;
                        $storage_path = public_path('direct-passage-accident');
                        $documentName = $storage_path . '/' . $document;
                        $dataDocument = [
                            'accident_id' => $data->id,
                            'image' => '/direct-passage-accident/' . $document
                        ];
                        DirectPassageAccidentImage::create($dataDocument);
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
        return view('admin.facility-menu.direct-passage-accidents.image')->with([
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

        $access = $this->getRoleAccess(Formula::APPMenuDirectPassageAccident);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }

        try {
            DirectPassageAccidentImage::destroy($image_id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
