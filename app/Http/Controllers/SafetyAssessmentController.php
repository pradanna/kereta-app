<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\SafetyAssessment;
use App\Models\ServiceUnit;
use Illuminate\Database\Eloquent\Builder;

class SafetyAssessmentController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.infrastructure.safety-assessment.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    public function main_page($service_unit_id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        if ($this->request->ajax()) {
            $query = SafetyAssessment::with(['sub_track.track.area', 'district.city.province']);
            $area = $this->request->query->get('area');
//            if ($area !== '') {
//                $query->where('area_id', '=', $area);
//            } else {
//                $areaIDS = $areas->pluck('id')->toArray();
//                $query->whereIn('area_id', $areaIDS);
//            }
            $data = $query
                ->orderBy('created_at', 'ASC')
                ->get();
            return $this->basicDataTables($data);
        }
        return view('admin.infrastructure.safety-assessment.index')->with([
            'service_unit' => $service_unit,
            'areas' => $areas
        ]);
    }
}
