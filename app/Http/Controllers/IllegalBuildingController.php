<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\City;
use App\Models\DirectPassage;
use App\Models\DirectPassageSignEquipment;
use App\Models\District;
use App\Models\IllegalBuilding;
use App\Models\SubTrack;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class IllegalBuildingController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = IllegalBuilding::with(['sub_track.track.area', 'district.city'])->orderBy('created_at', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.illegal-building.index');
    }

    public function store()
    {

        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'sub_track_id' => $this->postField('sub_track'),
                    'district_id' => $this->postField('district'),
                    'stakes' => $this->postField('stakes'),
                    'surface_area' => $this->postField('surface_area'),
                    'building_area' => $this->postField('building_area'),
                    'distance_from_rail' => $this->postField('distance_from_rail'),
                    'illegal_building' => $this->postField('illegal_building'),
                    'demolished' => $this->postField('demolished'),
                ];
                IllegalBuilding::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $sub_tracks = SubTrack::all();
        $districts = District::all();
        return view('admin.illegal-building.add')->with([
            'sub_tracks' => $sub_tracks,
            'districts' => $districts
        ]);
    }

    public function patch($id)
    {
        $data = IllegalBuilding::with(['sub_track.track.area', 'district.city'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'sub_track_id' => $this->postField('sub_track'),
                    'district_id' => $this->postField('district'),
                    'stakes' => $this->postField('stakes'),
                    'surface_area' => $this->postField('surface_area'),
                    'building_area' => $this->postField('building_area'),
                    'distance_from_rail' => $this->postField('distance_from_rail'),
                    'illegal_building' => $this->postField('illegal_building'),
                    'demolished' => $this->postField('demolished'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $sub_tracks = SubTrack::all();
        $districts = District::all();
        return view('admin.illegal-building.edit')->with([
            'data' => $data,
            'sub_tracks' => $sub_tracks,
            'districts' => $districts
        ]);
    }

    public function destroy($id)
    {
        try {
            IllegalBuilding::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $data = IllegalBuilding::with(['sub_track.track.area', 'district.city'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel()
    {
        $fileName = 'bangunan_liar_' . date('YmdHis') . '.xlsx';
        $illegal_buildings = IllegalBuilding::with(['sub_track.track.area', 'district.city'])->get();
        return Excel::download(
            new \App\Exports\IllegalBuilding($illegal_buildings),
            $fileName
        );
    }
}
