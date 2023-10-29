<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\FacilityTrain;
use App\Models\TechnicalSpecTrain;

class TechnicalSpecificationTrainController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = TechnicalSpecTrain::with(['facility_train.train_type'])
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.technical-specification.train.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'facility_train_id' => $this->postField('facility_train'),
                    'empty_weight' => $this->postField('empty_weight') ,
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'passenger_capacity' => $this->postField('passenger_capacity'),
                    'air_conditioner' => $this->postField('air_conditioner'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'coupler_height' => $this->postField('coupler_height'),
                    'axle_load' => $this->postField('axle_load'),
                    'spoor_width' => $this->postField('spoor_width'),
                ];
                TechnicalSpecTrain::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $facility_trains = FacilityTrain::with(['train_type'])->get();
        return view('admin.technical-specification.train.add')->with([
            'facility_trains' => $facility_trains,
        ]);
    }

    public function patch($id)
    {
        $data = TechnicalSpecTrain::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'facility_train_id' => $this->postField('facility_train'),
                    'empty_weight' => $this->postField('empty_weight') ,
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'passenger_capacity' => $this->postField('passenger_capacity'),
                    'air_conditioner' => $this->postField('air_conditioner'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'coupler_height' => $this->postField('coupler_height'),
                    'axle_load' => $this->postField('axle_load'),
                    'spoor_width' => $this->postField('spoor_width'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $facility_trains = FacilityTrain::with(['train_type'])->get();
        return view('admin.technical-specification.train.edit')->with([
            'data' => $data,
            'facility_trains' => $facility_trains,
        ]);
    }

    public function destroy($id)
    {
        try {
            TechnicalSpecTrain::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($id)
    {
        try {
            $data = TechnicalSpecTrain::with(['facility_train.train_type'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
