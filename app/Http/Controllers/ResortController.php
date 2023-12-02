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

    public function index()
    {
        if ($this->request->ajax()) {
            $data = Resort::with(['service_unit:id,name'])->orderBy('name', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master.resort.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'service_unit_id' => $this->postField('service_unit'),
                    'name' => $this->postField('name'),
                ];
                Resort::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.master.resort.add')->with(['service_units' => $service_units]);
    }

    public function patch($id)
    {
        $data = Resort::with(['service_unit'])->findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'service_unit_id' => $this->postField('service_unit'),
                    'name' => $this->postField('name'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        $service_units = ServiceUnit::with([])->orderBy('name', 'ASC')->get();
        return view('admin.master.resort.edit')->with([
            'data' => $data,
            'service_units' => $service_units
        ]);
    }

    public function destroy($id)
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
