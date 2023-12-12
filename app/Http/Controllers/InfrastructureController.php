<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\ServiceUnit;

class InfrastructureController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.index')->with([
            'service_units' => $service_units
        ]);
    }
}
