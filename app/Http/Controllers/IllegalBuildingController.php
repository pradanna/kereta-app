<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\City;
use App\Models\DirectPassage;
use App\Models\DirectPassageSignEquipment;
use App\Models\District;
use App\Models\IllegalBuilding;
use App\Models\ServiceUnit;
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

    public function service_unit_page()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.illegal-building.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    private function generateData($areaIDS) {
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
        } else {
            $query->whereHas('sub_track', function ($qsta) use ($areaIDS){
                /** @var $qsta Builder */
                return $qsta->whereHas('track', function ($qta) use ($areaIDS){
                    /** @var $qta Builder */
                    return $qta->whereIn('area_id', $areaIDS);
                });
            });
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
        return view('admin.facility-menu.illegal-building.index')->with([
            'areas' => $areas,
            'service_unit' => $service_unit,
        ]);
    }

    public function store($service_unit_id)
    {
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
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                ];
                IllegalBuilding::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $sub_tracks = SubTrack::with(['track.area'])
            ->whereHas('track', function ($qt) use ($areaIDS) {
                /** @var $qt Builder */
                return $qt->whereIn('area_id', $areaIDS);
            })
            ->orderBy('name')->get();
        $districts = District::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.illegal-building.add')->with([
            'sub_tracks' => $sub_tracks,
            'districts' => $districts,
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
        $areaIDS = $areas->pluck('id')->toArray();
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
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $sub_tracks = SubTrack::with(['track.area'])
            ->whereHas('track', function ($qt) use ($areaIDS) {
                /** @var $qt Builder */
                return $qt->whereIn('area_id', $areaIDS);
            })
            ->orderBy('name')->get();
        $districts = District::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.illegal-building.edit')->with([
            'data' => $data,
            'sub_tracks' => $sub_tracks,
            'districts' => $districts,
            'service_unit' => $service_unit,
        ]);
    }

    public function destroy($service_unit_id, $id)
    {
        try {
            IllegalBuilding::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($service_unit_id, $id)
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
