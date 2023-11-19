<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\DisasterType;

class DisasterTypeController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->request->ajax()) {
            $data = DisasterType::with([])->orderBy('name', 'ASC')->get();
            return $this->basicDataTables($data);
        }
        return view('admin.master.disaster-type.index');
    }

    public function store()
    {
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'name' => $this->postField('name'),
                ];
                DisasterType::create($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }
        }
        return view('admin.master.disaster-type.add');
    }

    public function patch($id)
    {
        $data = DisasterType::findOrFail($id);
        if ($this->request->method() === 'POST') {
            try {
                $data_request = [
                    'name' => $this->postField('name'),
                ];
                $data->update($data_request);
                return redirect()->back()->with('success', 'success');
            } catch (\Exception $e) {
                return redirect()->back()->with('failed', 'internal server error');
            }

        }
        return view('admin.master.disaster-type.edit')->with(['data' => $data]);
    }

    public function destroy($id)
    {
        try {
            DisasterType::destroy($id);
            return $this->jsonSuccessResponse('success');
        } catch (\Exception $e) {
            return $this->jsonErrorResponse('internal server error', $e->getMessage());
        }
    }
}
