<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\ServiceUnit;
use App\Models\Storehouse;

class AreaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $type = $this->request->query->get('type');
            $data = Area::with(['service_unit:id,name'])->orderBy('created_at', 'ASC')->get();
            switch ($type) {
                case 'map':
                    return $this->jsonSuccessResponse('success', $data);
                case 'table':
                    return $this->basicDataTables($data);

                default:
                    return $this->jsonSuccessResponse('success', []);
            }
        }
        return view('admin.master.area.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'service_unit_id' => $this->postField('service_unit'),
                    'name' => $this->postField('name'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                ];
                Area::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $service_units = ServiceUnit::all();
        return view('admin.master.area.add')->with(['service_units' => $service_units]);
    }

    public function patch($id)
    {
        $data = Area::with(['service_unit'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'service_unit_id' => $this->postField('service_unit'),
                    'name' => $this->postField('name'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $service_units = ServiceUnit::all();
        return view('admin.master.area.edit')->with([
            'data' => $data,
            'service_units' => $service_units
        ]);
    }

    public function destroy($id)
    {
        try {
            Area::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function getStorehouseByAreaID($id)
    {
        try {
            $type = $this->request->query->get('type') ?? 1;
            $data = Storehouse::with(['storehouse_type', 'area'])
                ->where('area_id', '=', $id)
                ->where('storehouse_type_id', '=', $type)
                ->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
