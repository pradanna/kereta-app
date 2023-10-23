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


    public function getDataByID($id)
    {
        $data = ServiceUnit::find($id);
        if (!$data) {
            return $this->jsonNotFoundResponse('item not found');
        }
        if ($this->request->method() === 'POST') {
            return $this->patch($data);
        }
        return $this->jsonSuccessResponse('success', $data);
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
                return redirect()->route('service-unit');
            } catch (\Exception $e) {
                return redirect()->back();
            }
        }
        return view('admin.master.service-unit.add');
    }

    public function edit($id)
    {
        $data = ServiceUnit::findOrFail($id);

    }

    private function patch($data)
    {
        try {
            $data_request = [
                'name' => $this->postField('name')
            ];
            $data->update($data_request);
            return $this->jsonCreatedResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
