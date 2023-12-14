<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Resort;
use App\Models\ServiceUnit;

class ResortController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function service_unit_page()
    {
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.master-data.resort.service-unit')
            ->with([
                'service_units' => $service_units
            ]);
    }

    public function index($service_unit_id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        if ($this->request->ajax()) {
            $data = Resort::with(['service_unit:id,name'])
                ->where('service_unit_id', '=', $service_unit_id)
                ->orderBy('name', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master-data.resort.index')->with([
            'service_unit' => $service_unit
        ]);
    }

    public function store($service_unit_id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'service_unit_id' => $service_unit_id,
                    'name' => $this->postField('name'),
                ];
                Resort::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master-data.resort.add')->with(['service_unit' => $service_unit]);
    }

    public function patch($service_unit_id, $id)
    {
        $service_unit = ServiceUnit::findOrFail($service_unit_id);
        $data = Resort::with(['service_unit'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'service_unit_id' => $service_unit_id,
                    'name' => $this->postField('name'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master-data.resort.edit')->with([
            'data' => $data,
            'service_unit' => $service_unit
        ]);
    }

    public function destroy($service_unit_id, $id)
    {
        try {
            Resort::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }

    public function getResortsByServiceUnit()
    {
        try {
            $service_unit = $this->request->query->get('service_unit');
            $query = Resort::with([]);
            if ($service_unit !== '') {
                $query->where('service_unit_id', '=', $service_unit);
            }
            $data = $query->orderBy('created_at', 'ASC')->get();
            return $this->jsonSuccessResponse('success', $data);
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
