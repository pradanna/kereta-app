<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\DirectPassage;
use App\Models\FacilityLocomotive;
use App\Models\FacilitySpecialEquipment;
use App\Models\FacilityTrain;
use App\Models\FacilityType;
use App\Models\FacilityWagon;
use App\Models\ServiceUnit;
use App\Models\Storehouse;
use App\Models\Track;
use Illuminate\Database\Eloquent\Builder;

class AreaController extends CustomController
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
            $type = $this->request->query->get('type');
            $data = Area::with(['service_unit:id,name'])->orderBy('name', 'ASC')->get();
            switch ($type) {
                case 'map':
                    return $this->jsonSuccessResponse('success', $data);
                case 'table':
                    return $this->basicDataTables($data);

                default:
                    return $this->jsonSuccessResponse('success', []);
            }
        }
        return view('admin.master.area.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'service_unit_id' => $this->postField('service_unit'),
                    'name' => $this->postField('name'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                ];
                Area::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $service_units = ServiceUnit::all();
        return view('admin.master.area.add')->with(['service_units' => $service_units]);
    }

    public function patch($id)
    {
        $data = Area::with(['service_unit'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'service_unit_id' => $this->postField('service_unit'),
                    'name' => $this->postField('name'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $service_units = ServiceUnit::all();
        return view('admin.master.area.edit')->with([
            'data' => $data,
            'service_units' => $service_units
        ]);
    }

    public function destroy($id)
    {
        try {
            Area::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function facility_certification_page($id)
    {
        $data = Area::with([])->findOrFail($id);
        if ($this->request->ajax()) {
            $total_facilities = $this->generateTotalFacilityData($id);
            return $this->jsonSuccessResponse('success', $total_facilities);
        }
        $facility_types = FacilityType::with([])->orderBy('id', 'ASC')->get();
        $facility_locomotives = FacilityLocomotive::with(['area'])
            ->where('area_id', '=', $id)
            ->count();
        $facility_trains = FacilityTrain::with(['area'])
            ->where('area_id', '=', $id)
            ->count();
        $facility_wagons = FacilityWagon::with(['area'])
            ->where('area_id', '=', $id)
            ->count();
        $facility_special_equipments = FacilitySpecialEquipment::with(['area'])
            ->where('area_id', '=', $id)
            ->count();
        return view('admin.master.area.facility-certification.index')->with([
            'data' => $data,
            'facility_types' => $facility_types,
            'facility_locomotives' => $facility_locomotives,
            'facility_trains' => $facility_trains,
            'facility_wagons' => $facility_wagons,
            'facility_special_equipments' => $facility_special_equipments,
        ]);
    }

    private function generateTotalFacilityData($id)
    {
        $areas = Area::with([])->where('id', '=', $id)->get();
        $type = $this->request->query->get('type');
        $facility_locomotives = FacilityLocomotive::with(['area'])
            ->where('area_id', '=', $id)
            ->get()->append(['expired_in']);

        $facility_trains = FacilityTrain::with(['area'])
            ->where('area_id', '=', $id)
            ->where('engine_type', '=', 'train')
            ->get()->append(['expired_in']);

        $facility_diesel_trains = FacilityTrain::with(['area'])
            ->where('area_id', '=', $id)
            ->where('engine_type', '=', 'diesel-train')
            ->get()->append(['expired_in']);

        $facility_electric_trains = FacilityTrain::with(['area'])
            ->where('area_id', '=', $id)
            ->where('engine_type', '=', 'electric-train')
            ->get()->append(['expired_in']);

        $facility_wagons = FacilityWagon::with(['area'])
            ->where('area_id', '=', $id)
            ->get()->append(['expired_in']);

        $facility_special_equipment = FacilitySpecialEquipment::with(['area'])
            ->where('area_id', '=', $id)
            ->get()->append(['expired_in']);
        return $this->formula->summaryTotalFacilities(
            $type,
            $areas,
            $facility_locomotives,
            $facility_trains,
            $facility_electric_trains,
            $facility_diesel_trains,
            $facility_wagons,
            $facility_special_equipment
        );
    }

    public function facility_certification_page_by_slug($id, $slug)
    {
        $data = Area::with([])->findOrFail($id);
//        $areas = Area::with([])->where('id', '=', $id)->get();
        $storehouses = Storehouse::with(['storehouse_type'])->where('area_id', '=', $id)->get();
        switch ($slug) {
            case 'lokomotif':
                return view('admin.master.area.facility-certification.locomotive')->with([
                    'data' => $data,
                    'storehouses' => $storehouses,
                ]);
            case 'kereta':
                return view('admin.master.area.facility-certification.train')->with([
                    'data' => $data,
                    'storehouses' => $storehouses,
                ]);
            case 'gerbong':
                return view('admin.master.area.facility-certification.wagon')->with([
                    'data' => $data,
                    'storehouses' => $storehouses,
                ]);
            case 'peralatan-khusus':
                return view('admin.master.area.facility-certification.special-equipment')->with([
                    'data' => $data,
                ]);
            default:
                return redirect()->back();
        }
    }

    public function direct_passage_page($id)
    {
        $data = Area::with([])->findOrFail($id);
        $tracks = Track::with([])->where('area_id', '=', $id)->get();
        return view('admin.master.area.direct-passage.index')->with([
            'data' => $data,
            'tracks' => $tracks,
        ]);
    }

    public function illegal_building_page($id) {
        $data = Area::with([])->findOrFail($id);
        $tracks = Track::with(['area'])->where('area_id', '=', $id)->get();
        return view('admin.master.area.illegal-building.index')->with([
            'data' => $data,
            'tracks' => $tracks,
        ]);
    }
    public function getStorehouseByAreaID($id)
    {
        try {
            $type = $this->request->query->get('type') ?? 1;
            $data = Storehouse::with(['storehouse_type', 'area'])
                ->where('area_id', '=', $id)
                ->where('storehouse_type_id', '=', $type)
                ->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
