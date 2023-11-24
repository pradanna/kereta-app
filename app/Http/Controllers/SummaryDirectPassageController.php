<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\DirectPassage;
use Illuminate\Database\Eloquent\Builder;

class SummaryDirectPassageController extends CustomController
{
    private $formula;

    public function __construct()
    {
        parent::__construct();
        $this->formula = new Formula();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $service_unit = $this->request->query->get('service_unit');
            $area = $this->request->query->get('area');
            $queryArea = Area::with(['service_unit']);
            $queryDirectPassage = DirectPassage::with(['sub_track.track']);
            if ($service_unit !== '' && $service_unit !== null) {
                $queryArea->where('service_unit_id', '=', $service_unit);

                $queryDirectPassage->whereHas('sub_track', function ($qst) use ($service_unit) {
                    /** @var $qst Builder */
                    return $qst->whereHas('track', function ($qt) use ($service_unit) {
                        /** @var $qt Builder */
                        return $qt->whereHas('area', function ($qa) use ($service_unit) {
                            /** @var $qa Builder */
                            return $qa->where('service_unit_id', '=', $service_unit);
                        });
                    });
                });
            }

            if ($area !== '' && $area !== null) {
                $queryArea->where('id', '=', $area);

                $queryDirectPassage->whereHas('sub_track', function ($qst) use ($area) {
                    /** @var $qst Builder */
                    return $qst->whereHas('track', function ($qt) use ($area) {
                        /** @var $qt Builder */
                        return $qt->where('area_id', '=', $area);
                    });
                });
            }

            $areas = $queryArea->get();
            $directPassages = $queryDirectPassage->get();
            $summaryDirectPassages = $this->formula->summaryDirectPassages($areas, $directPassages);
            return $this->jsonSuccessResponse('success', $summaryDirectPassages);
        }
        return view('admin.summary.direct-passage.index');
    }
}
