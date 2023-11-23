<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\FacilityDieselTrain;
use App\Models\FacilityElectricTrain;
use App\Models\FacilityLocomotive;
use App\Models\FacilitySpecialEquipment;
use App\Models\FacilityTrain;
use App\Models\FacilityType;
use App\Models\FacilityWagon;
use App\Models\Resort;
use App\Models\ServiceUnit;
use App\Models\ServiceUnitImage;
use App\Models\TechnicalSpecLocomotive;
use App\Models\TechnicalSpecLocomotiveImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class ServiceUnitController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $type = $this->request->query->get('type');
            $data = ServiceUnit::with([])->orderBy('created_at', 'ASC')->get();
            switch ($type) {
                case 'map':
                    return $this->jsonSuccessResponse('success', $data);
                case 'table':
                    return $this->basicDataTables($data);
                default:
                    return $this->jsonSuccessResponse('success', []);
            }
        }
        return view('admin.master.service-unit.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'name' => $this->postField('name'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                ];
                ServiceUnit::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master.service-unit.add');
    }

    public function patch($id)
    {
        $data = ServiceUnit::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
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
        return view('admin.master.service-unit.edit')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        try {
            ServiceUnit::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function image_page($id)
    {
        $data = ServiceUnit::with(['images'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                if ($this->request->hasFile('files')) {
                    foreach ($this->request->file('files') as $file) {
                        $extension = $file->getClientOriginalExtension();
                        $document = Uuid::uuid4()->toString() . '.' . $extension;
                        $storage_path = public_path('service-unit');
                        $documentName = $storage_path . '/' . $document;
                        $dataDocument = [
                            'service_unit_id' => $data->id,
                            'image' => '/service-unit/' . $document
                        ];
                        ServiceUnitImage::create($dataDocument);
                        $file->move($storage_path, $documentName);
                    }
                    DB::commit();
                    return $this->jsonSuccessResponse('success');
                } else {
                    DB::rollBack();
                    return $this->jsonBadRequestResponse('no image attached...');
                }
            } catch (\Exception $e) {
                DB::rollBack();
                return $this->jsonErrorResponse('internal server error');
            }
        }

        return view('admin.master.service-unit.image')->with([
            'data' => $data
        ]);
    }

    public function destroy_image($id)
    {
        try {
            ServiceUnitImage::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function facility_certification_page($id)
    {
        $data = ServiceUnit::with(['images'])->findOrFail($id);
        if ($this->request->ajax()) {
            $total_facilities = $this->generateTotalFacilityData($id);
            return $this->jsonSuccessResponse('success', $total_facilities);
        }
        $facility_types = FacilityType::with([])->orderBy('id', 'ASC')->get();
        $facility_locomotives = FacilityLocomotive::with(['area'])
            ->whereHas('area', function ($ql) use ($id) {
                /** @var $ql Builder */
                return $ql->where('service_unit_id', '=', $id);
            })
            ->count();
        $facility_trains = FacilityTrain::with(['area'])
            ->whereHas('area', function ($qt) use ($id) {
                /** @var $qt Builder */
                return $qt->where('service_unit_id', '=', $id);
            })
            ->count();
        $facility_wagons = FacilityWagon::with(['area'])
            ->whereHas('area', function ($qw) use ($id) {
                /** @var $qw Builder */
                return $qw->where('service_unit_id', '=', $id);
            })
            ->count();
        $facility_special_equipments = FacilitySpecialEquipment::with(['area'])
            ->whereHas('area', function ($qse) use ($id) {
                /** @var $qse Builder */
                return $qse->where('service_unit_id', '=', $id);
            })
            ->count();
        return view('admin.master.service-unit.facility-certification.index')->with([
            'data' => $data,
            'facility_types' => $facility_types,
            'facility_locomotives' => $facility_locomotives,
            'facility_trains' => $facility_trains,
            'facility_wagons' => $facility_wagons,
            'facility_special_equipments' => $facility_special_equipments,
        ]);
    }

    public function facility_certification_page_by_slug($id, $slug) {
        $data = ServiceUnit::with(['images'])->findOrFail($id);
        $areas = Area::with(['service_unit'])->where('service_unit_id', '=', $id)->get();
        switch ($slug) {
            case 'lokomotif':
                return view('admin.master.service-unit.facility-certification.locomotive')->with([
                    'data' => $data,
                    'areas' => $areas,
                ]);
            case 'kereta':
                return view('admin.master.service-unit.facility-certification.train')->with([
                    'data' => $data,
                    'areas' => $areas,
                ]);
            case 'gerbong':
                return view('admin.master.service-unit.facility-certification.wagon')->with([
                    'data' => $data,
                    'areas' => $areas,
                ]);
            case 'peralatan-khusus':
                return view('admin.master.service-unit.facility-certification.special-equipment')->with([
                    'data' => $data,
                    'areas' => $areas,
                ]);
            default:
                return redirect()->back();
        }
    }

    public function direct_passage_page($id) {
        $data = ServiceUnit::with(['images'])->findOrFail($id);
        $areas = Area::with(['service_unit'])->where('service_unit_id', '=', $id)->get();
        return view('admin.master.service-unit.direct-passage.index')->with([
            'data' => $data,
            'areas' => $areas,
        ]);
    }

    public function disaster_area_page($id)
    {
        $data = ServiceUnit::with(['images'])->findOrFail($id);
        $resorts = Resort::with(['service_unit'])->where('service_unit_id', '=', $id)->get();
        return view('admin.master.service-unit.disaster-area.index')->with([
            'data' => $data,
            'resorts' => $resorts,
        ]);
    }

    private function generateTotalFacilityData($id)
    {
        $areas = Area::with(['service_unit'])->where('service_unit_id', '=', $id)->get();
        $type = $this->request->query->get('type');
        $facility_locomotives = FacilityLocomotive::with(['area'])
            ->whereHas('area', function ($ql) use ($id) {
                /** @var $ql Builder */
                return $ql->where('service_unit_id', '=', $id);
            })
            ->get()->append(['expired_in']);

        $facility_trains = FacilityTrain::with(['area'])
            ->whereHas('area', function ($qt) use ($id) {
                /** @var $qt Builder */
                return $qt->where('service_unit_id', '=', $id);
            })
            ->where('engine_type', '=', 'train')
            ->get()->append(['expired_in']);

        $facility_diesel_trains = FacilityTrain::with(['area'])
            ->whereHas('area', function ($qdt) use ($id) {
                /** @var $qdt Builder */
                return $qdt->where('service_unit_id', '=', $id);
            })
            ->where('engine_type', '=', 'diesel-train')
            ->get()->append(['expired_in']);

        $facility_electric_trains = FacilityTrain::with(['area'])
            ->whereHas('area', function ($qet) use ($id) {
                /** @var $qet Builder */
                return $qet->where('service_unit_id', '=', $id);
            })
            ->where('engine_type', '=', 'electric-train')
            ->get()->append(['expired_in']);

        $facility_wagons = FacilityWagon::with(['area'])
            ->whereHas('area', function ($qw) use ($id) {
                /** @var $qw Builder */
                return $qw->where('service_unit_id', '=', $id);
            })
            ->get()->append(['expired_in']);

        $facility_special_equipment = FacilitySpecialEquipment::with(['area'])
            ->whereHas('area', function ($qse) use ($id) {
                /** @var $qse Builder */
                return $qse->where('service_unit_id', '=', $id);
            })
            ->get()->append(['expired_in']);
        $total_facilities = [];
        if ($type === 'total') {
            foreach ($areas as $area) {
                $qty_locomotive = $facility_locomotives->where('area_id', '=', $area->id)->count();
                $qty_train = $facility_trains->where('area_id', '=', $area->id)->count();
                $qty_diesel_train = $facility_diesel_trains->where('area_id', '=', $area->id)->count();
                $qty_electric_train = $facility_electric_trains->where('area_id', '=', $area->id)->count();
                $qty_wagon = $facility_wagons->where('area_id', '=', $area->id)->count();
                $qty_special_equipment = $facility_special_equipment->where('area_id', '=', $area->id)->count();
                $sum = ($qty_locomotive + $qty_train + $qty_diesel_train + $qty_electric_train + $qty_wagon + $qty_special_equipment);
                $tmp_total_facility['area'] = $area->name;
                $tmp_total_facility['locomotive'] = $qty_locomotive;
                $tmp_total_facility['train'] = $qty_train;
                $tmp_total_facility['diesel_train'] = $qty_diesel_train;
                $tmp_total_facility['electric_train'] = $qty_electric_train;
                $tmp_total_facility['wagon'] = $qty_wagon;
                $tmp_total_facility['special_equipment'] = $qty_special_equipment;
                $tmp_total_facility['total'] = $sum;
                array_push($total_facilities, $tmp_total_facility);
            }
        } elseif ($type === 'expiration') {
            foreach ($areas as $area) {
                $qty_locomotive = $facility_locomotives
                    ->where('area_id', '=', $area->id)
                    ->where('expired_in', '>', Formula::ExpirationLimit)
                    ->count();
                $qty_locomotive_expired = $facility_locomotives
                    ->where('area_id', '=', $area->id)
                    ->where('expired_in', '<=', Formula::ExpirationLimit)
                    ->count();

                $qty_train = $facility_trains
                    ->where('area_id', '=', $area->id)
                    ->where('expired_in', '>', Formula::ExpirationLimit)
                    ->count();

                $qty_train_expired = $facility_trains
                    ->where('area_id', '=', $area->id)
                    ->where('expired_in', '<=', Formula::ExpirationLimit)
                    ->count();

                $qty_diesel_train = $facility_diesel_trains
                    ->where('area_id', '=', $area->id)
                    ->where('expired_in', '>', Formula::ExpirationLimit)
                    ->count();

                $qty_diesel_train_expired = $facility_diesel_trains
                    ->where('area_id', '=', $area->id)
                    ->where('expired_in', '<=', Formula::ExpirationLimit)
                    ->count();

                $qty_electric_train = $facility_electric_trains
                    ->where('area_id', '=', $area->id)
                    ->where('expired_in', '>', Formula::ExpirationLimit)
                    ->count();

                $qty_electric_train_expired = $facility_electric_trains
                    ->where('area_id', '=', $area->id)
                    ->where('expired_in', '<=', Formula::ExpirationLimit)
                    ->count();

                $qty_wagon = $facility_wagons
                    ->where('area_id', '=', $area->id)
                    ->where('expired_in', '>', Formula::ExpirationLimit)
                    ->count();

                $qty_wagon_expired = $facility_wagons
                    ->where('area_id', '=', $area->id)
                    ->where('expired_in', '<=', Formula::ExpirationLimit)
                    ->count();

                $qty_special_equipment = $facility_special_equipment
                    ->where('area_id', '=', $area->id)
                    ->where('expired_in', '>', Formula::ExpirationLimit)
                    ->count();

                $qty_special_equipment_expired = $facility_special_equipment
                    ->where('area_id', '=', $area->id)
                    ->where('expired_in', '<=', Formula::ExpirationLimit)
                    ->count();

                $sum = (
                    $qty_locomotive +
                    $qty_train +
                    $qty_diesel_train +
                    $qty_electric_train +
                    $qty_wagon +
                    $qty_special_equipment +
                    $qty_locomotive_expired +
                    $qty_train_expired +
                    $qty_diesel_train_expired +
                    $qty_electric_train_expired +
                    $qty_wagon_expired +
                    $qty_special_equipment_expired
                );

                $tmp_total_facility['area'] = $area->name;
                $tmp_total_facility['locomotive'] = $qty_locomotive;
                $tmp_total_facility['locomotive_expired'] = $qty_locomotive_expired;
                $tmp_total_facility['train'] = $qty_train;
                $tmp_total_facility['train_expired'] = $qty_train_expired;
                $tmp_total_facility['diesel_train'] = $qty_diesel_train;
                $tmp_total_facility['diesel_train_expired'] = $qty_diesel_train_expired;
                $tmp_total_facility['electric_train'] = $qty_electric_train;
                $tmp_total_facility['electric_train_expired'] = $qty_electric_train_expired;
                $tmp_total_facility['wagon'] = $qty_wagon;
                $tmp_total_facility['wagon_expired'] = $qty_wagon_expired;
                $tmp_total_facility['special_equipment'] = $qty_special_equipment;
                $tmp_total_facility['special_equipment_expired'] = $qty_special_equipment_expired;
                $tmp_total_facility['total'] = $sum;
                array_push($total_facilities, $tmp_total_facility);
            }
        } else {
            $total_facilities = [];
        }
        return $total_facilities;
    }
}
