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
        return view('master.area.index');
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
                return redirect()->route('area');
            } catch (\Exception $e) {
                dd($e->getMessage());
                return redirect()->back();
            }
        }
        $service_units = ServiceUnit::all();
        return view('master.area.add')->with(['service_units' => $service_units]);

    }

    public function getStorehouseByAreaID($id)
    {
        try {
            $data = Storehouse::with(['storehouse_type', 'area'])
                ->where('area_id', '=', $id)
                ->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
