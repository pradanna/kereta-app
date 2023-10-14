<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\SpecialEquipmentType;

class SpecialEquipmentTypeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = SpecialEquipmentType::with([])->orderBy('created_at', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master.special-equipment-type.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'code' => $this->postField('code'),
                    'name' => $this->postField('name'),
                ];
                SpecialEquipmentType::create($data_request);
                return redirect()->route('special-equipment-type');
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
        return view('admin.master.special-equipment-type.add');
    }
}
