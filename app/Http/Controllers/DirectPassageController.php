<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\City;
use App\Models\DirectPassage;
use App\Models\DirectPassageImage;
use App\Models\DirectPassageSignEquipment;
use App\Models\FacilityLocomotive;
use App\Models\ServiceUnit;
use App\Models\Storehouse;
use App\Models\StorehouseImage;
use App\Models\SubTrack;
use App\Models\Track;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;

class DirectPassageController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function service_unit_page()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.direct-passage.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }
    private function generateData()
    {
        $service_unit = $this->request->query->get('service_unit');
        $area = $this->request->query->get('area');
        $track = $this->request->query->get('track');
        $query = DirectPassage::with(['sub_track.track.area', 'city', 'sign_equipment']);

        if ($service_unit !== '' && $service_unit !== null) {
            $query->whereHas('sub_track', function ($qst) use ($service_unit) {
                /** @var $qst Builder */
                return $qst->whereHas('track', function ($qt) use ($service_unit) {
                    /** @var $qt Builder */
                    return $qt->whereHas('area', function ($qa) use ($service_unit) {
                        /** @var $qa Builder */
                        return $qa->where('service_unit_id', '=', $service_unit);
                    });
                });
            });
        }

        if ($area !== '') {
            $query->whereHas('sub_track', function ($qsta) use ($area) {
                /** @var $qsta Builder */
                return $qsta->whereHas('track', function ($qta) use ($area) {
                    /** @var $qta Builder */
                    return $qta->where('area_id', '=', $area);
                });
            });
        }

        //        if ($track !== '') {
        //            $query->whereHas('sub_track', function ($qstt) use ($track) {
        //                /** @var $qstt Builder */
        //                return $qstt->where('track_id', '=', $track);
        //            });
        //
        //        }

        return $query->orderBy('created_at', 'ASC')
            ->get()->append(['count_guard', 'count_accident']);
    }

    public function index($service_unit_id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        if ($this->request->ajax()) {
            $type = $this->request->query->get('type');
            $data = $this->generateData();
            switch ($type) {
                case 'map':
                    return $this->jsonSuccessResponse('success', $data);
                case 'table':
                    return $this->basicDataTables($data);
                default:
                    return $this->jsonSuccessResponse('success', []);
            }
        }
        return view('admin.facility-menu.direct-passage.index')->with([
            'areas' => $areas,
            'service_unit' => $service_unit
        ]);
    }

    private $rule = [
        'area' => 'required',
        'track' => 'required',
        'sub_track' => 'required',
        'city' => 'required',
        'name' => 'required',
        'stakes' => 'required',
        'width' => 'required',
        'road_name' => 'required',
        'guarded_by' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'technical_documentation' => 'required',
        'elevation' => 'required',
        'road_class' => 'required',
        'is_closed' => 'required',
    ];

    private $message = [
        'area.required' => 'kolom wilayah wajib di isi',
        'track.required' => 'kolom lintas wajib di isi',
        'sub_track.required' => 'kolom petak wajib di isi',
        'city.required' => 'kolom kota wajib di isi',
        'name.required' => 'kolom nomor jpl wajib di isi',
        'stakes.required' => 'kolom km/hm wajib di isi',
        'width.required' => 'kolom lebar jalan wajib di isi',
        'road_name.required' => 'kolom nama jalan wajib di isi',
        'guarded_by.required' => 'kolom status penjagaan wajib di isi',
        'latitude.required' => 'kolom latitude wajib di isi',
        'longitude.required' => 'kolom longitude wajib di isi',
        'technical_documentation.required' => 'kolom nomor surat rekomendasi teknis wajib di isi',
        'elevation.required' => 'kolom sudut elevasi wajib di isi',
        'road_class.required' => 'kolom kelas jalan wajib di isi',
        'is_closed.required' => 'kolom status jpl wajib di isi',
    ];

    public function store($service_unit_id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request_direct_passage = [
                    'area_id' => $this->postField('area'),
                    'track_id' => $this->postField('track'),
                    'sub_track_id' => $this->postField('sub_track'),
                    'city_id' => $this->postField('city'),
                    'name' => $this->postField('name'),
                    'stakes' => $this->postField('stakes'),
                    'width' => $this->postField('width'),
                    'road_construction' => $this->postField('road_construction'),
                    'road_name' => $this->postField('road_name'),
                    'guarded_by' => $this->postField('guarded_by'),
                    'is_closed' => false,
                    'is_not_found' => false,
                    'arrangement_proposal' => false,
                    'accident_history' => 0,
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'description' => $this->postField('description'),
                    'technical_documentation' => $this->postField('technical_documentation'),
                    'road_class' => $this->postField('road_class'),
                    'elevation' => $this->postField('elevation'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                $direct_passage = DirectPassage::create($data_request_direct_passage);

                $data_request_direct_passage_equipment = [
                    'direct_passage_id' => $direct_passage->id,
                    'locomotive_flute' => $this->postField('locomotive_flute'),
                    'crossing_gate' => $this->postField('crossing_gate'),
                    'non_crossing_gate' => $this->postField('non_crossing_gate'),
                    'warning' => $this->postField('warning'),
                    'critical_distance_450' => $this->postField('critical_distance_450'),
                    'critical_distance_300' => $this->postField('critical_distance_300'),
                    'critical_distance_100' => $this->postField('critical_distance_100'),
                    'stop_sign' => $this->postField('stop_sign'),
                    'vehicle_entry_ban' => $this->postField('vehicle_entry_ban'),
                    'shock_line' => $this->postField('shock_line'),
                ];
                DirectPassageSignEquipment::create($data_request_direct_passage_equipment);
                DB::commit();
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $areaIDS = $areas->pluck('id')->toArray();
        $sub_tracks = SubTrack::with(['track.area'])
            ->whereHas('track', function ($qt) use ($areaIDS) {
                /** @var $qt Builder */
                return $qt->whereIn('area_id', $areaIDS);
            })
            ->orderBy('name', 'ASC')->get();
        $tracks = Track::with(['area'])
            ->whereIn('area_id', $areaIDS)
            ->orderBy('name', 'ASC')->get();

        $cities = City::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.direct-passage.add')->with([
            'areas' => $areas,
            'tracks' => $tracks,
            'sub_tracks' => $sub_tracks,
            'cities' => $cities,
            'service_unit' => $service_unit,
        ]);
    }

    public function patch($service_unit_id, $id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        $data = DirectPassage::with(['sign_equipment'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                $data_request_direct_passage = [
                    'sub_track_id' => $this->postField('sub_track'),
                    'city_id' => $this->postField('city'),
                    'name' => $this->postField('name'),
                    'stakes' => $this->postField('stakes'),
                    'width' => $this->postField('width'),
                    'road_construction' => $this->postField('road_construction'),
                    'road_name' => $this->postField('road_name'),
                    'guarded_by' => $this->postField('guarded_by'),
                    'is_closed' => false,
                    'is_not_found' => false,
                    'arrangement_proposal' => false,
                    'accident_history' => 0,
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'description' => $this->postField('description'),
                    'technical_documentation' => $this->postField('technical_documentation'),
                    'road_class' => $this->postField('road_class'),
                    'elevation' => $this->postField('elevation'),
                ];
                $data->update($data_request_direct_passage);
                $data_request_direct_passage_equipment = [
                    'direct_passage_id' => $data->id,
                    'locomotive_flute' => $this->postField('locomotive_flute'),
                    'crossing_gate' => $this->postField('crossing_gate'),
                    'non_crossing_gate' => $this->postField('non_crossing_gate'),
                    'warning' => $this->postField('warning'),
                    'critical_distance_450' => $this->postField('critical_distance_450'),
                    'critical_distance_300' => $this->postField('critical_distance_300'),
                    'critical_distance_100' => $this->postField('critical_distance_100'),
                    'stop_sign' => $this->postField('stop_sign'),
                    'vehicle_entry_ban' => $this->postField('vehicle_entry_ban'),
                    'shock_line' => $this->postField('shock_line'),
                ];
                $data->sign_equipment->update($data_request_direct_passage_equipment);
                DB::commit();
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $areaIDS = $areas->pluck('id')->toArray();
        $sub_tracks = SubTrack::with(['track.area'])
            ->whereHas('track', function ($qt) use ($areaIDS) {
                /** @var $qt Builder */
                return $qt->whereIn('area_id', $areaIDS);
            })
            ->orderBy('name')->get();
        $cities = City::all();
        return view('admin.facility-menu.direct-passage.edit')->with([
            'data' => $data,
            'sub_tracks' => $sub_tracks,
            'cities' => $cities,
            'service_unit' => $service_unit,
        ]);
    }

    public function destroy($service_unit_id, $id)
    {
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
            $data = DirectPassage::with(['sign_equipment', 'sub_track.track.area', 'city'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel()
    {
        $fileName = 'jalur_perlintasan_langsung_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData();
        return Excel::download(
            new \App\Exports\DirectPassage($data),
            $fileName
        );
    }

    public function image_page($service_unit_id, $id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = DirectPassage::with(['images'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                if ($this->request->hasFile('files')) {
                    foreach ($this->request->file('files') as $file) {
                        $extension = $file->getClientOriginalExtension();
                        $document = Uuid::uuid4()->toString() . '.' . $extension;
                        $storage_path = public_path('direct-passage');
                        $documentName = $storage_path . '/' . $document;
                        $dataDocument = [
                            'direct_passage_id' => $data->id,
                            'image' => '/direct-passage/' . $document
                        ];
                        DirectPassageImage::create($dataDocument);
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
        return view('admin.facility-menu.direct-passage.image')->with([
            'data' => $data,
            'service_unit' => $service_unit,
        ]);
    }

    public function destroy_image($service_unit_id, $id)
    {
        try {
            DirectPassageImage::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function direct_passage_guard_page($service_unit_id, $id)
    {
        $data = DirectPassage::with(['direct_passage_guard.human_resource'])
            ->findOrFail($id)->append(['count_guard']);
        if ($this->request->ajax()) {
            return $this->basicDataTables($data->direct_passage_guard->toArray());
        }
        return view('admin.direct-passage.guard')->with(['data' => $data]);
    }

    public function direct_passage_accident_page($service_unit_id, $id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = DirectPassage::with([])
            ->findOrFail($id);
        return view('admin.facility-menu.direct-passage.dirrect-passage-accident')->with([
            'data' => $data,
            'service_unit' => $service_unit,
        ]);
    }
}
