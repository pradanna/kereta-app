<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\ServiceUnit;

class ServiceUnitController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = ServiceUnit::with([])->orderBy('created_at', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master.service-unit.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'name' => $this->postField('name'),
//                    'latitude' => $this->postField('latitude'),
//                    'longitude' => $this->postField('longitude'),
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
//                    'latitude' => $this->postField('latitude'),
//                    'longitude' => $this->postField('longitude'),
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
}
