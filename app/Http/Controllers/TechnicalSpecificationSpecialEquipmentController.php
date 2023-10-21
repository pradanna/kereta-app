<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\FacilitySpecialEquipment;
use App\Models\TechnicalSpecSpecialEquipment;

class TechnicalSpecificationSpecialEquipmentController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = TechnicalSpecSpecialEquipment::with(['facility_special_equipment.special_equipment_type'])
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.technical-specification.special-equipment.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'facility_special_equipment_id' => $this->postField('facility_special_equipment'),
                    'empty_weight' => $this->postField('empty_weight') ,
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'air_conditioner' => $this->postField('air_conditioner'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'coupler_height' => $this->postField('coupler_height'),
                    'axle_load' => $this->postField('axle_load'),
                    'spoor_width' => $this->postField('spoor_width'),
                ];
                TechnicalSpecSpecialEquipment::create($data_request);
                return redirect()->route('technical-specification.special-equipment');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $facility_special_equipments = FacilitySpecialEquipment::with(['special_equipment_type'])->get();
        return view('admin.technical-specification.train.add')->with([
            'facility_special_equipments' => $facility_special_equipments,
        ]);
    }
}
