<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\City;
use App\Models\DirectPassage;
use App\Models\DirectPassageAccident;
use App\Models\DirectPassageSignEquipment;
use App\Models\ServiceUnit;
use App\Models\SubTrack;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class DirectPassageAccidentsController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function service_unit_page()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.direct-passage-accidents.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    private function generateData($service_unit_id, $areaIDS)
    {
        $area = $this->request->query->get('area');
        $track = $this->request->query->get('track');
        $query = DirectPassageAccident::with(['direct_passage.sub_track.track.area', 'direct_passage.city']);

        if ($area !== '') {
            $query->whereHas('direct_passage', function ($qdp) use ($area) {
                /** @var $qdp Builder */
                return $qdp->whereHas('sub_track', function ($qsta) use ($area) {
                    /** @var $qsta Builder */
                    return $qsta->whereHas('track', function ($qta) use ($area) {
                        /** @var $qta Builder */
                        return $qta->where('area_id', '=', $area);
                    });
                });
            });
        } else {
            $query->whereHas('direct_passage', function ($qdp) use ($areaIDS) {
                /** @var $qdp Builder */
                return $qdp->whereHas('sub_track', function ($qsta) use ($areaIDS) {
                    /** @var $qsta Builder */
                    return $qsta->whereHas('track', function ($qta) use ($areaIDS) {
                        /** @var $qta Builder */
                        return $qta->whereIn('area_id', $areaIDS);
                    });
                });
            });
        }

        return $query->orderBy('created_at', 'ASC')
            ->get();
    }

    public function index($service_unit_id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        $areaIDS = $areas->pluck('id')->toArray();
        if ($this->request->ajax()) {
            $data = $this->generateData($service_unit_id, $areaIDS);
            return $this->basicDataTables($data);
        }
        return view('admin.facility-menu.direct-passage-accidents.index')->with([
            'areas' => $areas,
            'service_unit' => $service_unit
        ]);
    }

    public function store($service_unit_id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        if ($this->request->method() === 'POST') {
            try {
                $date = Carbon::createFromFormat('d-m-Y', $this->postField('date'))->format('Y-m-d');
                $time = $this->postField('time');
                $data_request = [
                    'direct_passage_id' => $this->postField('direct_passage'),
                    'date' => $date . ' ' . $time,
                    'train_name' => $this->postField('train_name'),
                    'accident_type' => $this->postField('accident_type'),
                    'injured' => $this->postField('injured'),
                    'died' => $this->postField('died'),
                    'damaged_description' => $this->postField('damaged_description'),
                    'description' => $this->postField('description'),
                ];

                DirectPassageAccident::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $areaIDS = $areas->pluck('id')->toArray();
        $direct_passages = DirectPassage::with(['sub_track.track.area'])
            ->whereHas('sub_track', function ($qst) use ($areaIDS) {
                /** @var $qst Builder */
                return $qst->whereHas('track', function ($qt) use ($areaIDS) {
                    /** @var $qt Builder */
                    return $qt->whereIn('area_id', $areaIDS);
                });
            })
            ->orderBy('name')->get();
        $cities = City::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.direct-passage-accidents.add')->with([
            'direct_passages' => $direct_passages,
            'cities' => $cities,
            'service_unit' => $service_unit,
        ]);
    }

    public function patch($service_unit_id, $id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        $data = DirectPassageAccident::with([])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $date = Carbon::createFromFormat('d-m-Y', $this->postField('date'))->format('Y-m-d');
                $time = $this->postField('time');
                $data_request = [
                    'direct_passage_id' => $this->postField('direct_passage'),
                    'date' => $date . ' ' . $time,
                    'train_name' => $this->postField('train_name'),
                    'accident_type' => $this->postField('accident_type'),
                    'injured' => $this->postField('injured'),
                    'died' => $this->postField('died'),
                    'damaged_description' => $this->postField('damaged_description'),
                    'description' => $this->postField('description'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $areaIDS = $areas->pluck('id')->toArray();
        $direct_passages = DirectPassage::with(['sub_track.track.area'])
            ->whereHas('sub_track', function ($qst) use ($areaIDS) {
                /** @var $qst Builder */
                return $qst->whereHas('track', function ($qt) use ($areaIDS) {
                    /** @var $qt Builder */
                    return $qt->whereIn('area_id', $areaIDS);
                });
            })
            ->orderBy('name')->get();
        $cities = City::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.direct-passage-accidents.edit')->with([
            'data' => $data,
            'direct_passages' => $direct_passages,
            'cities' => $cities,
            'service_unit' => $service_unit,
        ]);
    }

    public function destroy($service_unit_id, $id)
    {
        DB::beginTransaction();
        try {
            DirectPassageSignEquipment::with(['direct_passage'])->where('direct_passage_id', '=', $id)->delete();
            DirectPassage::destroy($id);
            DB::commit();
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($service_unit_id, $id)
    {
        try {
            $data = DirectPassageAccident::with(['direct_passage.sub_track.track.area'])
                ->where('id', '=', $id)
                ->first();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
