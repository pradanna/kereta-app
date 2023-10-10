<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\FacilityCertification;
use App\Models\LocomotiveType;

class TechnicalSpecificationLocomotiveController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return view('admin.technical-specification.locomotive.index');
    }

    public function store()
    {
        $locomotive_types = LocomotiveType::all();
        $facility_certifications = FacilityCertification::with([])
            ->where('facility_type_id', '=', 1)
            ->get();
        return view('admin.technical-specification.locomotive.add')->with([
            'locomotive_types' => $locomotive_types,
            'facility_certifications' => $facility_certifications
        ]);
    }
}
