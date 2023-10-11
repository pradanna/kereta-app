<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\LocomotiveType;

class FacilityLocomotiveController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            return $this->basicDataTables([]);
        }
        $locomotive_types = LocomotiveType::all();
        $areas = Area::all();
        return view('admin.facility-certification.locomotive.index')->with([
            'locomotive_types' => $locomotive_types,
            'areas' => $areas,
        ]);
    }
}
