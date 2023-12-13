<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\DisasterArea;
use App\Models\DisasterType;
use App\Models\ServiceUnit;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Facades\Excel;

class DisasterAreaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    private function generateData()
    {
        $service_unit = $this->request->query->get('service_unit');
        $resort = $this->request->query->get('resort');
        $location_type = $this->request->query->get('location_type');
        $query = DisasterArea::with(['resort.service_unit', 'sub_track', 'disaster_type']);

        if ($service_unit !== '') {
            $query->whereHas('resort', function ($qr) use ($service_unit) {
                /** @var $qr Builder */
                $qr->where('service_unit_id', '=', $service_unit);
            });
        }

        if ($resort !== '') {
            $query->where('resort_id', '=', $resort);
        }

        if ($location_type !== '') {
            $query->where('location_type', '=', $location_type);
        }
        return $query->orderBy('created_at', 'DESC')->get();
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
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.disaster-area.index')->with([
            'service_units' => $service_units
        ]);
    }

    public function store()
    {
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
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        $disaster_types = DisasterType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.disaster-area.add')->with([
            'service_units' => $service_units,
            'disaster_types' => $disaster_types,
        ]);
    }

    public function patch($id)
    {
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
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        $disaster_types = DisasterType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.disaster-area.edit')->with([
            'service_units' => $service_units,
            'disaster_types' => $disaster_types,
            'data' => $data
        ]);
    }


    public function destroy($id)
    {
        try {
            DisasterArea::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($id)
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

    public function export_to_excel()
    {
        $fileName = 'daerah_rawan_bencana_' . date('YmdHis') . '.xlsx';
        $data = $this->generateData();
        return Excel::download(
            new \App\Exports\DisasterArea($data),
            $fileName
        );
    }
}
