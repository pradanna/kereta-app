<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\ServiceUnit;

class AreaController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Area::with(['service_unit:id,name'])->get();
            return $this->basicDataTables($data);
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
                return redirect()->back();
            }
        }
        $service_units = ServiceUnit::all();
        return view('master.area.add')->with(['service_units' => $service_units]);

    }
}
