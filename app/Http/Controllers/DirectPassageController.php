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
use App\Models\Storehouse;
use App\Models\StorehouseImage;
use App\Models\SubTrack;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;

class DirectPassageController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
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

        if ($track !== '') {
            $query->whereHas('sub_track', function ($qstt) use ($track) {
                /** @var $qstt Builder */
                return $qstt->where('track_id', '=', $track);
            });

        }

        return $query->orderBy('created_at', 'ASC')
            ->get()->append(['count_guard', 'count_accident']);
    }

    public function index()
    {
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
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.direct-passage.index')->with([
            'areas' => $areas,
        ]);
    }

    public function store()
    {

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
//                    'is_underpass' => false,
                    'arrangement_proposal' => false,
                    'accident_history' => $this->postField('accident_history'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'description' => $this->postField('description'),
                    'technical_documentation' => $this->postField('technical_documentation'),
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
                dd($e->getMessage());
                DB::rollBack();
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $sub_tracks = SubTrack::with(['track.area'])->orderBy('name')->get();
        $cities = City::with([])->orderBy('name', 'ASC')->get();
        return view('admin.direct-passage.add')->with(['sub_tracks' => $sub_tracks, 'cities' => $cities]);
    }

    public function patch($id)
    {
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
//                    'is_underpass' => false,
                    'arrangement_proposal' => false,
                    'accident_history' => $this->postField('accident_history'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'description' => $this->postField('description'),
                    'technical_documentation' => $this->postField('technical_documentation'),
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
        $sub_tracks = SubTrack::with(['track.area'])->orderBy('name')->get();
        $cities = City::all();
        return view('admin.direct-passage.edit')->with([
            'data' => $data,
            'sub_tracks' => $sub_tracks,
            'cities' => $cities,
        ]);
    }

    public function destroy($id)
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

    public function detail($id)
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

    public function image_page($id)
    {
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
        return view('admin.direct-passage.image')->with([
            'data' => $data
        ]);
    }

    public function destroy_image($id)
    {
        try {
            DirectPassageImage::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function direct_passage_guard_page($id)
    {
        $data = DirectPassage::with(['direct_passage_guard.human_resource'])
            ->findOrFail($id)->append(['count_guard']);
        if ($this->request->ajax()) {
            return $this->basicDataTables($data->direct_passage_guard->toArray());
        }
        return view('admin.direct-passage.guard')->with(['data' => $data]);
    }

    public function direct_passage_accident_page($id)
    {
        $data = DirectPassage::with([])
            ->findOrFail($id);
        return view('admin.direct-passage.accidents')->with([
            'data' => $data
        ]);
    }
}
