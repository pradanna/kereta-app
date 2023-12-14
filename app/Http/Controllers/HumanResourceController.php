<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Helper\Formula;
use App\Models\Area;
use App\Models\HumanResource;
use App\Models\MaterialTool;
use App\Models\Resort;
use App\Models\ServiceUnit;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class HumanResourceController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function category_page()
    {
        return view('admin.facility-menu.human-resource.category');
    }

    private function generateSlug($slug) {
        $type = '-';
        switch ($slug) {
            case 'ppka':
                $type = 'PPKA';
                break;
            case 'awak-sarana-perkeretaapian':
                $type = 'Awak Sarana Perkeretaapian';
                break;
            case 'pemeriksa-sarana':
                $type = 'Pemeriksa Sarana';
                break;
            case 'perawat-sarana':
                $type = 'Perawat Sarana';
                break;
            case 'penjaga-perlintasan':
                $type = 'Penjaga Perlintasan Kereta Api (PJL)';
                break;
            default:
                break;
        }
        return $type;
    }

    public function index($slug)
    {
        $type = $this->generateSlug($slug);
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.human-resource.service-unit')
            ->with([
                'service_units' => $service_units,
                'type' => $type
            ]);
    }

    public function main_page($slug, $service_unit_id)
    {
        $type = $this->generateSlug($slug);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        if ($this->request->ajax()) {
            $query = HumanResource::with(['area'])->where('type', '=', $slug);
            $area = $this->request->query->get('area');
            $name = $this->request->query->get('name');
            $status = $this->request->query->get('status');
            if ($area !== '') {
                $query->where('area_id', '=', $area);
            } else {
                $areaIDS = $areas->pluck('id')->toArray();
                $query->whereIn('area_id', $areaIDS);
            }

            if ($name !== '') {
                $query->where(function ($q) use ($name) {
                    /** @var $q Builder */
                    $q->where('name', 'LIKE', '%' . $name . '%');
                });
            }

            $data = $query
                ->orderBy('created_at', 'ASC')
                ->get()->append(['expired_in', 'status']);

            if ($status !== '') {
                if ($status === '1') {
                    $data = $data->where('expired_in', '>', Formula::ExpirationLimit)->values();
                }

                if ($status === '0') {
                    $data = $data->where('expired_in', '<=', Formula::ExpirationLimit)->values();
                }
            }
            return $this->basicDataTables($data);
        }
        return view('admin.facility-menu.human-resource.index')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'type' => $type,
            'slug' => $slug
        ]);
    }

    public function store($slug, $service_unit_id)
    {
        $type = $this->generateSlug($slug);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();

        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'name' => $this->postField('name'),
                    'birth_place' => $this->postField('birth_place'),
                    'date_of_birth' => Carbon::createFromFormat('d-m-Y', $this->postField('date_of_birth'))->format('Y-m-d'),
                    'identity_number' => $this->postField('identity_number'),
                    'type' => $slug,
                    'certification_unit' => $this->postField('certification_unit'),
                    'certification_number' => $this->postField('certification_number'),
                    'expired_date' => $this->postField('expired_date') !== '' ? Carbon::createFromFormat('d-m-Y', $this->postField('expired_date'))->format('Y-m-d') : null,
                    'description' => $this->postField('description'),
                ];
                HumanResource::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }

        return view('admin.facility-menu.human-resource.add')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'type' => $type,
            'slug' => $slug
        ]);
    }

    public function patch($slug, $service_unit_id, $id)
    {
        $type = $this->generateSlug($slug);
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = HumanResource::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'name' => $this->postField('name'),
                    'birth_place' => $this->postField('birth_place'),
                    'date_of_birth' => Carbon::createFromFormat('d-m-Y', $this->postField('date_of_birth'))->format('Y-m-d'),
                    'identity_number' => $this->postField('identity_number'),
                    'type' => $slug,
                    'certification_unit' => $this->postField('certification_unit'),
                    'certification_number' => $this->postField('certification_number'),
                    'expired_date' => $this->postField('expired_date') !== '' ? Carbon::createFromFormat('d-m-Y', $this->postField('expired_date'))->format('Y-m-d') : null,
                    'description' => $this->postField('description'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error...');
            }
        }
        $areas = Area::with(['service_units'])
            ->whereHas('service_units', function ($qs) use ($service_unit_id) {
                /** @var $qs Builder */
                return $qs->where('service_unit_id', '=', $service_unit_id);
            })
            ->orderBy('name', 'ASC')->get();
        return view('admin.facility-menu.human-resource.edit')->with([
            'service_unit' => $service_unit,
            'areas' => $areas,
            'type' => $type,
            'data' => $data,
            'slug' => $slug
        ]);
    }

    public function destroy($slug, $service_unit_id, $id)
    {
        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            HumanResource::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function detail($slug, $service_unit_id, $id)
    {
        try {
            $service_unit = ServiceUnit::with([])->where('id', '=', $service_unit_id)->first();
            if (!$service_unit) {
                return $this->jsonErrorResponse('Satuan Pelayanan Tidak Di Temukan...');
            }
            $data = HumanResource::with(['area'])
                ->where('id', '=', $id)
                ->first()->append(['expired_in', 'status']);
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
