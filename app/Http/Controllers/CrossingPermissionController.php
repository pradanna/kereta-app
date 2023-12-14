<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\CrossingBridge;
use App\Models\CrossingPermission;
use App\Models\ServiceUnit;
use App\Models\SubTrack;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class CrossingPermissionController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.crossing-permission.service-unit')
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
            $query = CrossingPermission::with(['sub_track.track.area']);
            $area = $this->request->query->get('area');
            $name = $this->request->query->get('name');
            $status = $this->request->query->get('status');
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
                        ->orWhere('decree_number', 'LIKE', '%' . $name . '%');
                });
            }

            $data = $query
                ->orderBy('created_at', 'ASC')
                ->get()->append(['expired_in', 'status']);

            if ($status !== '') {
                if ($status === '1') {
                    $data = $data->where('expired_in', '>', Formula::ExpirationLimit)->values();
                }

                if ($status === '0') {
                    $data = $data->where('expired_in', '<=', Formula::ExpirationLimit)->values();
                }
            }
            return $this->basicDataTables($data);
        }
        return view('admin.infrastructure.crossing-permission.index')->with([
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
                    'stakes' => $this->postField('stakes'),
                    'decree_number' => $this->postField('decree_number'),
                    'decree_date' => Carbon::createFromFormat('d-m-Y', $this->postField('decree_date'))->format('Y-m-d'),
                    'intersection' => $this->postField('intersection'),
                    'building_type' => $this->postField('building_type'),
                    'agency' => $this->postField('agency'),
                    'expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('expired_date'))->format('Y-m-d')
                ];
                CrossingPermission::create($data_request);
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
        return view('admin.infrastructure.crossing-permission.add')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'sub_tracks' => $sub_tracks,
        ]);
    }

    public function patch($service_unit_id, $id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = CrossingPermission::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'sub_track_id' => $this->postField('sub_track'),
                    'stakes' => $this->postField('stakes'),
                    'decree_number' => $this->postField('decree_number'),
                    'decree_date' => Carbon::createFromFormat('d-m-Y', $this->postField('decree_date'))->format('Y-m-d'),
                    'intersection' => $this->postField('intersection'),
                    'building_type' => $this->postField('building_type'),
                    'agency' => $this->postField('agency'),
                    'expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('expired_date'))->format('Y-m-d')
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
        return view('admin.infrastructure.crossing-permission.edit')->with([
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
            CrossingPermission::destroy($id);
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
            $data = CrossingPermission::with(['sub_track.track.area'])
                ->where('id', '=', $id)
                ->first()->append(['expired_in', 'status']);
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
