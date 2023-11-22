<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\City;
use App\Models\Storehouse;
use App\Models\StorehouseType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;

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
            $query = Storehouse::with(['storehouse_type', 'area', 'city.province']);
            $storehouse_type = $this->request->query->get('storehouse_type');
            $area = $this->request->query->get('area');
            if ($storehouse_type !== '') {
                $query->where('storehouse_type_id', '=', $storehouse_type);
            }

            if ($area !== '') {
                $query->where('area_id', '=', $area);
            }
            switch ($type) {
                case 'map':
                    $data = $query->get();
                    return $this->jsonSuccessResponse('success', $data);
                case 'table':
                    $data = $query
                        ->orderBy('created_at', 'ASC')
                        ->get();
                    return $this->basicDataTables($data);
                default:
                    return $this->jsonSuccessResponse('success', []);
            }
        }
        $storehouse_types = StorehouseType::all();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.master.storehouse.index')->with([
            'storehouse_types' => $storehouse_types,
            'areas' => $areas,
        ]);
    }

    private $rule = [
        'storehouse_type' => 'required',
        'name' => 'required',
        'city' => 'required',
        'area' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
    ];

    private $message = [
        'storehouse_type.required' => 'kolom depo wajib di isi',
        'name.required' => 'kolom nama wajib di isi',
        'city.required' => 'kolom kota wajib di isi',
        'area.required' => 'kolom daerah operasi wajib di isi',
        'latitude.required' => 'kolom latitude wajib di isi',
        'longitude.required' => 'kolom longitude wajib di isi',
    ];
    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }
                $data_request = [
                    'storehouse_type_id' => $this->postField('storehouse_type'),
                    'name' => $this->postField('name'),
                    'city_id' => $this->postField('city'),
                    'area_id' => $this->postField('area'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                ];
                Storehouse::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $storehouse_types = StorehouseType::all();
        $cities = City::all();
        $areas = Area::with([])->orderBy('name', 'ASC')->get();
        return view('admin.master.storehouse.add')->with([
            'storehouse_types' => $storehouse_types,
            'cities' => $cities,
            'areas' => $areas,
        ]);
    }

    public function patch($id)
    {
        $data = Storehouse::with(['storehouse_type', 'area', 'city.province'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator);
                }
                $data_request = [
                    'storehouse_type_id' => $this->postField('storehouse_type'),
                    'name' => $this->postField('name'),
                    'city_id' => $this->postField('city'),
                    'area_id' => $this->postField('area'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $storehouse_types = StorehouseType::all();
        $cities = City::all();
        $areas = Area::all();
        return view('admin.master.storehouse.edit')->with([
            'storehouse_types' => $storehouse_types,
            'cities' => $cities,
            'areas' => $areas,
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        try {
            Storehouse::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function getDataByArea()
    {
        try {
            $area = $this->request->query->get('area');
            $service_unit = $this->request->query->get('service_unit');
            $query = Storehouse::with(['area', 'storehouse_type']);

            if ($service_unit !== '' && $service_unit !== null) {
                $query->whereHas('area', function ($qa) use ($service_unit) {
                    /** @var $qa Builder */
                    return $qa->where('service_unit_id', '=', $service_unit);
                });
            }
            if ($area !== '') {
                $query->where('area_id', '=', $area);
            }
            $data = $query->orderBy('created_at', 'ASC')->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
