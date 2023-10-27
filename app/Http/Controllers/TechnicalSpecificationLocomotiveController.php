<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\FacilityCertification;
use App\Models\FacilityLocomotive;
use App\Models\LocomotiveType;
use App\Models\TechnicalSpecLocomotive;

class TechnicalSpecificationLocomotiveController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = TechnicalSpecLocomotive::with(['facility_locomotive.locomotive_type'])
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.technical-specification.locomotive.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'facility_locomotive_id' => $this->postField('facility_locomotive'),
                    'empty_weight' => $this->postField('empty_weight'),
                    'house_power' => $this->postField('house_power'),
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'fuel_consumption' => $this->postField('fuel_consumption'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'coupler_height' => $this->postField('coupler_height'),
                    'wheel_diameter' => $this->postField('wheel_diameter'),
                ];
                TechnicalSpecLocomotive::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $facility_locomotives = FacilityLocomotive::all();
        return view('admin.technical-specification.locomotive.add')->with([
            'facility_locomotives' => $facility_locomotives,
        ]);
    }

    public function patch($id)
    {
        $data = TechnicalSpecLocomotive::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'facility_locomotive_id' => $this->postField('facility_locomotive'),
                    'empty_weight' => $this->postField('empty_weight'),
                    'house_power' => $this->postField('house_power'),
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'fuel_consumption' => $this->postField('fuel_consumption'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'coupler_height' => $this->postField('coupler_height'),
                    'wheel_diameter' => $this->postField('wheel_diameter'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $facility_locomotives = FacilityLocomotive::all();
        return view('admin.technical-specification.locomotive.edit')->with([
            'data' => $data,
            'facility_locomotives' => $facility_locomotives,
        ]);
    }

    public function destroy($id)
    {
        try {
            TechnicalSpecLocomotive::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
