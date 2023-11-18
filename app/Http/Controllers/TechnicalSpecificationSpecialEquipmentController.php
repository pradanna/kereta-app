<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\FacilitySpecialEquipment;
use App\Models\SpecialEquipmentType;
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
            $data = TechnicalSpecSpecialEquipment::with(['special_equipment_type'])
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
                    'special_equipment_type_id' => $this->postField('special_equipment_type'),
                    'empty_weight' => $this->postField('empty_weight') ,
                    'maximum_speed' => $this->postField('maximum_speed'),
                    'passenger_capacity' => $this->postField('passenger_capacity'),
                    'long' => $this->postField('long'),
                    'width' => $this->postField('width'),
                    'height' => $this->postField('height'),
                    'spoor_width' => $this->postField('spoor_width'),
                ];
                TechnicalSpecSpecialEquipment::create($data_request);
                return redirect()->route('technical-specification.special-equipment');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $special_equipment_types = SpecialEquipmentType::with([])->orderBy('name', 'ASC')->get();
        return view('admin.technical-specification.special-equipment.add')->with([
            'special_equipment_types' => $special_equipment_types,
        ]);
    }
}
