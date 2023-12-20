<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\DisasterArea;
use App\Models\DisasterType;
use App\Models\Resort;
use App\Models\ServiceUnit;
use App\Models\SubTrack;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class DisasterAreaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function service_unit_page()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.disaster-area.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    private function generateData($service_unit_id)
    {
        $resort = $this->request->query->get('resort');
        $location_type = $this->request->query->get('location_type');
        $query = DisasterArea::with(['resort.service_unit', 'sub_track', 'disaster_type']);

        $query->whereHas('resort', function ($qr) use ($service_unit_id) {
            /** @var $qr Builder */
            $qr->where('service_unit_id', '=', $service_unit_id);
        });

        if ($resort !== '') {
            $query->where('resort_id', '=', $resort);
        }

        if ($location_type !== '') {
            $query->where('location_type', '=', $location_type);
        }
        return $query->orderBy('created_at', 'DESC')->get();
    }


    public function index($service_unit_id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        if ($this->request->ajax()) {
            $type = $this->request->query->get('type');
            $data = $this->generateData($service_unit_id);
            switch ($type) {
                case 'map':
                    return $this->jsonSuccessResponse('success', $data);
                case 'table':
                    return $this->basicDataTables($data);
                default:
                    return $this->jsonSuccessResponse('success', []);
            }
        }
        $resorts = Resort::with([])
            ->where('service_unit_id', '=', $service_unit_id)
            ->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.disaster-area.index')->with([
            'resorts' => $resorts,
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
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'resort_id' => $this->postField('resort'),
                    'sub_track_id' => $this->postField('sub_track'),
                    'disaster_type_id' => $this->postField('disaster_type'),
                    'location_type' => $this->postField('location_type'),
                    'block' => $this->postField('block'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'lane' => $this->postField('lane'),
                    'handling' => $this->postField('handling'),
                    'description' => $this->postField('description'),
                ];
                DisasterArea::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $areaIDS = $areas->pluck('id')->toArray();
        $resorts = Resort::with([])
            ->where('service_unit_id', '=', $service_unit_id)
            ->orderBy('name', 'ASC')->get();
        $sub_tracks = SubTrack::with(['track.area'])
            ->whereHas('track', function ($qt) use ($areaIDS) {
                /** @var $qt Builder */
                return $qt->whereIn('area_id', $areaIDS);
            })
            ->orderBy('name')->get();
        $disaster_types = DisasterType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.disaster-area.add')->with([
            'sub_tracks' => $sub_tracks,
            'resorts' => $resorts,
            'disaster_types' => $disaster_types,
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
        $data = DisasterArea::with(['resort.service_unit', 'sub_track', 'disaster_type'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'resort_id' => $this->postField('resort'),
                    'sub_track_id' => $this->postField('sub_track'),
                    'disaster_type_id' => $this->postField('disaster_type'),
                    'location_type' => $this->postField('location_type'),
                    'block' => $this->postField('block'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'lane' => $this->postField('lane'),
                    'handling' => $this->postField('handling'),
                    'description' => $this->postField('description'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $areaIDS = $areas->pluck('id')->toArray();
        $resorts = Resort::with([])
            ->where('service_unit_id', '=', $service_unit_id)
            ->orderBy('name', 'ASC')->get();
        $sub_tracks = SubTrack::with(['track.area'])
            ->whereHas('track', function ($qt) use ($areaIDS) {
                /** @var $qt Builder */
                return $qt->whereIn('area_id', $areaIDS);
            })
            ->orderBy('name')->get();
        $disaster_types = DisasterType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.disaster-area.edit')->with([
            'sub_tracks' => $sub_tracks,
            'resorts' => $resorts,
            'disaster_types' => $disaster_types,
            'service_unit' => $service_unit,
            'data' => $data
        ]);
    }


    public function destroy($service_unit_id, $id)
    {
        try {
            DisasterArea::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($service_unit_id, $id)
    {
        try {
            $data = DisasterArea::with(['resort.service_unit', 'sub_track', 'disaster_type'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function export_to_excel($service_unit_id)
    {
        $fileName = 'daerah_rawan_bencana_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData($service_unit_id);
        return Excel::download(
            new \App\Exports\DisasterArea($data),
            $fileName
        );
    }
}
