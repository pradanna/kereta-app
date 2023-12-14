<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\District;
use App\Models\MaterialTool;
use App\Models\RailwayStation;
use App\Models\Resort;
use App\Models\ServiceUnit;
use Illuminate\Database\Eloquent\Builder;

class MaterialToolController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.material-tool.service-unit')
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
            $query = MaterialTool::with(['area', 'resort']);
            $area = $this->request->query->get('area');
            $name = $this->request->query->get('name');
            if ($area !== '') {
                $query->where('area_id', '=', $area);
            } else {
                $areaIDS = $areas->pluck('id')->toArray();
                $query->whereIn('area_id', $areaIDS);
            }

            if ($name !== '') {
                $query->where(function ($q) use ($name) {
                    /** @var $q Builder */
                    $q->where('type', 'LIKE', '%' . $name . '%');
                });
            }

            $data = $query
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.facility-menu.material-tool.index')->with([
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

        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'area_id'  => $this->postField('area'),
                    'resort_id' => $this->postField('resort'),
                    'type' => $this->postField('type'),
                    'qty' => $this->postField('qty'),
                    'unit' => $this->postField('unit'),
                    'description'  => $this->postField('description'),
                ];
                MaterialTool::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }

        $resorts = Resort::with([])->where('service_unit_id', '=', $service_unit_id)->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.material-tool.add')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'resorts' => $resorts,
        ]);
    }

    public function patch($service_unit_id, $id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = MaterialTool::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'area_id'  => $this->postField('area'),
                    'resort_id' => $this->postField('resort'),
                    'type' => $this->postField('type'),
                    'qty' => $this->postField('qty'),
                    'unit' => $this->postField('unit'),
                    'description'  => $this->postField('description'),
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
        $resorts = Resort::with([])->where('service_unit_id', '=', $service_unit_id)->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.material-tool.edit')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'resorts' => $resorts,
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
            MaterialTool::destroy($id);
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
            $data = MaterialTool::with(['area', 'resort'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
