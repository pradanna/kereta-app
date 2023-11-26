<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\City;
use App\Models\DirectPassage;
use App\Models\DirectPassageSignEquipment;
use App\Models\District;
use App\Models\IllegalBuilding;
use App\Models\SubTrack;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class IllegalBuildingController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    private function generateData() {
        $service_unit = $this->request->query->get('service_unit');
        $area = $this->request->query->get('area');
        $track = $this->request->query->get('track');

        $query = IllegalBuilding::with(['sub_track.track.area', 'district.city']);

        if ($service_unit !== '' && $service_unit !== null) {
            $query->whereHas('sub_track', function ($qst) use ($service_unit){
                /** @var $qst Builder */
                return $qst->whereHas('track', function ($qt) use ($service_unit){
                    /** @var $qt Builder */
                    return $qt->whereHas('area', function ($qa) use ($service_unit){
                        /** @var $qa Builder */
                        return $qa->where('service_unit_id', '=', $service_unit);
                    });
                });
            });
        }

        if ($area !== '') {
            $query->whereHas('sub_track', function ($qsta) use ($area){
                /** @var $qsta Builder */
                return $qsta->whereHas('track', function ($qta) use ($area){
                    /** @var $qta Builder */
                    return $qta->where('area_id', '=', $area);
                });
            });
        }

        if ($track !== '') {
            $query->whereHas('sub_track', function ($qstt) use ($track){
                /** @var $qstt Builder */
                return $qstt->where('track_id', '=', $track);
            });

        }

        return $query->orderBy('created_at', 'ASC')->get();
    }
    public function index()
    {
        if ($this->request->ajax()) {
            $data = $this->generateData();
            return $this->basicDataTables($data);
        }
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.illegal-building.index')->with([
            'areas' => $areas,
        ]);
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
                    'description' => $this->postField('description'),
                ];
                IllegalBuilding::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $sub_tracks = SubTrack::with(['track.area'])->orderBy('code', 'ASC')->get();
        $districts = District::with([])->orderBy('name', 'ASC')->get();

        return view('admin.illegal-building.add')->with([
            'sub_tracks' => $sub_tracks,
            'districts' => $districts,
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
                    'description' => $this->postField('description'),
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
        $data = $this->generateData();
        return Excel::download(
            new \App\Exports\IllegalBuilding($data),
            $fileName
        );
    }
}
