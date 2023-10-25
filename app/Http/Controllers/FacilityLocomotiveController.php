<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Area;
use App\Models\FacilityCertification;
use App\Models\FacilityLocomotive;
use App\Models\LocomotiveType;
use Carbon\Carbon;

class FacilityLocomotiveController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = FacilityLocomotive::with(['area', 'storehouse.storehouse_type', 'locomotive_type'])
                ->orderBy('created_at', 'ASC')
                ->get()->append(['expired_in', 'status']);
            return $this->basicDataTables($data);
        }
        $locomotive_types = LocomotiveType::all();
        $areas = Area::all();
        return view('admin.facility-certification.locomotive.index')->with([
            'locomotive_types' => $locomotive_types,
            'areas' => $areas,
        ]);
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'storehouse_id' => $this->postField('storehouse'),
                    'locomotive_type_id' => $this->postField('locomotive_type'),
                    'ownership' => $this->postField('ownership'),
                    'facility_number' => $this->postField('facility_number'),
                    'service_start_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_start_date'))->format('Y-m-d'),
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number'),
                ];
                FacilityLocomotive::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $locomotive_types = LocomotiveType::all();
        $areas = Area::all();
        return view('admin.facility-certification.locomotive.add')->with([
            'locomotive_types' => $locomotive_types,
            'areas' => $areas
        ]);
    }

    public function patch($id)
    {
        $data = FacilityLocomotive::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'area_id' => $this->postField('area'),
                    'storehouse_id' => $this->postField('storehouse'),
                    'locomotive_type_id' => $this->postField('locomotive_type'),
                    'ownership' => $this->postField('ownership'),
                    'facility_number' => $this->postField('facility_number'),
                    'service_start_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_start_date'))->format('Y-m-d'),
                    'service_expired_date' => Carbon::createFromFormat('d-m-Y', $this->postField('service_expired_date'))->format('Y-m-d'),
                    'testing_number' => $this->postField('testing_number'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $locomotive_types = LocomotiveType::all();
        $areas = Area::all();
        return view('admin.facility-certification.locomotive.edit')->with([
            'data' => $data,
            'locomotive_types' => $locomotive_types,
            'areas' => $areas
        ]);
    }

    public function destroy($id)
    {
        try {
            FacilityLocomotive::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
