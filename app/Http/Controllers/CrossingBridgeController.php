<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\CrossingBridge;
use App\Models\District;
use App\Models\SafetyAssessment;
use App\Models\ServiceUnit;
use App\Models\SubTrack;
use Illuminate\Database\Eloquent\Builder;

class CrossingBridgeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.crossing-bridge.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    public function main_page($service_unit_id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        if ($this->request->ajax()) {
            $query = CrossingBridge::with(['sub_track.track.area']);
            $area = $this->request->query->get('area');
            $name = $this->request->query->get('name');
            if ($area !== '') {
                $query->whereHas('sub_track', function ($qst) use ($area) {
                    /** @var $qst Builder */
                    return $qst->whereHas('track', function ($qt) use ($area) {
                        /** @var $qt Builder */
                        return $qt->where('area_id', '=', $area);
                    });
                });
            } else {
                $areaIDS = $areas->pluck('id')->toArray();
                $query->whereHas('sub_track', function ($qst) use ($areaIDS) {
                    /** @var $qst Builder */
                    return $qst->whereHas('track', function ($qt) use ($areaIDS) {
                        /** @var $qt Builder */
                        return $qt->whereIn('area_id', $areaIDS);
                    });
                });
            }

            if ($name !== '') {
                $query->where(function ($q) use ($name) {
                    /** @var $q Builder */
                    $q->where('stakes', 'LIKE', '%' . $name . '%')
                        ->orWhere('recommendation_number', 'LIKE', '%' . $name . '%');
                });
            }

            $data = $query
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.infrastructure.crossing-bridge.index')->with([
            'service_unit' => $service_unit,
            'areas' => $areas
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
                    'recommendation_number' => $this->postField('recommendation_number'),
                    'responsible_person' => $this->postField('responsible_person'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'road_class' => $this->postField('road_class'),
                    'description' => $this->postField('description'),
                ];
                CrossingBridge::create($data_request);
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
            ->orderBy('name', 'ASC')->get();
//        $districts = District::with([])->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.crossing-bridge.add')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'sub_tracks' => $sub_tracks,
//            'districts' => $districts,
        ]);
    }

    public function patch($service_unit_id, $id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = CrossingBridge::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'sub_track_id' => $this->postField('sub_track'),
                    'district_id' => $this->postField('district'),
                    'stakes' => $this->postField('stakes'),
                    'recommendation_number' => $this->postField('recommendation_number'),
                    'responsible_person' => $this->postField('responsible_person'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'road_class' => $this->postField('road_class'),
                    'description' => $this->postField('description'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        $areaIDS = $areas->pluck('id')->toArray();
        $sub_tracks = SubTrack::with(['track.area'])
            ->whereHas('track', function ($qt) use ($areaIDS) {
                /** @var $qt Builder */
                return $qt->whereIn('area_id', $areaIDS);
            })
            ->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.crossing-bridge.edit')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'sub_tracks' => $sub_tracks,
            'data' => $data,
        ]);
    }

    public function destroy($service_unit_id, $id)
    {
        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            CrossingBridge::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($service_unit_id, $id)
    {
        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            $data = CrossingBridge::with(['sub_track.track.area'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
