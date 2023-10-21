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
                return redirect()->route('technical-specification.train');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $facility_trains = FacilityTrain::with(['train_type'])->get();
        return view('admin.technical-specification.train.add')->with([
            'facility_trains' => $facility_trains,
        ]);
    }
}
