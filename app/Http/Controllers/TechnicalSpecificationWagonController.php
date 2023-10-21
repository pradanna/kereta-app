<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\FacilityWagon;
use App\Models\TechnicalSpecWagon;

class TechnicalSpecificationWagonController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = TechnicalSpecWagon::with(['facility_wagon.wagon_sub_type.wagon_type'])
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.technical-specification.wagon.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'facility_wagon_id' => $this->postField('facility_wagon'),
                    'loading_weight' => $this->postField('loading_weight'),
                    'empty_weight' => $this->postField('empty_weight'),
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height_from_rail' => $this->postField('height_from_rail'),
                    'axle_load' => $this->postField('axle_load'),
                    'bogie_distance' => $this->postField('bogie_distance'),
                    'usability' => $this->postField('usability'),
                ];
                TechnicalSpecWagon::create($data_request);
                return redirect()->route('technical-specification.wagon');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $facility_wagons = FacilityWagon::with(['wagon_sub_type.wagon_type'])->get();
        return view('admin.technical-specification.wagon.add')->with([
            'facility_wagons' => $facility_wagons,
        ]);
    }
}
