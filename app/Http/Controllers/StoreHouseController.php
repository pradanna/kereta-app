<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\City;
use App\Models\ServiceUnit;
use App\Models\Storehouse;
use App\Models\StorehouseImage;
use App\Models\StorehouseType;
use App\Models\TechnicalSpecLocomotive;
use App\Models\TechnicalSpecLocomotiveImage;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class StoreHouseController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function service_unit_page()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.storehouse.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    public function index($service_unit_id)
    {
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $access = $this->getRoleAccess(Formula::APPMenuStorehouse);

        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $storehouse_types = StorehouseType::with([])->orderBy('name', 'ASC')->get();
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();

        if ($this->request->ajax()) {
            $type = $this->request->query->get('type');
            $query = Storehouse::with(['storehouse_type', 'area', 'city.province']);
            $storehouse_type = $this->request->query->get('storehouse_type');
            $area = $this->request->query->get('area');
            if ($storehouse_type !== '') {
                $query->where('storehouse_type_id', '=', $storehouse_type);
            }


            if ($area !== '') {
                $query->where('area_id', '=', $area);
            } else {
                $areaIDS = $areas->pluck('id')->toArray();
                $query->whereIn('area_id', $areaIDS);
            }
            switch ($type) {
                case 'map':
                    $data = $query->get()->append(['count_locomotive', 'count_train', 'count_wagon', 'count_electric_train', 'count_diesel_train', 'count_usual_train', 'count_special_equipment',]);
                    return $this->jsonSuccessResponse('success', $data);
                case 'table':
                    $data = $query
                        ->orderBy('created_at', 'DESC')
                        ->get();
                    return $this->basicDataTables($data);
                default:
                    return $this->jsonSuccessResponse('success', []);
            }
        }


        return view('admin.facility-menu.storehouse.index')->with([
            'storehouse_types' => $storehouse_types,
            'areas' => $areas,
            'service_unit' => $service_unit,
            'access' => $access
        ]);
    }

    private $rule = [
        'storehouse_type' => 'required',
        'name' => 'required',
        'city' => 'required',
        'area' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
    ];

    private $message = [
        'storehouse_type.required' => 'kolom depo wajib di isi',
        'name.required' => 'kolom nama wajib di isi',
        'city.required' => 'kolom kota wajib di isi',
        'area.required' => 'kolom daerah operasi wajib di isi',
        'latitude.required' => 'kolom latitude wajib di isi',
        'longitude.required' => 'kolom longitude wajib di isi',
    ];

    public function store($service_unit_id)
    {
        //filtering access
        $access = $this->getRoleAccess(Formula::APPMenuStorehouse);
        if (!$access['is_granted_create']) {
            abort(403);
        }

        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'storehouse_type_id' => $this->postField('storehouse_type'),
                    'name' => $this->postField('name'),
                    'city_id' => $this->postField('city'),
                    'area_id' => $this->postField('area'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'description' => $this->postField('description'),
                    'created_by' => auth()->id(),
                    'updated_by' => auth()->id(),
                ];
                Storehouse::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $storehouse_types = StorehouseType::with([])->orderBy('name', 'ASC')->get();
        $cities = City::with([])->orderBy('name', 'ASC')->get();
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.storehouse.add')->with([
            'storehouse_types' => $storehouse_types,
            'cities' => $cities,
            'areas' => $areas,
            'service_unit' => $service_unit
        ]);
    }

    public function patch($service_unit_id, $id)
    {
        //filtering access
        $access = $this->getRoleAccess(Formula::APPMenuStorehouse);
        if (!$access['is_granted_update']) {
            abort(403);
        }

        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }

        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = Storehouse::with(['storehouse_type', 'area', 'city.province'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $validator = Validator::make($this->request->all(), $this->rule, $this->message);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->with('validator', 'Harap Mengisi Kolom Dengan Benar');
                }
                $data_request = [
                    'storehouse_type_id' => $this->postField('storehouse_type'),
                    'name' => $this->postField('name'),
                    'city_id' => $this->postField('city'),
                    'area_id' => $this->postField('area'),
                    'latitude' => $this->postField('latitude'),
                    'longitude' => $this->postField('longitude'),
                    'description' => $this->postField('description'),
                    'updated_by' => auth()->id(),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $storehouse_types = StorehouseType::with([])->orderBy('name', 'ASC')->get();
        $cities = City::with([])->orderBy('name', 'ASC')->get();
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.storehouse.edit')->with([
            'storehouse_types' => $storehouse_types,
            'cities' => $cities,
            'areas' => $areas,
            'service_unit' => $service_unit,
            'data' => $data
        ]);
    }

    public function destroy($service_unit_id, $id)
    {
        $access = $this->getRoleAccess(Formula::APPMenuStorehouse);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }

        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            Storehouse::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function image_page($service_unit_id, $id)
    {
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            abort(403);
        }
        $access = $this->getRoleAccess(Formula::APPMenuStorehouse);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = Storehouse::with(['area', 'storehouse_type', 'images'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            DB::beginTransaction();
            try {
                if ($this->request->hasFile('files')) {
                    foreach ($this->request->file('files') as $file) {
                        $extension = $file->getClientOriginalExtension();
                        $document = Uuid::uuid4()->toString() . '.' . $extension;
                        $storage_path = public_path('storehouse');
                        $documentName = $storage_path . '/' . $document;
                        $dataDocument = [
                            'storehouse_id' => $data->id,
                            'image' => '/storehouse/' . $document
                        ];
                        StorehouseImage::create($dataDocument);
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
        return view('admin.facility-menu.storehouse.image')->with([
            'data' => $data,
            'service_unit' => $service_unit,
            'access' => $access
        ]);
    }

    public function destroy_image($service_unit_id, $id, $image_id)
    {
        //filtering service unit
        $hasAccessServiceUnit = $this->hasServiceUnitAccess($service_unit_id);
        if (!$hasAccessServiceUnit) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }

        $access = $this->getRoleAccess(Formula::APPMenuStorehouse);
        if (!$access['is_granted_delete']) {
            return $this->jsonErrorResponse('cannot access delete perform...');
        }
        try {
            StorehouseImage::destroy($image_id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function getDataByArea()
    {
        try {
            $area = $this->request->query->get('area');
            //            $service_unit = $this->request->query->get('service_unit');
            $query = Storehouse::with(['area', 'storehouse_type']);

            //            if ($service_unit !== '' && $service_unit !== null) {
            //                $query->whereHas('area', function ($qa) use ($service_unit) {
            //                    /** @var $qa Builder */
            //                    return $qa->where('service_unit_id', '=', $service_unit);
            //                });
            //            }
            if ($area !== '') {
                $query->where('area_id', '=', $area);
            }
            $data = $query->orderBy('created_at', 'ASC')->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function facility_locomotive_page($id)
    {
        $data = Storehouse::with([])->findOrFail($id);
        return view('admin.master.storehouse.facility-certification.locomotive')->with([
            'data' => $data
        ]);
    }

    public function facility_train_page($id)
    {
        $data = Storehouse::with([])->findOrFail($id);
        return view('admin.master.storehouse.facility-certification.train')->with([
            'data' => $data
        ]);
    }

    public function facility_wagon_page($id)
    {
        $data = Storehouse::with([])->findOrFail($id);
        return view('admin.master.storehouse.facility-certification.wagon')->with([
            'data' => $data
        ]);
    }
}
