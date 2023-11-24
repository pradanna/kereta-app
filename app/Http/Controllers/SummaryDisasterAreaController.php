<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\DisasterArea;
use App\Models\DisasterType;
use App\Models\ServiceUnit;

class SummaryDisasterAreaController extends CustomController
{
    private $formula;

    public function __construct()
    {
        parent::__construct();
        $this->formula = new Formula();
    }

    public function index()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get()->append(['disaster_areas']);
        if ($this->request->ajax()) {
            $type = $this->request->query->get('type');
            if ($type === 'service-unit') {
                return $this->jsonSuccessResponse('success', $service_units);
            } else {
                $disaster_types = DisasterType::with([])->orderBy('name', 'ASC')->get();
                $disaster_areas = DisasterArea::with(['resort.service_unit'])->orderBy('created_at', 'ASC')->get();
                $location_type = $this->request->query->get('location_type');
                $data = $this->formula->summaryDisasterByType($disaster_types, $location_type, $service_units, $disaster_areas);
//                dd($data);
                return $this->jsonSuccessResponse('success', $data);
            }
        }

        return view('admin.summary.disaster-area.index')->with([
            'service_units' => $service_units
        ]);
    }
}
