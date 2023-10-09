<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\City;
use App\Models\Storehouse;
use App\Models\StorehouseType;

class StoreHouseController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $type = $this->request->query->get('type');
            $data = Storehouse::with(['storehouse_type', 'area', 'city.province'])->orderBy('created_at', 'ASC')->get();
            switch ($type) {
                case 'map':
                    return $this->jsonSuccessResponse('success', $data);
                case 'table':
                    return $this->basicDataTables($data);
                default:
                    return $this->jsonSuccessResponse('success', []);
            }
        }
        return view('admin.master.storehouse.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'storehouse_type_id' => $this->postField('storehouse_type'),
                    'name' => $this->postField('name'),
                    'city_id' => $this->postField('city'),
                    'area_id' => $this->postField('area'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                ];
                Storehouse::create($data_request);
                return redirect()->route('storehouse');
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
        $storehouse_types = StorehouseType::all();
        $cities = City::all();
        $areas = Area::all();
        return view('admin.master.storehouse.add')->with([
            'storehouse_types' => $storehouse_types,
            'cities' => $cities,
            'areas' => $areas,
        ]);
    }
}
