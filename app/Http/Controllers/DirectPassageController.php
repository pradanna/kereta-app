<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\City;
use App\Models\DirectPassage;
use App\Models\SubTrack;
use Illuminate\Support\Facades\DB;

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
                DB::commit();
                return redirect()->route('direct-passage');
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $sub_tracks = SubTrack::all();
        $cities = City::all();
        return view('admin.direct-passage.add')->with(['sub_tracks' => $sub_tracks, 'cities' => $cities]);
    }
}
