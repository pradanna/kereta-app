<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\City;
use App\Models\DirectPassage;
use App\Models\DirectPassageSignEquipment;
use App\Models\FacilityLocomotive;
use App\Models\SubTrack;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DirectPassageController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = DirectPassage::with(['sub_track.track.area', 'city'])->orderBy('created_at', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.direct-passage.index');
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
                    'is_underpass' => false,
                    'arrangement_proposal' => false,
                    'accident_history' => $this->postField('accident_history'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'description' => $this->postField('description'),
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
        $sub_tracks = SubTrack::all();
        $cities = City::all();
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
                    'is_underpass' => false,
                    'arrangement_proposal' => false,
                    'accident_history' => $this->postField('accident_history'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'description' => $this->postField('description'),
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
        $sub_tracks = SubTrack::all();
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
        $direct_passages = DirectPassage::with(['sign_equipment', 'sub_track.track.area', 'city'])->get();
        return Excel::download(
            new \App\Exports\DirectPassage($direct_passages),
            $fileName
        );
    }
}
