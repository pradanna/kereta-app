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
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $facility_wagons = FacilityWagon::with(['wagon_sub_type.wagon_type'])->get();
        return view('admin.technical-specification.wagon.add')->with([
            'facility_wagons' => $facility_wagons,
        ]);
    }

    public function patch($id)
    {
        $data = TechnicalSpecWagon::findOrFail($id);
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
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $facility_wagons = FacilityWagon::with(['wagon_sub_type.wagon_type'])->get();
        return view('admin.technical-specification.wagon.edit')->with([
            'data' => $data,
            'facility_wagons' => $facility_wagons,
        ]);
    }

    public function destroy($id)
    {
        try {
            TechnicalSpecWagon::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $data = TechnicalSpecWagon::with(['facility_wagon.wagon_sub_type.wagon_type'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
